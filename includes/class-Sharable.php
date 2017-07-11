<?php
# Linux Day 2016 - Construct a database sharable
# Copyright (C) 2016, 2017 Valerio Bozzolan, Linux Day Torino
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
	function getSharableID() {
		return $this->nonnull('sharable_ID');
	}

	function getSharableTitle( $args = [] ) {
		$sharable_title = $this->get('sharable_title');

		if( ! isset( $sharable_title ) ) {
			return $this->getDefaultSharableTitle($args);
		}

		return _( $sharable_title );
	}

	/**
	 * Retrieve something usable as a title
	 *
	 * @return string
	 */
	function getDefaultSharableTitle( $args = [] ) {

		$sharable_type = $this->get('sharable_type');

		if( $sharable_type === 'youtube' ) {
			if( isset( $args['prop'] ) && $args['prop'] ) {
				return sprintf( _("il %s"), _("video esterno") );
			} else {
				return _("video esterno");
			}
		}

		$sharable_path = $this->get('sharable_path');

		// Get filename from "/asd/asd/asd/(filename)"
		$i = 0;
		while( strpos($sharable_path, '/', $i) !== false ) {
			$i++;
		}
		return substr($sharable_path, $i);
	}

	function isSharableImage() {
		return $this->isSharableType('image');
	}

	function isSharableVideo() {
		return $this->isSharableType('video');
	}

	function isSharableDocument() {
		return $this->isSharableType('document');
	}

	function isSharableIframe() {
		return $this->isSharableType('youtube');
	}

	private function isSharableType( $type ) {
		return $this->get('sharable_type') === $type;

	}

	function isSharableDownloadable() {
		return ! $this->isSharableIframe();
	}

	function getSharablePath( $base = ROOT ) {
		$sharable_type = $this->get('sharable_type');
		$sharable_path = $this->get('sharable_path');

		if($sharable_type === 'youtube') {
			return "https://www.youtube.com/watch?v={$p}";
		}

		return site_page($sharable_path, $base);
	}

	function getSharableMIME() {
		return $this->get('sharable_mimetype');
	}

	function getSharableLicense() {
		return license( $this->get('sharable_license') );
	}

	private function normalizeSharable() {
		$this->integers(
			'sharable_ID',
			'event_ID'
		);
	}
}

class Sharable extends Queried {
	use SharableTrait;

	function __construct() {
		$this->normalizeSharable();
	}

	static function factory() {
		return Query::factory( __CLASS__ )
			->from('sharable');
	}

	static function factoryByEvent( $event_ID ) {
		return self::factory()
			->whereInt( 'sharable.event_ID', $event_ID );
	}
}
