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

	<?php $partner = function($name, $url, $logo) { ?>
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
			</div>
		</div>
	</div>
 <div class="divider"></div>
	<?php
	};

	$partner(
		"Border Radio",
		'http://border-radio.it',
		'border.png'
	);
	$partner(
		"Quotidiano Piemontese",
		'http://www.quotidianopiemontese.it',
		'quotidiano-piemontese.jpg'
	);
	$partner(
		_("Associazione Tesso"),
		'http://www.associazionetesso.org',
		'tesso.png'
	);
	$partner(
		"MuBit",
		'http://www.mupin.it',
		'mubit.jpg'
	);
	$partner(
		"Coderdojo Torino",
		'http://coderdojotorino.it',
		'cd1.png'
	);
	$partner(
                "Coderdojo Torino 2",
                'http://coderdojotorino2.it',
		'cd2.jpg'
        );
$partner(
                "Patrocinio Circoscrizione 4",
                '',
                'circoscrizione.jpg'
        );
$partner(
                "Patrocinio Comune di Torino",
                '',
                'comune.jpg'
        );
$partner(
                "Patrocinio Città Metropolitana di Torino",
                '',
                'metropoli.png'
        );
$partner(
                "Patrocinio Università degli Studi di Torino",
                '',
                'unito.jpg'
        );
$partner(
                "Patrocinio Torino Smart City",
                '',
                'smartcity.jpg'
        );
new Footer();
