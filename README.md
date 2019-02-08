# Design Patterns Practice

## Overview

The original intent was to mock up some of the design patterns, to re-familiarise myself with them.
There has been a detour en-route as I delve into gulp/sass/node - things I am used to using, but haven't had personal experience in setting up for a project.

Tools used:

- [Slim 3](https://www.slimframework.com/)
- [DotEnv](https://github.com/vlucas/phpdotenv)
- [PHP](http://php.net/)
- [Vagrant](https://www.vagrantup.com/)
- [Apache](https://httpd.apache.org/)
- [PHPUnit](https://phpunit.de/)
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)
- [Node/NPM](https://nodejs.org/)
- [NVM](https://github.com/creationix/nvm)
- [Gulp](https://gulpjs.com/)
- [SASS](https://sass-lang.com/guide)

Running Instructions are to be found below.

## Server Running Instructions - Vagrant

Requires Vagrant and a Virtualisation Engine

https://www.vagrantup.com/downloads.html
https://www.virtualbox.org/wiki/Downloads

Once installed, you can navigate to the root directory of this project (with the VagrantFile), and run
```
vagrant up
```
This will provision a vagrant server with ubuntu, php, the slim framework, and all the other required bits and bobs.

All being well with the vagrant provisioning, you should reach the 'Vagrant Up' message, and there are no exit codes reported.

## Source

This project was started from an existing slim framework of mine, and modified to suit. The guides are mostly those generally found online.

The design patterns are based on the teachings contained in http://shop.oreilly.com/product/9780596007126.do


## Server Running Instructions

To SSH onto the running server, from the directory root use:

```
vagrant ssh
```

The URL is 192.168.50.52

## Testing

For PHPUnit, run this command in the application directory to run the test suite
```
	php composer.phar test
```
