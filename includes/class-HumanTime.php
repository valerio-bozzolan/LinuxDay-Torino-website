<?php
# Linux Day - Human time diff
# Copyright (C) 2016 Valerio Bozzolan, Linux Day Torino
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

class HumanTime {
	static function diff($from, $to = null) {
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
			$complete
		);

		if( $complete ) {
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

	static private function humanize($y, $m, $d, $h, $i, $s, $days, $invert, $from, & $complete) {
		$complete = false;

		// Top-down: From far away to recently

		// We are human
		if( $d > 200 ) {
			$y++;
		}

		if( $y > 1 ) {
			return sprintf( __("%d anni"), $y );
		}

		if( $y === 1 ) {
			return __("un anno");
		}

		// This year

		if( $m > 1 ) {
			return sprintf( __("%d mesi"), $m );
		}

		if( $m === 1 ) {
			return __("un mese");
		}

		// This month

		// We are human
		$d_fake = $d;
		if( $h > 18 ) {
			$d_fake++;
		}

		if( $d_fake > 13 ) {
			return sprintf( __("%d settimane"), $d_fake / 7 );
		}

		if( $d_fake > 6 ) {
			return __("una settimana");
		}

		if( $d_fake > 1 ) {
			return sprintf( __("%d giorni"), $d_fake );
		}

		if( $d_fake === 1 ) {
			$complete = true;

			return $invert ? __("domani") : _("ieri");
		}

		// Today

		// We are human
		$h_fake = $h;
		if( $i > 40 ) {
			$h_fake++;
		}

		if( $h_fake > 3 ) {
			$complete = true;

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
		$i_fake = $i;
		if( $s > 50 ) {
			$i_fake++;
		}

		if( $i_fake > 52 ) {
			return __("un'ora");
		}

		if( $i_fake > 37 ) {
			return __("tre quarti d'ora");
		}

		if( $i_fake > 22 ) {
			return __("mezzora");
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

		$complete = true;

		return __("proprio ora");
	}
}
