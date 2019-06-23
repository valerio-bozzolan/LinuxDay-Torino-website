<?php
# Linux Day 2016 - Credits
# Copyright (C) 2016, 2017 Valerio Bozzolan, Rosario Antoci, Linux Day Torino
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

require 'load.php';

inject_in_module('header', function() {
	echo "\n\t<style>.libre-icon {min-height: 120px}</style>";
} );

Header::spawn('credits');
?>
	<div class="section">
		<p class="flow-text"><?= __("Di seguito sono riportati gli elementi utilizzati in questo sito, tra i migliori esempi di <strong>software libero</strong> e <strong>open source</strong>.") ?></p>
	</div>

	<div class="section">
		<div class="row">
		<?php
		CreditBox::spawn(
			"Debian GNU/Linux",
			'https://debian.org',
			'gnu-gpl',
			__("Sistema operativo del server web."),
			'debian.png'
		);
		CreditBox::spawn(
			"Apache",
			'https://httpd.apache.org',
			'apache',
			__("Server web."),
			'apache.png'
		);
		CreditBox::spawn(
			"PHP5",
			'http://php.net',
			'php',
			__("Pre-processore di ipertesti."),
			'php.png'
		);
		CreditBox::spawn(
			"MariaDB",
			'https://mariadb.org',
			'gnu-gpl-v2',
			__("MySQL guidato dalla comunità."),
			'mariadb.png'
		);
		CreditBox::spawn(
			"MySQL",
			'http://www.mysql.com',
			'gnu-gpl-v2',
			__("Database SQL relazionale."),
			'mysql.png'
		);
		CreditBox::spawn(
			"GNU Gettext",
			'https://www.gnu.org/software/gettext/',
			'gnu-gpl',
			__("Framework per internazionalizzazione e localizzazione dei messaggi."),
			'gnu.png'
		);
		CreditBox::spawn(
			"Boz-PHP",
			'https://launchpad.net/boz-php-another-php-framework',
			'gnu-agpl',
			__("Framework PHP e MySQL/MariaDB."),
			'boz.png'
		);
		CreditBox::spawn(
			"Let's Encrypt",
			'https://certbot.eff.org',
			'apache',
			__("Certificato SSL."),
			'lets-encrypt.png'
		);
		CreditBox::spawn(
			"jQuery",
			'http://jquery.com',
			'jquery',
			__("Framework JavaScript."),
			'jquery.png'
		);
		CreditBox::spawn(
			"Leaflet",
			'http://leafletjs.com',
			'bsd-2',
			__("Framework JavaScript per mappe interattive"),
			'leaflet.png'
		);
		CreditBox::spawn(
			"Materialize",
			'https://github.com/Dogfalo/materialize',
			'mit',
			__("Framework CSS e JavaScript in stile Material Design."),
			'materialize.png'
		);
		CreditBox::spawn(
			"Roboto 2.0",
			'https://www.google.com/fonts/specimen/Roboto',
			'apache',
			__("Famiglia di caratteri."),
			'roboto.png'
		);
		CreditBox::spawn(
			"Material Design Icons",
			'http://google.github.io/material-design-icons/',
			'cc-by',
			__("Collezione di icone Material Design."),
			'material.png'
		);
		CreditBox::spawn(
			"Inkscape",
			__('https://inkscape.org/it/'),
			'gnu-gpl-v2',
			__("Programma per disegno vettoriale."),
			'inkscape.png'
		);
		CreditBox::spawn(
			"GIMP",
			__('https://www.gimp.org'),
			'gnu-gpl',
			__("Fotoritocchi e modifiche alle immagini"),
			'gimp.png'
		);
		CreditBox::spawn(
			"GNU Nano",
			'https://www.nano-editor.org',
			'gnu-gpl',
			__("Banale editor di testo da terminale."),
			'gnu-nano.png'
		);
		CreditBox::spawn(
			"OpenStreetMap",
			'http://www.openstreetmap.org',
			'odbl',
			__("Mappa planetaria libera"),
			'osm.png'
		);
		CreditBox::spawn(
			"Git",
			'https://git-scm.com',
			'gnu-gpl-v2',
			__("Controllo versione distribuito"),
			'git.png'
		);
		CreditBox::spawn(
			"Attendize",
			'https://www.attendize.com',
			'aal',
			__("Event manager open source"),
			'attendize.jpg'
		);
		CreditBox::spawn(
			"YOURLS",
			'https://yourls.org',
			'mit',
			__("Your Own Url Shortener"),
			'yourls.png'
		);
		CreditBox::spawn(
			"W3C Validator",
			'https://validator.w3.org',
			'mit',
			__("Validatore standard HTML, JavaScript e CSS"),
			'w3c.png'
		);
		CreditBox::spawn(
			"F-Droid",
			'https://f-droid.org',
			'gnu-gpl-v3',
			__("Catalogo di software libero per Android"),
			'f-droid.png'
		);
		?>
		</div>
	</div>

	<div id="clone" class="divider"></div>
	<p><?php printf(
		__("Il codice sorgente del sito è distribuito sotto licenza libera %s. Clonalo!"),
		license('gnu-agpl')->getLink()
	) ?></p>
	<div class="row">
		<div class="col s12 m6">
			<blockquote class="hoverable"><code>git clone <?= REPO ?></code></blockquote>
		</div>
	</div>

	<div id="media" class="divider"></div>
	<div class="section">
		<h3><?= __("Materiale") ?></h3>

		<ul class="collection">
			<?php $thanks = function($to, $toURL, $what, $url, $license) { ?>
			<?php $license = license($license) ?>
			<li class="collection-item"><?php printf(
				__("Grazie a %s per %s sotto licenza %s."),
				HTML::a($toURL, $to),
				HTML::a($url, $what),
				HTML::a( $license->getURL(), $license->getShort() )
			) ?></li>
			<?php }; ?>

			<?php
			$thanks(
				"User:VGrigas (WMF)",
				'https://commons.wikimedia.org/wiki/User:VGrigas_%28WMF%29',
				__("l'immagine estratta dal suo video «This is Wikipedia»"),
				'https://commons.wikimedia.org/wiki/File:This_is_Wikipedia.webm',
				'cc-by-sa-3.0'
			);
			$thanks(
				"Rui Damas",
				'https://www.gnu.org/graphics/gnu-slash-linux.html',
				__("l'immagine predefinita di alcuni elementi"),
				DEFAULT_IMAGE,
				'gnu-gpl'
			);
			?>
		</ul>
	</div>
<?php

Footer::spawn( ['home' => false] );
