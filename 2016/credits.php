<?php
# Linux Day 2016 - Credits
# Copyright (C) 2016 Valerio Bozzolan
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

require '../load.php';

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
		?>
		</div>
	</div>

	<div id="utilities" class="divider"></div>
	<div class="section">
		<div class="container">
			<h3><?php _e("Strumenti utilizzati") ?></h3>
			<p class="flow-text"><?php _e("Alcuni strumenti utilizzati per la realizzazione del sito web:") ?></p>

			<div class="row">
			<?php
				$tech(
					"Inkscape",
					_('https://inkscape.org/it/'),
					'gnu-gpl-v2',
					_("Ritocchi alla mappa di OpenStreetMap in formato SVG.")
				);
				$tech(
					"GIMP",
					_('https://www.gimp.org'),
					'gnu-gpl',
					_("Fotoritocchi e modifiche alle immagini")
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
	</div>

	<div id="media" class="divider"></div>
	<div class="section">
		<div class="container">
			<h3><?php _e("Materiale") ?></h3>

			<ul class="collection">
				<?php $thanks = function($to, $toURL, $what, $url, $license) { ?>
				<li class="collection-item"><?php printf(
					_("Grazie a %s per %s sotto licenza %s."),
					HTML::a(
						$toURL,
						$to
					),
					HTML::a(
						$url,
						$what
					),
					HTML::a(
						$license->getURL(),
						$license->getShort()
					)
				) ?></li>
				<?php }; ?>

				<?php
				$thanks(
					'User:VGrigas (WMF)',
					'https://commons.wikimedia.org/wiki/User:VGrigas_%28WMF%29',
					_("l'immagine estratta dal suo video «This is Wikipedia»"),
					'https://commons.wikimedia.org/wiki/File:This_is_Wikipedia.webm',
					license('cc-by-sa-3.0')
				);
				$thanks(
					_("i contributori di OpenStreetMap"),
					'http://www.openstreetmap.org',
					_("la piantina del dipartimento di Informatica di Torino"),
					XXX . '/openstreetmap-unito.svg',
					license('odbl')
				);
				$thanks(
					"Rui Damas",
					'https://www.gnu.org/graphics/gnu-slash-linux.html',
					_("l'immagine predefinita di alcuni elementi"),
					DEFAULT_IMAGE,
					license('gnu-gpl')
				);
				?>
			</ul>
		</div>
	</div>
<?php
the_footer();
