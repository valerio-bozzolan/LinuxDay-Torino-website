# ld2016
Materiale per il Linux Day Torino 2016 (Work In Progress)

TO-DO:
* Sito dell'evento
* Gestione prenotazioni CoderDojo
* Questionario sull'evento
* Materiale informativo per ruoli interni
* Registrazione talk

## Installazione sito web
Il sito web vuole permettere la decentralizzazione dei temi grafici dei vari Linux Day Torino, centralizzandone i contenuti.

È utilizzata la combinazione PHP+MySQL/MariaDB usando il framework Boz-PHP.

Vengono utilizzati jQuery e LeafLet e si assume che siano installati attraverso il proprio gestore di pacchetti.

Per un'installazione della maggior parte delle componenti su un sistema Debian:

    apt-get install apache2 mariadb-server php5 php5-mysql libapache2-mod-php5 libjs-jquery libjs-leaflet

Il file `.htaccess` è testato includendolo direttamente nel VirtualHost di Apache tramite la direttiva `Include`:

    <Virtualhost ...>
        ...

        <Directory /var/www/linuxdaytorino/>
            Include /var/www/linuxdaytorino/.htaccess
        </Directory>
    </Virtualhost>

Il sito può rimanere in sola-lettura per l'utente `www-data`.

### Framework
Posizionare Boz-PHP da qualche parte, solitamente in `/usr/share`:

    bzr branch lp:boz-php-another-php-framework /usr/share/boz-php-another-php-framework

Oppure modificare oppurtunatamente `load.php` con il percorso scelto per il framework.

### Database
È richiesta una connessione MySQL/MariaDB (con estensione `mysqli`).

Creare un database importandovi `database-schema.sql` e inserendo le credenziali nel file `load.php`.

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
Modificare il relativo `.po` con Poedit e lanciare due volte lo script [#multilingua].

### Aggiunta lingua
Copiare il template GNU Gettext `*/l10n/linuxday.pot` in un nuovo file `.po` nel nuovo percorso di lingua (e.g.: `./$ANNO/l10n/ru_RU.UTF-8/LC_MESSAGES/linuxday.po`) e modificare quest'ultimo con Poedit. Registrare la lingua in Boz-PHP modificando `./$ANNO/load.php`. Lanciare due volte lo script in [#multilingua] per renderla operativa.

## Contributi
Ogni contributo avviene sotto i termini di una licenza compatibile con la licenza in calce. L'autore di un nuovo file ricopia l'intestazione della licenza da un file esistente. Autori/contributori si firmano nell'intestazione del file creato/modificato (o della parte creata/modificata) come detentori del diritto d'autore.

## Licenza
Salvo ove diversamente specificato, il progetto appartiene ai contributori di Linux Day Torino ed è distribuito sotto licenza [GNU Affero General Public License](https://www.gnu.org/licenses/agpl-3.0.html). Eccezione soprattutto per alcuni loghi dei vari partner, che appartengono ai legittimi proprietari e sono concessi in licenza esclusiva a Linux Day Torino.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
