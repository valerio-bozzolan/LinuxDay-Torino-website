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

require 'load.php';

new Header('credits');
?>
	<div class="section">
		<p class="flow-text"><?php _e("Questo sito web utilizza esclusivamente <strong>software libero</strong>.") ?></p>
	</div>


		<?php $tech = function($name, $url, $license, $desc, $icon = null, $material = false) {
			$license = license($license); ?>
			<div class="col s3 m2 l2">
				<div class="row">
					<div class="col s12">
						<a href="<?php echo $url ?>" title="<?php printf(
							_("%s: progetto a licenza %s"),
							$name,
							$license->getShort()
						) ?>">
						<?php if($icon): ?>
							<img class="hoverable responsive-img" src="<?php echo XXX . "/libre-icons/$icon" ?>" alt="<?php printf(
								_("Logo di %s"),
								$name
							) ?>" />
						<?php endif ?>
						</a>
					</div>
					<!--
					<div class="col s12">
						<small><?php printf(
							"<strong>%s</strong> <small>(%s)</small>",
							HTML::a( $url, $name ),
							HTML::a( $license->getURL(), $license->getShort(), $license->getName() )
						) ?></small>
					</div>-->
				</div>
			</div>
		<?php }; ?>

	<div class="section">
		<div class="row">
		<?php
		$tech(
			"Debian GNU/Linux",
			'https://debian.org',
			'gnu-gpl',
			_("Sistema operativo del server web."),
			'debian.png'
		);
		$tech(
			"Apache",
			'https://httpd.apache.org',
			'apache',
			_("Server web."),
			'apache.png'
		);
		$tech(
			"PHP5",
			'http://php.net',
			'php',
			_("Pre-processore di ipertesti."),
			'php.png'
		);
		$tech(
			"MariaDB",
			'https://mariadb.org',
			'gnu-gpl-v2',
			_("MySQL guidato dalla comunità."),
			'mariadb.png'
		);
		$tech(
			"MySQL",
			'http://www.mysql.com',
			'gnu-gpl-v2',
			_("Database SQL relazionale."),
			'mysql.png'
		);
		$tech(
			"GNU Gettext",
			'https://www.gnu.org/software/gettext/',
			'gnu-gpl',
			_("Framework per internazionalizzazione e localizzazione dei messaggi."),
			'gnu.png'
		);
		?>
		</div>
		<div class="row">
		<?php
		$tech(
			"Boz-PHP",
			'https://launchpad.net/boz-php-another-php-framework',
			'gnu-agpl',
			_("Framework PHP e MySQL/MariaDB."),
			'boz.png'
		);
		$tech(
			"Let's Encrypt",
			'https://certbot.eff.org',
			'apache',
			_("Certificato SSL."),
			'lets-encrypt.png'
		);
		$tech(
			"jQuery",
			'http://jquery.com',
			'jquery',
			_("Framework JavaScript."),
			'jquery.png'
		);
		$tech(
			"Leaflet",
			'http://leafletjs.com',
			'bsd-2',
			_("Framework JavaScript per mappe interattive"),
			'leaflet.png'
		);
		$tech(
			"Materialize",
			'https://github.com/Dogfalo/materialize',
			'mit',
			_("Framework CSS e JavaScript in stile Material Design."),
			'materialize.png'
		);
		$tech(
			"Roboto 2.0",
			'https://www.google.com/fonts/specimen/Roboto',
			'apache',
			_("Famiglia di caratteri."),
			'roboto.png'
		);
		$tech(
			"Material Design Icons",
			'http://google.github.io/material-design-icons/',
			'cc-by',
			_("Collezione di icone Material Design."),
			'material.png'
		);
		?>
		</div>
		<div class="row">
		<?php
		$tech(
			"Inkscape",
			_('https://inkscape.org/it/'),
			'gnu-gpl-v2',
			_("Ritocchi alla mappa di OpenStreetMap in formato png."),
			'inkscape.png'
		);
		$tech(
			"GIMP",
			_('https://www.gimp.org'),
			'gnu-gpl',
			_("Fotoritocchi e modifiche alle immagini"),
			'gimp.png'
		);
		$tech(
			"GNU Nano",
			'https://www.nano-editor.org',
			'gnu-gpl',
			_("Banale editor di testo da terminale."),
			'gnu-nano.png'
		);
		$tech(
			"OpenStreetMap",
			'http://www.openstreetmap.org',
			'odbl',
			_("Mappa planetaria libera"),
			'osm.png'
		);
		$tech(
			"Git",
			'https://git-scm.com',
			'gnu-gpl-v2',
			_("Controllo versione distribuito"),
			'git.png'
		);
		?>
		</div>
	</div>

	<div id="media" class="divider"></div>
	<div class="section">
		<h3><?php _e("Materiale") ?></h3>

		<ul class="collection">
			<?php $thanks = function($to, $toURL, $what, $url, $license) { ?>
			<?php $license = license($license) ?>
			<li class="collection-item"><?php printf(
				_("Grazie a %s per %s sotto licenza %s."),
				HTML::a($toURL, $to),
				HTML::a($url, $what),
				HTML::a( $license->getURL(), $license->getShort() )
			) ?></li>
			<?php }; ?>

			<?php
			$thanks(
				"User:VGrigas (WMF)",
				'https://commons.wikimedia.org/wiki/User:VGrigas_%28WMF%29',
				_("l'immagine estratta dal suo video «This is Wikipedia»"),
				'https://commons.wikimedia.org/wiki/File:This_is_Wikipedia.webm',
				'cc-by-sa-3.0'
			);
			$thanks(
				"Rui Damas",
				'https://www.gnu.org/graphics/gnu-slash-linux.html',
				_("l'immagine predefinita di alcuni elementi"),
				DEFAULT_IMAGE,
				'gnu-gpl'
			);
			?>
		</ul>
	</div>
<?php new Footer();
