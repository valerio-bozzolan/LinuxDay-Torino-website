# Linux Day Torino website
![Linux Day Torino](https://raw.githubusercontent.com/0iras0r/ld2016/master/2016/static/linuxday-64.png)

Materiale per il Linux Day Torino dal 2016 al 2019.

## Installazione sito web
Il sito web vuole permettere l'indipendenza dei temi grafici dei vari anni di ogni Linux Day Torino, centralizzandone le informazioni.

È utilizzata la combinazione PHP+MySQL/MariaDB usando il framework [suckless-php](https://github.com/valerio-bozzolan/suckless-php).

## Quick start Hacking

To start hacking in this website we suggest the installation of `vagrant`. You should know how to install this package.

Then, just:

	vagrant up

## Bare-metal installation

If you don't want to use Vagrant, note that this website is designed to be a very simple PHP/MySQL project and it's very easy to be deployed in both Apache and nginx. You should know what to do, but here you are an example in Debian GNU/Linux.

### Debian GNU/Linux

On a Debian GNU/Linux `stable` system (actually tested on stretch) install a webserver and a MysQL database server:

    apt-get install apache2 mariadb-server php5 php5-mysql libapache2-mod-php5 libjs-jquery libjs-leaflet libmarkdown-php
    a2enmod rewrite
    service apache2 reload

Place the project files in the `DocumentRoot` of your Apache `VirtualHost`.

    cd /var/www/linuxday
    git clone [https://... this repo]

Then copy our example Apache configuration file [`htaccess.txt`](documentation/apache/htaccess.conf) as `/.htaccess` (yes, in your DocumentRoot).

### Hardening

The website can be kept in read-only mode for the webserver user and nothing more:

    chown root:www-data -R /var/www/linuxday
    chmod o=            -R /var/www/linuxday

Also you may want to declare the `open_basedir` to your DocumentRoot plus `/usr/share/php`.

### URL rewrite

If you want to serve the website from a subdirectory, you can. Just change your `/.htaccess` to fit your needs:

    RewriteBase /subdirectory

Then change the related configuration constant from your `/load.php` file to have not link rots:

    define( 'ROOT', '/subdirectory' );

### Database

Create an empty database and import the [`database-schema.sql`](documentation/database/database-schema.sql) file.

Now copy the `load-example.php` in a new file called `load.php` and insert there your database credentials etc.

You can choose a different table prefix declaring the `$prefix` variable in your `load.php` file.

### Install suckless-php

Place the suckless-php framework somewhere. We like in the `/includes` directory:

    # apt-get install git
    cd includes
    git clone https://github.com/valerio-bozzolan/suckless-php

### API

The websites has an API callled _tagliatella_ that can generate a valid XML document containing all the talks/events (in a formato that someone call Pentabarf, but it's not the Pentabarf - really this stupid format has no even an official name).

The _tagliatella_ gives an HTTP Status Code 500 and some other uncaught exceptions if an error raises.

## Internationalization

Il sito è multilingua grazie a GNU Gettext. GNU Gettext è un software un po' anziano ma decisamente rispettabile e adottato da tutti i principali CMS a cui puoi pensare. Riassumere il workflow di GNU Gettext in poche righe confonderebbe soltanto, quindi passiamo al sodo.

Per cambiare una stringa italiana, cambiala dal database o dal codice sorgente.

Quando poi hai deciso di voler tradurre il progetto così com'è:

	# Exporting database strings to source code
	vagrant ssh
	cd /vagrant
	./l10n/mieti.php > ./l10n/trebbia.php
	
	# Export source code to GNU Gettext template (.pot)
	./l10n/localize.php .
	
	# Export GNU Gettext template (.pot) in files for Poedit (.po)
	/l10n/localize.php .
	exit

A questo punto sfodera Poedit e traduci tutti i .po che desideri.

I file `.po` sono situati nella directory `2016/l10n/`.

Per vedere il risultato in funzione (indovina un po'?):

    # Compile Poedit files (.po) to binary GNU Gettext files (.mo)
    ./2016/l10n/localize.php .

### Cambiare lingua
Il sito effettua content negotiation controllando la lingua accettata dal browser web (l'header `Accept-Language`) o eventuali richieste `GET`/`POST`/`COOKIE` con il parametro `l=$lingua` (`en`, `it`, ecc.). La lingua italiana è predefinita.

### Aggiunta lingua
Copiare il template GNU Gettext `2016/l10n/linuxday.pot` in un nuovo file `.po` nel nuovo percorso di lingua (e.g.: `./$ANNO/l10n/ru_RU.utf8/LC_MESSAGES/linuxday.po`) e modificare quest'ultimo con Poedit. Registrare la lingua in Boz-PHP modificando `./2016/load.php` e rieffettuare i passi della sezione [multilingua](#multilingua).

## Backend

Per poter accedere al backend occorre registrarsi:

	./cli/add-user.php --uid=mario.rossi --role=admin --pwd=password

Effettuare poi il login nella pagina `2016/login.php`.

## Esportazione del database
**Nota**: a differenza del codice sorgente il database in questo repository è da considerarsi **read-only** ed è **molto meglio contattare il webmaster** invece che variarne i contenuti direttamente.

In ogni caso:

	vagrant ssh
	/vagrant/Vagrant/pull-database.php
	exit

## Aggiornamento del database

	vagrant ssh
	/vagrant/cli/upgrade.php
	exit

## Contributi
Ogni contributo avviene sotto i termini di una licenza compatibile con la licenza in calce. L'autore di un nuovo file ricopia l'intestazione della licenza da un file esistente. Autori/contributori si firmano nell'intestazione del file creato/modificato (o della parte creata/modificata) come detentori del diritto d'autore.

## Licenza
Salvo ove diversamente specificato, il progetto appartiene ai contributori di Linux Day Torino ed è distribuito sotto licenza [GNU Affero General Public License](LICENSE.md). Eccezione soprattutto per alcuni loghi dei vari partner, che appartengono ai legittimi proprietari e sono concessi in licenza esclusiva a Linux Day Torino, ed ad alcuni temi grafici degli anni 2015 e precedenti.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
