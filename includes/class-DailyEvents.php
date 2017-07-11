<?php
# Linux Day 2016 - List events daily
# Copyright (C) 2016, 2017 Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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

class DailyEvents {

	/**
	 * @return array
	 */
	static function fromConferenceChapter( $conference_ID, $chapter_ID ) {

		$events = FullEvent::factoryByConferenceChapter( $conference_ID, $chapter_ID );

		$events = $events
			->orderBy('event_start, track_order')
			->queryResults();

		$incremental_hour = 0;
		$last_hour = -1;
		$last_event_ID = -1;
		foreach($events as $i => $event) {
			// Remember that it's a JOIN with duplicates
			if( $last_event_ID === $event->event_ID ) {
				unset( $events[ $i ] );
				continue;
			}

			// 'G': date() 0-24 hour format without leading zeros
			$hour = (int) $event->getEventStart('G');

			// Next hour
			if( $hour !== $last_hour ) {
				if( $incremental_hour === 0 ) {
					$incremental_hour = 1;
				} else {
					// `$hour - $last_hour` is often only 1
					// Set to ++ to skip empty spaces
					$incremental_hour += $hour - $last_hour;
				}
			}

			// Fill `->hour`
			$event->hour = $incremental_hour;

			$last_event_ID = $event->event_ID;

			$last_hour = $hour;
		}

		return $events;
	}
}
