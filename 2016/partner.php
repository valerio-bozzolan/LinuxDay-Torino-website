<?php
# Linux Day 2016 - Media partner page
# Copyright (C) 2016, 2017 Valerio Bozzolan, Rosario Antoci, Linux Day Torino
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.

require 'load.php';

Header::spawn('partner');
?>
	<p class="flow-text"><?= __(
		"Sapevi che il Linux Day è una festa nazionale? Nello stesso giorno si festeggia in tutta Italia.".
		"Tutto questo, a Torino, non sarebbe possibile senza una comunità incredibile. Grazie a tutti coloro che credono ".
		"nella libertà digitale e culturale."
	) ?></p>

	<?php function partner($name, $url, $logo, $max_size = false) {
		$max_size = $max_size ? ' style="max-height:120px"' : '';
		echo HTML::a(
			$url,
			sprintf(
				'<img class="responsive-img" src="%s" alt="%s"%s />',
				STATIC_PATH . "/partner/$logo",
				sprintf(
					__("Logo di %s"),
					$name
				),
				$max_size
			),
			$name,
			null,
			'target="_blank"'
		);
	} ?>

	<div class="divider"></div>
	<div class="section">
		<p class="flow-text"><?= __("Con la partecipazione di:") ?></p>
		<div class="row">
			<div class="col s12 m3">
			<?php partner(
				__("Associazione Tesso"),
				'http://www.associazionetesso.org',
				'tesso.png',
				1
			); ?>
			</div>
			<div class="col s12 m3">
			<?php partner(
				"MuBIT",
				'http://www.mupin.it',
				'mubit.jpg',
				1
			); ?>
			</div>
			<div class="col s12 m3">
			<?php partner(
				__("Coderdojo Torino"),
				'http://coderdojotorino.it',
				'cd1.png',
				1
			); ?>
			</div>
			<div class="col s12 m3">
			<?php partner(
				"Coderdojo Torino 2",
				'http://coderdojotorino2.it',
				'cd2.jpg',
				1
			); ?>
			</div>
			<div class="col s12 m3">
			<?php partner(
				"Giovani per Torino",
				'http://www.comune.torino.it/infogio/gxt/',
				'giovani-per-torino.jpeg',
				1
			); ?>
			</div>
		</div>
	</div>

	<div id="main-sponsor" class="divider"></div>
	<div class="section">
		<p class="flow-text"><?= __("Main sponsor:") ?></p>
		<div class="row">
			<div class="col s12 m6 l4">
				<?php partner(
					"Quadrata Service Group s.r.l",
					'http://www.quadrata-group.com',
					'quadrata.png'
				); ?>
			</div>
		</div>
	</div>

	<div id="media-partner" class="divider"></div>
	<div class="section">
		<p class="flow-text"><?= __("Media partner:") ?></p>
		<div class="row">
			<div class="col s12 m6 l4">
			<?php partner(
				"Border Radio",
				'http://border-radio.it',
				'border.png'
			); ?>
			</div>
			<div class="col s12 m6 offset-l2 l4" style="padding-top:20px">
			<?php partner(
				"Quotidiano Piemontese",
				'http://www.quotidianopiemontese.it',
				'quotidiano-piemontese.jpg'
			); ?>
			</div>
		</div>
	</div>

	<div class="divider"></div>
	<div class="section">
		<p class="flow-text"><?= __("Con il patrocinio di:") ?></p>

		<?php function patrocinio ($who, $url, $img) {
			partner(
				sprintf(
					__("Patrocinio %s"),
					$who
				),
				$url,
				$img
			);
		} ?>

		<div class="row">
			<div class="col s12 m2">
			<?php patrocinio(
				__("Regione Piemonte"),
				'http://www.comune.torino.it/circ4/',
				'regione-piemonte.jpg'
			); ?>
			</div>

			<div class="col s12 m2">
			<?php patrocinio(
				__("Città Metropolitana di Torino"),
				'http://www.cittametropolitana.torino.it',
				'metropoli.png'
			); ?>

			</div>
			<div class="col s12 m2">
			<?php patrocinio(
				__("Comune di Torino"),
				'http://www.comune.torino.it',
				'comune.jpg'
			); ?>
			</div>
			<div class="col s12 m2">
			<?php patrocinio(
				__("Dipartimento di Informatica UniTO"),
				'http://di.unito.it',
				'dipinfounito.jpg'
			); ?>
			</div>
			<div class="col s12 m2">
			<?php patrocinio(
				__("Torino Smart City"),
				'http://www.torinosmartcity.it',
				'smartcity.jpg'
			); ?>
			</div>
		</div>
	</div>
<?php

Footer::spawn( ['home' => false] );
