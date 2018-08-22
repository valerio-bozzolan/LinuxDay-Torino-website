<?php
# Linux Day 2016 - Credits technology box
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Rosario Antoci, Linux Day Torino
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

/**
 * Credit box
 */
class CreditBox {

	/**
	 * Material design icon flag
	 */
	const MDI = true;

	/**
	 * Spawn a credit box
	 *
	 * @param $name string Project name
	 * @param $url string Project URL
	 * @param $license string License UID
	 * @param $icon string Icon filename or Material Design Icon name
	 */
	public static function spawn( $name, $url, $license, $desc, $icon = null ) {
		$license = license( $license ); ?>
		<div class="col s3 m2 l1">
			<div class="row libre-icon valign-wrapper">
				<div class="col s12 valign">
					<a href="<?php echo $url ?>" title="<?php printf(
						__( "%s: progetto a licenza %s" ),
						$name,
						$license->getShort()
					) ?>" target="_blank">
					<?php if( $icon ): ?>
						<img class="hoverable responsive-img" src="<?php echo STATIC_PATH . "/libre-icons/$icon" ?>" alt="<?php printf(
							__( "Logo di %s" ),
							$name
						) ?>" />
					<?php endif ?>
					</a>
				</div>
			</div>
		</div><?php
	}

}
