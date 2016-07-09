<?php
# Copyright (C) 2016 Valerio Bozzolan
#
# Linux Day 2016 - Credits
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

require 'load.php';

the_header('credits', ['container' => false] );
?>
	<div class="section">
		<div class="container">
			<p class="flow-text"><?php _e("Questo sito web utilizza esclusivamente <strong>software libero</strong>.") ?></p>
		</div>

		<?php $tech = function($name, $url, $license, $desc) {
			$license = license($license); ?>
			<div class="col s12 m6 l3">
				<div class="card-panel">
					<h3><?php printf("<strong>%s</strong><br /> <small>(%s)</small>",
						HTML::a( $url, $name ),
						HTML::a( $license->getURL(), $license->getShort(), $license->getName() )
					) ?></h3>
					<p><?php echo $desc ?></p>
				</div>
			</div>
		<?php }; ?>

		<div class="row">
		<?php
			$tech(
				"Debian GNU/Linux",
				'https://debian.org',
				'gnu-gpl',
				_("Sistema operativo del server web.")
			);
			$tech(
				"Apache 2.0",
				'https://httpd.apache.org',
				'apache',
				_("Server web.")
			);
			$tech(
				"PHP5",
				'http://php.net',
				'php',
				_("Pre-processore di ipertesti.")
			);
			$tech(
				"GNU Gettext",
				'https://www.gnu.org/software/gettext/',
				'gnu-gpl',
				_("Framework per internazionalizzazione e localizzazione dei messaggi.")
			);
			$tech(
				"Boz-PHP",
				'https://launchpad.net/boz-php-another-php-framework',
				'gnu-agpl',
				_("Framework PHP e MySQL/MariaDB.")
			);
			$tech(
				"Let's Encrypt",
				'https://certbot.eff.org/',
				'apache',
				_("Certificato SSL.")
			);
			$tech(
				"Materialize",
				'https://github.com/Dogfalo/materialize',
				'mit',
				_("Framework CSS e JavaScript in stile Material Design.")
			);
			$tech(
				"Roboto 2.0",
				'https://www.google.com/fonts/specimen/Roboto',
				'apache',
				_("Famiglia di caratteri.")
			);
			$tech(
				"Material Design Icons",
				'http://google.github.io/material-design-icons/',
				'cc-by',
				_("Collezione di icone Material Design.")
			);
			$tech(
				"OpenStreetMap",
				'http://www.openstreetmap.org',
				'odbl',
				_("Mappa del Dipartimento di Informatica di Torino.")
			);
		?>
		</div>
	</div>

	<div id="utilities" class="divider"></div>
	<div class="section">
		<div class="container">
			<h3><?php _e("Strumenti utilizzati") ?></h3>
			<p class="flow-text"><?php _e("Alcuni strumenti utilizzati per la realizzazione del sito web:") ?></p>
		</div>

		<div class="row">
		<?php
			$tech(
				"Inkscape",
				_('https://inkscape.org/en/'),
				'gnu-gpl-v2',
				_("Ritocchi alla mappa di OpenStreetMap in formato SVG.")
			);
			$tech(
				"GNU Nano",
				'https://www.nano-editor.org',
				'gnu-gpl',
				_("Banale editor di testo da terminale.")
			);
		?>
		</div>
	</div>
<?php
the_footer();
