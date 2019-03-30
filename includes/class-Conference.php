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

	/**
	 * Get conference ID
	 *
	 * @return int
	 */
	public function getConferenceID() {
		return $this->nonnull( Conference::ID );
	}

	/**
	 * Get conference UID
	 *
	 * @return string
	 */
	function getConferenceUID() {
		return $this->get( Conference::UID );
	}

	/**
	 * Get localized conference title
	 *
	 * @return string
	 */
	public function getConferenceTitle() {
		return __( $this->get( Conference::TITLE ) );
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
		return HumanTime::diff( $this->get( 'conference_start') );
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

	/**
	 * Get localized conference description
	 *
	 * @return string
	 */
	public function getConferenceDescription() {
		return nl2br( __( $this->get( Conference::DESCRIPTION ) ) );
	}

	/**
	 * Get localized conference quote
	 *
	 * @return string
	 */
	public function getConferenceQuote() {
		return nl2br( __( $this->get( 'conference_quote' ) ) );
	}

	/**
	 * Get localized conference subtitle
	 *
	 * @return string
	 */
	public function getConferenceSubtitle() {
		return __( $this->get( Conference::SUBTITLE ) );
	}

	/**
	 * Factory a FullEvent by this conference
	 *
	 * @return Query
	 */
	public function factoryFullEventByConference() {
		return FullEvent::factoryByConference( $this->getConferenceID() );
	}

	/**
	 * Normalize a Conference object
	 */
	protected function normalizeConference() {
		$this->integers(
			Conference::ID,
			Conference::DAYS,
			Location::ID
		);
		$this->datetimes(
			Conference::START,
			Conference::END
		);
	}
}

/**
 * A Conference is an event in a certain Location
 */
class Conference extends Queried {
	use ConferenceTrait;

	/**
	 * Database table name
	 */
	const T = 'conference';

	/**
	 * Conference ID column
	 */
	const ID = 'conference_ID';

	/**
	 * Conference UID column
	 */
	const UID = 'conference_uid';

	/**
	 * Conference title column
	 */
	const TITLE = 'conference_title';

	/**
	 * Subtitle column name
	 */
	const SUBTITLE = 'conference_subtitle';

	/**
	 * Description column name
	 */
	const DESCRIPTION = 'conference_description';

	/**
	 * Start column name
	 */
	const START = 'conference_start';

	/**
	 * End column name
	 */
	const END = 'conference_end';

	/**
	 * Acronym column name
	 */
	const ACRONYM = 'conference_acronym';

	/**
	 * Persons URL column name
	 */
	const PERSONS_URL = 'conference_persons_url';

	/**
	 * Events URL column name
	 */
	const EVENTS_URL = 'conference_events_url';

	/**
	 * Days column name
	 */
	const DAYS = 'conference_days';

	/**
	 * Complete ID column name
	 */
	const ID_ = self::T . DOT . self::ID;

	/**
	 * Complete Location ID column name
	 */
	const LOCATION_ = self::T . DOT . Location::ID;

	/**
	 * Maximum UID length
	 *
	 * @override
	 */
	const MAXLEN_UID = 32;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeConference();
	}
}
