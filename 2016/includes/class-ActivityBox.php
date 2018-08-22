<?php
# Linux Day 2016 - activity box
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Ludovico Pavesi, Rosario Antoci, Linux Day Torino
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
# along with this program. If not, see <http://www.gnu.org/licenses/>.

/**
 * Box for an activity
 */
class ActivityBox {

	/**
	 * Spawn the box
	 *
	 * @param $what string Activity name
	 * @param $who string Who is conducting the activity
	 * @param $prep string Preposition for the conductor
	 * @param $img string Image name
	 * @param $attendize string Attendize URL
	 */
	public static function spawn( $what, $who, $url = null, $prep = null, $img = null, $attendize = null ) {
		if( ! $prep ) {
			$prep = _( "da %s" );
		}
		$who_text = $who;
		if( $url ) {
			$who = HTML::a( $url, $who, null, 'white-text', 'target="_blank"' );
		}
		$who_prep = sprintf( $prep, $who );
		?>

		<div class="col s12 m6">
			<div class="card-panel hoverable purple darken-3 white-text">
				<?php if( $img ): ?>
					<div class="row"><!-- Start image row -->
						<div class="col s4">
							<img class="responsive-img" src="<?php echo STATIC_PATH . "/partner/$img" ?>" alt="<?php _esc_attr( $who_text ) ?>" />
						</div>
						<div class="col s8"><!-- Start text col -->
				<?php endif ?>

				<p>
					<span class="flow-text"><?php echo $what ?></span><br />
					<?php printf( _( "Gestito %s." ), $who_prep ) ?>
				</p>

				<?php if( $attendize ): ?>
					<p><?php echo HTML::a(
						$attendize,
						_("Prenota"),
						sprintf(
							_( "Prenota la tua partecipazione a %s" ),
							$what
						),
						'btn white purple-text waves-effect waves-purple hoverable',
						'target="_blank"'
					) ?></p>
				<?php endif ?>

				<?php if( $img ): ?>
						</div><!-- End text col -->
					</div><!-- End image row -->
				<?php endif ?>
			</div>
		</div><?php
	}
}
