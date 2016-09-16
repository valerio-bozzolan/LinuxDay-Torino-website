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

new Header('media-partner');

?>
	<p class="flow-text"><?php _e(
		"Sapevi che il Linux Day è una festa nazionale? Nello stesso giorno si festeggia in tutta Italia.".
		"Tutto questo, a Torino, non sarebbe possibile senza una comunità incredibile. Grazie a tutti coloro che credono ".
		"nella libertà digitale e culturale. In particolare:"
	) ?></p>
	<div class="row">
		<?php $partner = function($name, $url, $icon, $logo, $color, $desc) { ?>
			<div class="card">
				<div class="card-image">
					<img class="<?php echo $color ?>" src="<?php echo XXX . "/partner/$logo" ?>" alt="<?php printf(
						_("Logo di %s"),
						$name
					) ?>" />
				</div>
				<div class="card-content">
					<p><?php echo $desc ?></p>
				</div>
				<div class="card-action">
					<?php echo HTML::a(
						$url,
						$name . icon($icon, 'right'),
						null,
						'btn waves-effect',
						'target="_blank"'
					) ?>
				</div>
			</div>
		<?php }; ?>

		<div class="col s12 m6">
		<?php
			$partner(
				"Border Radio",
				'http://border-radio.it',
				'mic',
				'border.png',
				'white',
				_("Comunità di musica culturale libera in Torino.")
			);
			$partner(
				"Quotidiano Piemontese",
				'http://www.quotidianopiemontese.it',
				'rss_feed',
				'quotidiano-piemontese.jpg',
				'white',
				_("Informazione partecipativa e trasparente.")
			);
		?>
		</div>
	</div>
<?php new Footer();
