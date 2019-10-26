<?php
# Linux Day - Human time diff
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Linux Day Torino
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

/**
 * Handle time difference in a human-readable format
 */
class HumanTime {

	/**
	 * Get the time difference between two dates (or just one date and now)
	 *
	 * @param  DateTime $from
	 * @param  DateTime $to
	 * @param  array    $args
	 * @return string
	 */
	public static function diff( $from, $to = null, & $args = [] ) {

		// enable long version as default
		if( !isset( $args['long'] ) ) {
			$args['long'] = true;
		}

		// enable '%s ago'/'in %s' adverbs as default
		if( !isset( $args['adverb'] ) ) {
			$args['adverb'] = true;
		}

		if( $to === null ) {
			$to = new DateTime('now');
        }

		$diff = $from->diff( $to );

		$human = self::humanize(
			$diff->y,
			$diff->m,
			$diff->d,
			$diff->h,
			$diff->i,
			$diff->s,
			$diff->days,
			$diff->invert,
			$from,
			$args
		);

		if( $args['complete'] || !$args['adverb'] ) {
			return $human;
		}

		if( $diff->invert ) {
			return sprintf(
				__("fra %s"),
				$human
			);
		}

		return sprintf(
			__("%s fa"),
			$human
		);
	}

	private static function humanize( $y, $m, $d, $h, $i, $s, $days, $invert, $from, & $args ) {

		$long = & $args['long'];

		// as default it's not a complete construct (e.g. '3 years' VS 'today' )
		if( !isset( $args['complete'] ) ) {
			$args['complete'] = false;
		}

		// Top-down: From far away to recently

		// We are human
		if( $d > 200 ) {
			$y++;
		}

		if( $y > 1 ) {
			$phrase = $long
				? __("%d anni")
				: __( "%d y" );
			return sprintf( $phrase, $y );
		}

		if( $y === 1 ) {
			return $long
				? __( "un anno" )
				: __( "1 y" );
		}

		// This year

		if( $m > 1 ) {
			$phrase = $long
				? __( "%d mesi" )
				: __( "%d m" );
			return sprintf( $phrase, $m );
		}

		if( $m === 1 ) {
			return $long
				? __( "un mese" )
				: __( "1 m" );
		}

		// This month

		// We are human
		$d_fake = $d;
		if( $h > 18 ) {
			$d_fake++;
		}

		if( $d_fake > 13 && !$long ) {
			return sprintf( __("%d settimane"), $d_fake / 7 );
		}

		if( $d_fake > 6 && !$long ) {
			return __("una settimana");
		}

		if( $d_fake > 1 ) {
			$phrase = $long
				? __( "%d giorni" )
				: __( "%d d" );
			return sprintf( $phrase, $d_fake );
		}

		if( $d_fake === 1 ) {
			$args['complete'] = true;

			return $invert ? __("domani") : _("ieri");
		}

		// Today

		// We are human
		$h_fake = $h;
		if( $i > 40 ) {
			$h_fake++;
		}

		if( $h_fake > 3 ) {
			$args['complete'] = true;

			return __("oggi");
		}

		if( $h > 1 ) {
			if( $m > 0 ) {
				return sprintf( __("%d ore e %d minuti"), $h, $i );
			}

			return sprintf( __("%d ore"), $h );
		}

		// In this hour

		// We are human
		$i_fake = $i + $h * 60;
		if( $s > 50 ) {
			$i_fake++;
		}

		if( $i_fake > 52 ) {
			return $long
				? __( "un'ora" )
				: __( "1 h" );
		}

		if( $i_fake > 37 ) {
			return __("tre quarti d'ora");
		}

		if( $i_fake > 22 ) {
			return $long
				? __( "mezzora" )
				: __( "½ h" );
		}

		if( $i_fake > 1 ) {
			return sprintf( __("%d minuti"), $i_fake );
		}

		if( $i_fake === 1 ) {
			return sprintf( __("un minuto") );
		}

		if( $s > 10 ) {
			return sprintf( __("%d secondi"), $s );
		}

		$args['complete'] = true;

		return __("proprio ora");
	}
}
