<?php
# Linux Day 2016 - Construct a database event
# Copyright (C) 2016 Valerio Bozzolan, Ludovico Pavesi
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

trait EventTrait {
	static function prepareEvent(& $t) {
		if( isset( $t->event_ID ) ) {
			$t->event_ID   = (int) $t->event_ID;
		}

		// MySQL datetime to PHP DateTime
		if( isset( $t->event_start ) ) {
			datetime2php($t->event_start);
		}

		// MySQL datetime to PHP DateTime
		if( isset( $t->event_end ) ) {
			datetime2php($t->event_end);
		}
	}

	/**
	 * Return true if this event result has also the user column
	 */
	function eventHasUser() {
		// (isset returns true if it exists but it's null)
		return isset( $this->user_uid );
	}

	function getEventStart($f) {
		return $this->event_start->format($f);
	}

	function getEventEnd($f) {
		return $this->event_end->format($f);
	}
}

class_exists('User');

class Event {
	use EventTrait, UserTrait;

	function __construct() {
		self::prepareEvent($this);
		self::prepareUser($this);
	}

	/**
	 * Query events ordered by tracks with event-users.
	 * Every row is filled with an handy array of users (`->users`) and an incremental hour (`->hour`)
	 *
	 * @return array
	 */
	static function queryEvents() {
		global $JOIN;

		// Yes, I want to obtain duplicates
		$events = query_results(
			sprintf(
				'SELECT '.
					'track_uid, '.
					'track_name, '.
					'event.event_ID, '.
					'event_uid, '.
					'event_title, '.
					'event_start, '.
					'event_end, '.
					'user_uid, '.
					'user_name, '.
					'user_surname '.
					" FROM {$JOIN('track', 'event')} ".
						"LEFT JOIN {$JOIN('event_user')} ".
							'ON (event.event_ID = event_user.event_ID) '.
						"LEFT JOIN {$JOIN('user')} ".
							'ON (event_user.user_ID = user.user_ID) '.
				'WHERE '.
					'event.conference_ID = %d AND '.
					'event.track_ID = track.track_ID '.
				'ORDER BY '.
					'event_start, '.
					'track_uid'
				,
				CONFERENCE_ID
			),
			'Event'
		);

		// Users indexed by event_ID
		$users = [];
		foreach($events as $event) {
			if( ! isset( $users[ $event->event_ID ] ) ) {
				$users[ $event->event_ID ] = [];
			}

			if( $event->eventHasUser() ) {
				////////////////////////////////////////////////////////////////////////////////////
				// READ AND DO NOT EXECUTE IF USING PHP < 5 TO DO NOT WASTE YOUR SERVER RESOURCES //
				// (Or do it everywhere if you are writing Joomla! and WordPress plugins. asd.)   //
				////////////////////////////////////////////////////////////////////////////////////

				// You will say: «Hey, `$event` is not a "clean" user! Here you are creating a multi-dimensional recursive big shit!»
				// But... as in PHP5+ every object is assigned by reference: NOT by value!
				// So... this is only a reference tree: it's all OK (IN READ-ONLY...).
			 	$users[ $event->event_ID ][] = $event;
			}
		}

		$incremental_hour = 0;
		$last_hour = -1;
		$last_event_ID = -1;
		foreach($events as $i => $event) {
			if( $last_event_ID === $event->event_ID ) {
				unset( $events[ $i ] );
				continue;
			}

			// 'G' is date() 0-24 hour format without leading zeros
			$hour = (int) $event->getEventStart('G');

			// Next hour if it's really ANOTHER event (and not a duplicate)
			if( $hour !== $last_hour ) {
				if( $incremental_hour === 0 ) {
					$incremental_hour = 1;
				} else {
					// `$hour - $last_hour` is often only 1
					// Set to ++ to skip empty spaces
					$incremental_hour = $hour - $last_hour;
				}
			}

			// Fill `->hour`
			$event->hour = $incremental_hour;

			// Fill `->users`
			$event->users = $users[ $event->event_ID ];

			$last_event_ID = $event->event_ID;
		}

		return $events;
	}
}
