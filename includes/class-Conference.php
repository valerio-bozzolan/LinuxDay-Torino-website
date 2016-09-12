<?php
# Linux Day 2016 - Construct a database conference
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

trait ConferenceTrait {
	static function prepareConference(& $t) {
		if( isset( $t->conference_ID ) ) {
			$t->conference_ID   = (int) $t->conference_ID;
		}
		if( isset( $t->conference_start ) ) {
			datetime2php($t->conference_start);
		}
		if( isset( $t->conference_end ) ) {
			datetime2php($t->conference_end);
		}
	}

	function getConferenceID() {
		isset( $this->conference_ID )
			|| die("Missing conference_ID");
		return $this->conference_ID;
	}

	function getConferenceUID() {
		isset( $this->conference_uid )
			|| die("Missing conference_uid");
		return $this->conference_uid;
	}

	function getConferenceTitle() {
		return _( $this->conference_title );
	}

	function getConferenceURL() {
		return URL . "/{$this->getConferenceUID()}";
	}

	function getConferenceStart($f) {
		return $this->conference_start->format($f);
	}

	function getConferenceEnd($f) {
		return $this->conference_end->format($f);
	}

	function getConferenceDescription() {
		return nl2br( _( $this->conference_description ) );
	}

	function getConferenceQuote() {
		return nl2br( _( $this->conference_quote ) );
	}

	function getConferenceSubtitle() {
		return _( $this->conference_subtitle );
	}

	function getDailyEventsTable() {
		return new DailyEventsTable( $this->getConferenceID() );
	}
}

class_exists('Location');

class Conference {
	use ConferenceTrait;
	use LocationTrait;

	function __construct() {
		self::prepareConference($this);
		self::prepareLocation($this);
	}

	static function getConference( $conference_uid ) {
		global $JOIN;

		return query_row(
			sprintf(
				'SELECT '.
					'conference_ID, '.
					'conference_uid, '.
					'conference_title, '.
					'conference_subtitle, '.
					'conference_description, '.
					'conference_quote, '.
					'conference_start, '.
					'conference_end, '.
					'conference_uid, '.
					'location_name, '.
					'location_address, '.
					'location_note, '.
					'location_geothumb, '.
					'location_lat, '.
					'location_lon, '.
					'location_zoom '.
					"FROM {$JOIN('conference', 'location')} ".
				'WHERE '.
					"conference_uid = '%s' AND ".
					'conference.location_ID = location.location_ID'
				,
				esc_sql( $conference_uid )
			),
			'Conference'
		);
	}
}
