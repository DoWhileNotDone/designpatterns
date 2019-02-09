# Fix permissions after you run commands on both hosts and guest machine
if !Vagrant::Util::Platform.windows?
  system("
      if [ #{ARGV[0]} = 'up' ]; then
          echo 'Setting group write permissions for ./logs/*'
          chmod 775 ./logs
          chmod 664 ./logs/*
          echo 'Setting group write permissions for ./cache/*'
          chmod 775 ./cache
          chmod 664 ./cache/*
      fi
  ")
end

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.provider "virtualbox" do |v|
    v.memory = 2048
  end

  config.vm.box = "bento/ubuntu-18.04"
  config.vm.network "private_network", ip: "192.168.50.52"

  # Update apt packages
  config.vm.provision "shell", name: "apt", inline: <<-SHELL
    export DEBIAN_FRONTEND=noninteractive
    apt-get update && apt-get upgrade
    packagelist=(
      libssl1.0-dev
      libreadline-dev
      libyaml-dev
      libxml2-dev
      libxslt1-dev
      libnss3
      libx11-dev
      software-properties-common
      wget
      unzip
      curl
    )
    apt-get install -y ${packagelist[@]}
  SHELL

  config.vm.provision "shell", name: "install apache", inline: <<-'SHELL'
    apt-get install -y apache2
    #Allow port 80 through the firewall
    ufw allow 'Apache'
  SHELL

  #Make sure logs and cache folder is owned by apache with group vagrant
  config.vm.synced_folder "logs", "/vagrant/logs", owner: "www-data", group: "vagrant"
  config.vm.synced_folder "cache", "/vagrant/cache", owner: "www-data", group: "vagrant"

  config.vm.provision "shell", name: "install php", inline: <<-SHELL

    # PHP and modules
    # Not all these packages may be required, it is just a list of the most common
    phppackagelist=(
      php-pear
      php-dev
      php-zip
      php-curl
      php-xml
      php-xmlrpc
      php-xmlwriter
      php-mbstring
      php-pgsql
      php-pdo
      libapache2-mod-php
   )

   apt-get install -y php
   apt-get install -y ${phppackagelist[@]}
  SHELL

  # Install Composer
  config.vm.provision "shell", name: "install composer", privileged: false, inline: <<-SHELL
     cd /vagrant && curl -sS https://getcomposer.org/installer | php
  SHELL

  #Update Apache config and restart
  config.vm.provision "shell", name: "configure apache", inline: <<-'SHELL'

    # Symlink DocumentRoot o \Vagrant\Public
    ln -s /vagrant/public /var/www/html/DocumentRoot

    sed -i -e "s/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/html\/DocumentRoot/" /etc/apache2/sites-enabled/000-default.conf
    sed -i -e "s/AllowOverride None/AllowOverride All/" /etc/apache2/apache2.conf

    a2enmod rewrite
    apachectl restart
    # Make sure Apache also runs after vagrant reload
    systemctl enable apache2
  SHELL

  #Install project composer dependencies
  config.vm.provision "shell", name: "run composer", privileged: false, inline: <<-SHELL
    cd /vagrant && php composer.phar install --no-suggest --no-progress
  SHELL

  #Install project npm dependencies
  config.vm.provision "shell", name: "install nvm and node", privileged: false, inline: <<-SHELL
    export DEBIAN_FRONTEND=noninteractive
    cd && curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash
    export NVM_DIR="$HOME/.nvm"
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
    [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion
    nvm install node
    nvm use node
    cd /vagrant && npm install
    npm install -g gulp
    cd /vagrant && gulp vagrant
  SHELL

  # Use the provided example environment
  config.vm.provision "shell", name: "environment", inline: <<-SHELL
    cd /vagrant && cp .env.example .env
  SHELL

  config.vm.post_up_message = <<MESSAGE

   You are now up and running.

   The URL is 192.168.50.52

MESSAGE

end
