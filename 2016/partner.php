<?php
# Linux Day 2016 - Media partner page
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

new Header('partner');

?>
	<p class="flow-text"><?php _e(
		"Sapevi che il Linux Day è una festa nazionale? Nello stesso giorno si festeggia in tutta Italia.".
		"Tutto questo, a Torino, non sarebbe possibile senza una comunità incredibile. Grazie a tutti coloro che credono ".
		"nella libertà digitale e culturale. In particolare:"
	) ?></p>

	<?php $partner = function($name, $url, $icon, $logo, $color, $desc) { ?>
	<div class="section">
		<div class="row">
			<div class="col s12 m6">
				<a href="<?php echo $url ?>" title="<?php
					_e("$name")
				?>" target="_blank">
					<img class="responsive-img" src="<?php
						echo XXX . "/partner/$logo"
					?>" alt="<?php printf(
						_("Logo di %s"),
						$name
					) ?>" />
				</a>
			</div>
			<div class="col s12 m6">
				<p><?php echo $desc ?></p>
				<p><?php echo HTML::a(
					$url,
					$name . icon($icon, 'right'),
					null,
					'btn waves-effect ' . $color,
					'target="_blank"'
				) ?></p>
			</div>
		</div>
	</div>
	<?php
	};

	$partner(
		"Border Radio",
		'http://border-radio.it',
		'mic',
		'border.png',
		'orange',
		_("Musica culturale libera in Torino.")
	);
	$partner(
		"Quotidiano Piemontese",
		'http://www.quotidianopiemontese.it',
		'rss_feed',
		'quotidiano-piemontese.jpg',
		'grey',
		_("Informazione partecipativa e trasparente.")
	);
	$partner(
		_("Associazione Tesso"),
		'http://www.associazionetesso.org',
		'build',
		'tesso.png',
		'blue darken-4',
		_("Associazione trasformazione e sviluppo sociale.")
	);
	$partner(
		"MuBit",
		'http://www.mupin.it',
		'computer',
		'mubit.jpg',
		'teal',
		_("Museo internazionale dell'Informatica.")
	);
	$partner(
		"Coderdojo Torino",
		'http://coderdojotorino.it',
		'usb',
		'coderdojo.png',
		'black white-text',
		_("Eventi per la digitalizzazione nelle scuole e nel territorio.")
	);

new Footer();
