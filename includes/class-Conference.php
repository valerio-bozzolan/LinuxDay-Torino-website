<?php
# Linux Day 2016 - Construct a database conference
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Linux Day Torino
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
	function getConferenceID() {
		return $this->nonnull('conference_ID');
	}

	function getConferenceUID() {
		return $this->get('conference_uid');
	}

	function getConferenceTitle() {
		return _( $this->get('conference_title') );
	}

	function getConferenceURL( $base = URL ) {
		return $base . sprintf( PERMALINK_CONFERENCE, $this->getConferenceUID() );
	}

	function forceConferencePermalink() {
		$url = $this->getConferenceURL( ROOT );
		if( $url !== $_SERVER['REQUEST_URI'] ) {
			http_redirect( $url );
		}
	}

	function getConferenceHumanStart() {
		return HumanTime::diff( $this->get('conference_start') );
	}

	function getConferenceHumanEnd() {
		return HumanTime::diff( $this->get('conference_end') );
	}

	function getConferenceStart($f) {
		return $this->get('conference_start')->format($f);
	}

	function getConferenceEnd($f) {
		return $this->get('conference_end')->format($f);
	}

	function getConferenceDescription() {
		return nl2br( _( $this->get('conference_description') ) );
	}

	function getConferenceQuote() {
		return nl2br( _( $this->get('conference_quote') ) );
	}

	function getConferenceSubtitle() {
		return _( $this->get('conference_subtitle') );
	}

	function factoryFullEventByConference() {
		return FullEvent::factoryByConference( $this->getConferenceID() );
	}

	private function normalizeConference() {
		$this->integers(
			'conference_ID',
			'location_ID'
		);
		$this->datetimes(
			'conference_start',
			'conference_end'
		);
	}
}

class Conference extends Queried {
	use ConferenceTrait;

	/**
	 * Database table name
	 */
	const T = 'chapter';

	/**
	 * Maximum UID length
	 *
	 * @override
	 */
	const MAXLEN_UID = 32;

	function __construct() {
		$this->normalizeConference();
	}
}
