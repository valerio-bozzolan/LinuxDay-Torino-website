%title: Corso GNU/Linux base
%date: 2016-11-30

-> # Manutenzione di un sistema basato su Debian <-

^
-> ## Ma perchè Debian? <-

-> ¯\\_(ツ)_/¯ <-

^
-> https://commons.wikimedia.org/wiki/File:GNU_Linux_Distribution_Timeline_12-2.svg <-

---

-> # Prima di Debian... <-

Come installo `nsnake`? 
^

README: *Simple* installation instructions for the game "nsnake":
* Install glibc
* Move this into something as /usr/src.
* Untar the source
* Run `sh ./configure` and `make` as root
* Configure properly /etc/nsnake.conf and have fun

^
(╯°□°)╯︵ ┻━┻

---

-> # Con Debian <-

-> Advanced Packaging Tool <-

Come installo `nsnake`?
^

	apt-get install nsnake
^

ᕕ( ᐛ )ᕗ

---

-> Parliamo della stessa cosa <-

	apt-get install nsnake

	apt install nsnake

	aptitude install nsnake

	dpkg -i nsnake.deb

...e c'è anche `Synaptic`.

---

-> Pacchetti e dipendenze <-

-> .exe \!= .deb <-

^
Ad esempio...

* libopencv-dev.exe per Microsoft Windows: 279 MegaByte
^
* libopencv-dev.deb per Debian:            180 KyloByte

Perchè?

---

-> Il potere della dipendenza ʕ•ᴥ•ʔ <-

-> 100 programmi: 1 libreria <-
^
-> Non 100 programmi con 100 librerie! <-
^

---

-> # Domanda <-

-> Se tale libreria avesse... un problemino di sicurezza? <-

Es: "Open Type Font Remote Code Execution Vulnerability"
CVE-2016-7256 (*28 novembre*)

---

-> # Domanda <-

-> Se tentassi di eliminare una libreria? (es: `libc6`) <-

---

-> # Domanda <-

-> Se eliminassi un programma che fine fanno le sue librerie? <-
^

	apt-get autoremove

^
E passa la paura \\( ﾟヮﾟ)/

---

-> # Da dove vengono i pacchetti? <-

                       .-.
        .-""`""-.    |(@ @)
     _/`oOoOoOoOo`\_ \ \-/
    '.-=-=-=-=-=-=-.' \/ \
      `-=.=-.-=.=-'    \ /\
         ^  ^  ^       _H_ \

---

-> # Da dove vengono i pacchetti? <-

Debian non è una:
* unstable (sid)
^
	* Tutto il più recente (il più instabile!)
	* *NON* fatene un server!
^
* testing (stretch)
^
	* Se *non* introduce bug per 2-10 giorni
^
* stable (jessie)
^
	* Production approved! *<3*
^
* oldstable (wheezy)
^
	* Security ~1 anno
^
* jessie-backports, etc.

---

-> Quale Debian scegliere? <-
^

-> *STABLE* <-
-> *STABLE* *STABLE* <-
-> *STABLE* *STABLE* *STABLE* <-
-> *STABLE* *STABLE* <-
-> *STABLE* <-
^

Sì, stable.
	
---


-> # Provenienza <-

Sia che sia oldstable, stable, testing, o unstable...

* Main
	* Only Free as in Freedom
* Contrib
	* Only Free as in Freedom... with non-free dependence
* Non-Free
	* Restricting use or redistribution

    /etc/apt/sources.list
