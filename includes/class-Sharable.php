<?php
# Linux Day 2016 - Construct a database sharable
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

trait SharableTrait {

	/**
	 * Get the sharable ID
	 *
	 * @return int
	 */
	public function getSharableID() {
		return $this->nonnull( Sharable::ID );
	}

	/**
	 * Get the localized sharable title
	 *
	 * @param $args array Title arguments like 'prop'
	 * @return string
	 */
	public function getSharableTitle( $args = [] ) {
		$sharable_title = $this->get( Sharable::TITLE );

		if( ! isset( $sharable_title ) ) {
			return $this->getDefaultSharableTitle( $args );
		}

		return __( $sharable_title );
	}

	/**
	 * Retrieve something usable as a title
	 *
	 * @param $args array Title arguments like 'prop'
	 * @return string
	 */
	public function getDefaultSharableTitle( $args = [] ) {

		$sharable_type = $this->get( Sharable::TYPE );

		if( $sharable_type === 'youtube' ) {
			if( isset( $args['prop'] ) && $args['prop'] ) {
				return sprintf( __("il %s"), __("video esterno") );
			} else {
				return __("video esterno");
			}
		}

		$sharable_path = $this->get( Sharable::PATH );

		// Get filename from "/asd/asd/asd/(filename)"
		$i = 0;
		while( strpos( $sharable_path, _, $i ) !== false ) {
			$i++;
		}
		return substr( $sharable_path, $i );
	}

	/**
	 * Is it an image?
	 *
	 * @return bool
	 */
	public function isSharableImage() {
		return $this->isSharableType( 'image' );
	}

	/**
	 * Is it a video?
	 *
	 * @return bool
	 */
	public function isSharableVideo() {
		return $this->isSharableType( 'video' );
	}

	/**
	 * Is it a document?
	 *
	 * @return bool
	 */
	public function isSharableDocument() {
		return $this->isSharableType( 'document' );
	}

	/**
	 * Is it an iframe (like a YouTube video?)
	 *
	 * @return bool
	 */
	public function isSharableIframe() {
		return $this->isSharableType( 'youtube' );
	}

	/**
	 * Is it of a certain type?
	 *
	 * @param $type string
	 * @return bool
	 */
	private function isSharableType( $type ) {
		return $this->get( Sharable::TYPE ) === $type;

	}

	/**
	 * It can be downloaded?
	 *
	 * @return bool
	 */
	public function isSharableDownloadable() {
		return ! $this->isSharableIframe();
	}

	function getSharablePath( $base = ROOT ) {
		$type = $this->get( Sharable::TYPE );
		$path = $this->get( Sharable::PATH );
		if( 'youtube' === $type ) {
			return "https://www.youtube.com/watch?v={$path}";
		}
		return site_page( $path, $base );
	}

	/**
	 * Get the MIME type
	 *
	 * @return string|null
	 */
	public function getSharableMIME() {
		return $this->get( Sharable::MIME );
	}

	/**
	 * Get the license
	 *
	 * @return License
	 */
	public function getSharableLicense() {
		return license( $this->get( Sharable::LICENSE ) );
	}

	/**
	 * Normalize a Sharable object
	 */
	protected function normalizeSharable() {
		$this->integers(
			Sharable::ID,
			Event   ::ID
		);
	}
}

/**
 * A Sharable is an attachment related to a Talk
 */
class Sharable extends Queried {
	use SharableTrait;

	/**
	 * Database table name
	 */
	const T = 'sharable';

	/**
	 * Sharable ID column
	 */
	const ID = 'sharable_ID';

	/**
	 * Sharable title column
	 */
	const TITLE = 'sharable_title';

	/**
	 * Sharable type column
	 */
	const TYPE = 'sharable_type';

	/**
	 * Sharable path column
	 */
	const PATH = 'sharable_path';

	/**
	 * Sharable mime type column
	 */
	const MIME = 'sharable_mimetype';

	/**
	 * Sharable license column
	 */
	const LICENSE = 'sharable_license';

	/**
	 * Sharable univoque ID
	 */
	const ID_ = self::T . DOT . self::ID;

	/**
	 * Sharable event ID
	 */
	const EVENT_ = self::T . DOT . Event::ID;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeSharable();
	}

	/**
	 * Factory by an event
	 *
	 * @param $event_ID int Event ID
	 * @return Query
	 */
	public static function factoryByEvent( $event_ID ) {
		return self::factory()
			->whereInt( Sharable::EVENT_, $event_ID );
	}
}
