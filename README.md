# ld2016
Materiale per il Linux Day Torino 2016 (Work In Progress)

TO-DO:
* Sito dell'evento
* Gestione prenotazioni CoderDojo
* Questionario sull'evento
* Materiale informativo per ruoli interni
* Registrazione talk

## Installazione sito web
Il sito web PHP+MySQL/MariaDB usa il framework Boz-PHP.

### Framework
Posizionare Boz-PHP da qualche parte, solitamente in `/usr/share`:

    bzr branch lp:boz-php-another-php-framework /usr/share/boz-php-another-php-framework

### Database
Una connessione MySQL/MariaDB è richiesta la tabella dei talk nella home page e per le API. È richiesta l'estensione `mysqli`.

Copiare `load-sample.php` in `load.php` (eventualmente popolando le credenziali di un database creato importando `database-schema.sql`).

Copiare `api/config-sample.php` in `api/config.php`.

### Localizzazione\lingua
Lanciare `./l10n/localize.sh .` almeno una volta per aggiornare il template GNU Gettext `.pot` e i relativi `.po` con le stringhe contenute nel codice sorgente dentro le funzioni `_()` ed `_e()`.

### API
In `api/schedule.xml` si trova l'elenco dei talk\eventi in formato XML (che alcuni chiamano Pentabarf, ma non è il formato Pentabarf, non ha nemmeno un nome in particolare).

Il file viene generato ogni volta che si esegue `api/tagliatella.php`. La tagliatella restituisce un codice HTTP 204 se è andato tutto bene, o un 500 e qualche uncaught exception se ci sono stati errori.
È possibile far restituire l'XML direttamente da `tagliatella.php` modificando le impostazioni in `api/config.php`.

## Multilingua
Il sito è multilingua grazie al pacchetto GNU Gettext (`php-gettext`). I file di lingua sono in `l10n/`.

### Cambiare lingua
Il sito controlla la lingua accettata dal browser web (l'header `Accept-Language`)! Eventuali richieste `GET`/`POST`/`COOKIE` con il parametro `l=en` (`en`, `it`, ecc.) scavalcano questa preferenza. La lingua italiana è predefinita.

### Migliorare lingua
Modificare il relativo `.po` con Poedit e lanciare due volte lo script `./l10n/localize.sh .`.

### Aggiunta lingua
Copiare il template GNU Gettext `.pot` in un nuovo file `.po` nel nuovo percorso di lingua (e.g.: `l10n/ru_RU.UTF-8/LC_MESSAGES/linuxday.po`) e modificare quest'ultimo con Poedit. Registrare la lingua in Boz-PHP modificando `load-post`. Lanciare due volte `./l10n/localize.sh .` per renderla operativa.

## Contributi
Ogni contributo avviene sotto i termini di una licenza compatibile con la licenza in calce. L'autore di un nuovo file ricopia l'intestazione della licenza da un file esistente. Autori/contributori si firmano nell'intestazione del file creato/modificato (o della parte creata/modificata) come detentori del diritto d'autore.

## License
This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
