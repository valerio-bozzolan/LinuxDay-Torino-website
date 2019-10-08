# Linux Day Torino's website
![Linux Day Torino](https://raw.githubusercontent.com/0iras0r/ld2016/master/2016/static/linuxday-64.png)

Content Management System for the __Linux Day Torino__ event, but just from 2016 to 2019 (and beyond we hope!).

The [Linux Day](https://www.linuxday.it/) is a yearly Italian event were Italian cities organize free conferences for everyone, talking about GNU/Linux, Free software, open source, and we meet amazing new friends.

The [Linux Day Torino](https://linuxdaytorino.org/) is just our local implementation, and this project is the related website.

## Introduction

This project allow the centralization of various informations during a set of conferences, while allowing completly different themes for each conference.

This project is designed using GNU/Linux, Apache/nginx, PHP, MySQL/MariaDB and the [suckless-php](https://github.com/valerio-bozzolan/suckless-php) framework.

We use PHP. Because _PHP does not suck_. PHP it's the best hypertext preprocessor available. It's well-tested; well-known; well-documented; multi-platform; easy to be deployed; powerful; actively developed since 20 years and if you know how to code, it's also drammatically fast and secure.

Note that, thanks to PHP, this website has no third party dependency. I mean we use just a stupid framework made by us (10 files). __No Laravel__. No therabytes of NodeJS dependencies. No silly crap. Just this website. So, before talking bad about PHP, shut up. You are a troll. Think about your crapware-hipster-NodeJS/whateverbetter project full of shitty dependencies you do not know how to maintain, kiddo.

PHP loves you. Do not be bad with it. :^)

## Quick start Hacking

To start hacking on this project we suggest the installation of `vagrant` to reproduce our production environment quickly. You should know how to install this package from your favourite GNU/Linux distribution. Then, just run:

	vagrant up

Then simply follow the instructions from your terminal.

## Keep project up-to-date

Too keep the project updated, just run:

	git pull
	vagrant provision

## Quick start on Arch Linux (or anything other than Debian GNU/Linux)

The virtual machine does not work with VirtualBox. It is also incompatible with Vagrant rsync synced folders. You have to install libvirt, any packages required for NFS and firewalld because libvirt requires a firewall for no apparent reason and the firewall *has* to be firewalld. Which by default blocks libvirt machines from accessing NFS.

You need a few packages and a Vagrant plugin:

```bash
pacman -S nfs-utils libvirt firewalld
vagrant plugin install vagrant-libvirt
```

Then, to start the VM:

```bash
systemctl start libvirtd firewalld nfs-server rpcbind
firewall-cmd --zone=libvirt --add-service=nfs
firewall-cmd --zone=libvirt --add-service=mountd
firewall-cmd --zone=libvirt --add-service=rpc-bind
vagrant up --provider=libvirt
```

The `firewall-cmd` commands can be made permanent with `--permanent`.

## Bare-metal installation

If you don't want to use Vagrant, you can just install Apache or nginx and a MySQL server and run this project as you know.

In this case follow the installation instructions for Debian GNU/Linux and adapt it to your needs.

### Bare-metal installation (Debian GNU/Linux)

On a Debian GNU/Linux `stable` system (actually tested on `stretch`) install a webserver (Apache or nginx, is your choice) and a MysQL database server and some other additional packages:

    apt install apache2 mariadb-server php php-mysql libapache2-mod-php libjs-jquery libjs-leaflet libmarkdown-php
    a2enmod rewrite
    service apache2 reload

Place the project files somewhere, available to your webserver:

	cd /var/www/linuxday
	git clone [https://... this repo]

Copy the example [Apache configuration file](documentation/apache/htaccess.conf) and save it as `.htaccess` (e.g. `/var/www/linuxday/.htaccess`). Or if you want nginx obviously we have an [nginx configuration example](documentation/nginx/locations.conf).

Remember to change the `DocumentRoot` of your Apache configuration file to respect your pathname (e.g. `/var/www/linuxday`).

Create an empty database with a dedicated user. Then copy the [load-example.php](load-example.php) in a new file called `load.php` and type there your database credentials. Populate your database with the [database-schema.sql](documentation/database/database-schema.sql).

Place [suckless-php](https://github.com/valerio-bozzolan/suckless-php) somewhere. It is our laser-cannon framework. It consists in just ~23 files.
You can put it in the `includes` directory of the project:

    # apt-get install git
    cd includes
    git clone https://github.com/valerio-bozzolan/suckless-php

Now everything should work.

### Hardening your bare-metal installation

The website can be kept in read-only for the webserver user, and nothing more. E.g.:

    chown root:www-data -R /var/www/linuxday
    chmod o=            -R /var/www/linuxday

You may also want to declare the PHP `open_basedir` directive to the value of `/var/www/linuxday:/usr/share/php` and nothing more to restrict the access to just these files.

Also you can disable all the unused system calls like `exec()` etc.

### Installation in a custom subdirectory

If you want to serve the website from a subdirectory, you can. Just change your `.htaccess` file to fit your needs. Example:

	# RewriteBase /
	RewriteBase /linuxday

In this case also change the related project `ROOT` from your `load.php` file:

	# define( 'ROOT', '' );
	define( 'ROOT', '/linuxday' );

## Database import

To just reset your database to the latest version, just run:

	git pull
	vagrant provision

Or just import the [database-schema.sql](documentation/database/database-schema.sql).

## Database export

When you want to export and commit the database, just run:

	vagrant ssh
	/vagrant/Vagrant/pull-database.sh
	exit
	
	git status
	# ...

### API

The website exposes some REST-ful APIs.

The one called _tagliatella_ generates a valid XML document containing all the talks/events (in a format that someone call Pentabarf, but it's not the Pentabarf - really, this stupid format has not even an official name). The _tagliatella_ API gives an HTTP Status Code 500 and some other uncaught exceptions if an error raises.

The one called _tropical_ generates a valid `iCal` document to import an Event or a Conference in your favourite calendar client.

## Internationalization

The website interface (plus some parts of the content) is internationalized thanks to GNU Gettext. GNU Gettext is both a software and a standard. This is not the place to learn GNU Gettext, but this is how you can use it.

### Translate a string 

You can edit the `.po` file with Poedit to translate some strings to a language:

* [English](l10n/en_US.utf8/LC_MESSAGES/linuxday.po)

To apply your changes:

	vagrant provision

Or:

	vagrant ssh
	cd /vagrant
	./l10n/localize.php .
	./l10n/localize.php .
	exit

Note that if you change the database contents you may also need this command before the above one:

	vagrant ssh
	cd /vagrant
	./l10n/mieti.php > ./l10n/trebbia.php

That's all.

### Translate in a new language

Copy the [GNU Gettext template](l10n/linuxday.pot) in a new pathname similar to the English one, and also rename it to the `.po` extension.

Then in the [load-post.php](includes/load-post.php) file you can add another `register_language()` line.

## Backend

To access to the backend follow the instructions on your terminal when running:

	vagrant provision

Or create an User with:

	./cli/add-user.php --uid=root --role=admin --pwd=secret

The login page is actually situated in `2016/login.php`.

## License

(c) 2015 Linux Day contributors, 2016-2019 [Valerio Bozzolan](https://boz.reyboz.it/), [Ludovico Pavesi](https://github.com/lvps), [Rosario Antoci](https://linuxdaytorino.org/2019/user/oirasor), Linux Day contributors

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the [GNU Affero General Public License](LICENSE.md) for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.

Thank you for forking this project!

Contributions are welcome! If you do any non-minor contribution you are welcome to put your name in the copyright header of your touched file.
