# ld2016
Materiale per il Linux Day Torino 2016 (Work In Progress)

TO-DO:
* Sito dell'evento
* Gestione prenotazioni CoderDojo
* Questionario sull'evento
* Materiale informativo per ruoli interni
* Registrazione talk

## Installazione sito web
Il sito web vuole permettere l'indipendenza dei temi grafici dei vari anni di ogni Linux Day Torino, centralizzandone le informazioni.

È utilizzata la combinazione PHP+MySQL/MariaDB usando il framework Boz-PHP.

### Preparazione
Vengono utilizzati jQuery e LeafLet e si assume che siano installati attraverso il proprio gestore di pacchetti.

Per un'installazione della maggior parte delle componenti su un sistema Debian:

    apt-get install apache2 mariadb-server php5 php5-mysql libapache2-mod-php5 php-gettext libjs-jquery libjs-leaflet

### File
Clonare i file di questo progetto direttamente nella directory del proprio `VirtualHost` di Apache.

    cd /var/www/linuxday
    git clone [questo repo] .

Il sito ha un file `.htaccess`. Assicurarsi di avere il modulo Apache `rewrite` abilitato:

    a2enmod rewrite
    service apache2 reload

Il sito può rimanere in sola lettura per l'utente Apache:

    chown root:www-data -R /var/www/linuxday
    chmod 750           -R /var/www/linuxday

### Database
Creare un database e importare `database-schema.sql`.

Copiare il file di configurazione di default `load-sample.php` in `load.php` e inserire in quest'ultimo le credenziali del database.

### Framework
Posizionare il framework Boz-PHP:

    # apt-get install bzr
    bzr branch lp:boz-php-another-php-framework /usr/share/boz-php-another-php-framework

Se il framework viene posizionato in un altro posto, modificare oppurtunatamente `load.php`.

### API
Copiare `includes/api/config-sample.php` in `includes/api/config.php`.

Le API possono generare il file `includes/api/schedule.xml` che contiene l'elenco dei talk/eventi in formato XML (che alcuni chiamano Pentabarf, ma non è il formato Pentabarf, non ha nemmeno un nome in particolare).

Il file viene generato ogni volta che si esegue `includes/api/tagliatella.php`. La tagliatella restituisce un codice HTTP 204 se è andato tutto bene, o un 500 e qualche uncaught exception se ci sono stati errori.
È possibile far restituire l'XML direttamente da `includes/api/tagliatella.php` modificando le impostazioni in `includes/api/config.php`.

## Multilingua
Il sito è multilingua grazie al pacchetto GNU Gettext (`php-gettext`). I file di lingua sono in `*/l10n/`.

I file di localizzazione `.pot` e `.po` contengono le stringhe contenute nel codice sorgente dentro le funzioni `_()` ed `_e()`. I file `.mo` sono il compilato dei relativi file `.po`. Tutti questi file vengono aggiornati lanciando il comando:

    ./$ANNO/l10n/localize.sh .

È meglio lanciare il comando due volte. Questo fa sì che la prima volta si aggiornino i file `.pot` e `.po`. La seconda volta si è sicuri che i file `.mo` siano compilati dall'ultima versione dei file `.po`.

### Cambiare lingua
Il sito controlla la lingua accettata dal browser web (l'header `Accept-Language`). Eventuali richieste `GET`/`POST`/`COOKIE` con il parametro `l=en` (`en`, `it`, ecc.) scavalcano questa preferenza. La lingua italiana è predefinita.

### Migliorare lingua
Modificare il relativo `.po` con Poedit e lanciare due volte lo script [multilingua](#multilingua).

### Aggiunta lingua
Copiare il template GNU Gettext `*/l10n/linuxday.pot` in un nuovo file `.po` nel nuovo percorso di lingua (e.g.: `./$ANNO/l10n/ru_RU.UTF-8/LC_MESSAGES/linuxday.po`) e modificare quest'ultimo con Poedit. Registrare la lingua in Boz-PHP modificando `./$ANNO/load.php`. Lanciare due volte lo script in [multilingua](#multilingua) per renderla operativa.

## Contributi
Ogni contributo avviene sotto i termini di una licenza compatibile con la licenza in calce. L'autore di un nuovo file ricopia l'intestazione della licenza da un file esistente. Autori/contributori si firmano nell'intestazione del file creato/modificato (o della parte creata/modificata) come detentori del diritto d'autore.

## Licenza
Salvo ove diversamente specificato, il progetto appartiene ai contributori di Linux Day Torino ed è distribuito sotto licenza [GNU Affero General Public License](https://www.gnu.org/licenses/agpl-3.0.html). Eccezione soprattutto per alcuni loghi dei vari partner, che appartengono ai legittimi proprietari e sono concessi in licenza esclusiva a Linux Day Torino.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
