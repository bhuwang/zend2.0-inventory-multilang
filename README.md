Zend 2.0 sample inventory CRUD application
==========================================

Introduction
------------
This is a simple, Inventory management application using the ZF2 skeleton MVC layer and module
systems. This application is meant to be used as a starting place for those
looking to get their feet wet with ZF2. The application support two major languages English and Nepali.

Installation
---------------------------

You should have the following details to up and running.

Database deails:
Name: inventory
User: root
Pass: liferay

or you can simply change config/autoload/local.php and config/autoload/global.php file.

### Language Support

The application supports two major languages English and Nepali. Two change the language you can just change the file below.

File Path:
module/Application/config/module.config.php

Change the translator section of the file.

for English: en_US
for Nepali: ne_NP


### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-app.localhost
        DocumentRoot /path/to/zf2-app/public
        <Directory /path/to/zf2-app/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
            <IfModule mod_authz_core.c>
            Require all granted
            </IfModule>
        </Directory>
    </VirtualHost>
