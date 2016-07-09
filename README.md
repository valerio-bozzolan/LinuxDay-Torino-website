# ld2016
Materiale per il Linux Day Torino 2016 (Work In Progress)

TO-DO:
* Sito dell'evento
* Gestione prenotazioni CoderDojo
* Questionario sull'evento
* Materiale informativo per ruoli interni
* Registrazione talk

## Installazione sito web
Posizionare Boz-PHP da qualche parte, possibilmente in `/usr/share`:

    bzr branch lp:boz-php-another-php-framework /usr/share/boz-php-another-php-framework

Copiare `load-sample.php` in `load.php`.

### Multilingua
Verificare che sia installato il pacchetto `php-gettext` per iniziare a tradurre il sito.

Lanciare `./l10n/localize.sh` almeno una volta dopo modifiche alle stringhe per aggiornare il `.pot` e i `.po`. Usare Poedit per proporre miglioramenti nei file `.po` e lanciare nuovamente due volte lo script precedente per compilare i file `.po` in file `.mo`.

Per cambiare lingua basta cambiare la lingua del browser (cosa che varia l'header `Accept-Language`). Oppure si imposta il parametro `GET` `l=en` con i codice della lingua desiderato (va in fallback sulla lingua italiana).
