<?php
# Linux Day 2016 - Track
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

trait TrackTrait {

	/**
	 * Get the track ID
	 *
	 * @return int
	 */
	public function getTrackID() {
		return $this->nonnull( Track::ID );
	}

	/**
	 * Get the track UID
	 *
	 * @return string
	 */
	public function getTrackUID() {
		return $this->get( Track::UID );
	}

	/**
	 * Get the localized track name
	 *
	 * @return string
	 */
	function getTrackName() {
		return __( $this->get( Track::NAME ) );
	}

	/**
	 * Get the localized track label
	 *
	 * @return string
	 */
	function getTrackLabel() {
		return __( $this->get( Track::LABEL ) );
	}

	/**
	 * Normalize a Track object
	 */
	protected function normalizeTrack() {
		$this->integers(
			Track::ID,
			Track::ORDER
		);
	}
}

/**
 * A Track is the theme of a Talk
 */
class Track extends Queried {
	use TrackTrait;

	/**
	 * Database table name
	 */
	const T = 'track';

	/**
	 * ID column name
	 */
	const ID = 'track_ID';

	/**
	 * UID column name
	 */
	const UID = 'track_uid';

	/**
	 * Name column name
	 */
	const NAME = 'track_name';

	/**
	 * Label column name
	 */
	const LABEL = 'track_label';

	/**
	 * Order column name
	 */
	const ORDER = 'track_order';

	/**
	 * Complete ID column name
	 */
	const ID_ = self::T . DOT . self::ID;

	/**
	 * Maximum UID length
	 */
	const MAXLEN_UID = 64;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeTrack();
	}
}
