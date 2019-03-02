## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar install` to install all dependencies. 
   'composer.phar' is the file we downloaded from step 1 which is present in folder where this readme.md file
    is present.

## Configuration

Read and edit `config/app.php` and setup the 'Datasources' and any other
configuration relevant for your application.

###running server
0. use the ttar.sql dump file for schema 
1. cd into webroot
2. ../bin/cake server [optionally specify host, port]
3. it won't run if some php extensions are missing e.g. intl, mbstring, so install them
