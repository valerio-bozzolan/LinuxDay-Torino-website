<?php
# Linux Day 2016 - Construct a database Location
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

trait LocationTrait {
	function getLocationName() {
		return _( $this->get('location_name') );
	}

	function getLocationAddress() {
		return _( $this->get('location_address') );
	}

	function getLocationNote() {
		return _( $this->get('location_note') );
	}

	function getLocationNoteHTML($args = []) {
		return Markdown::parse( _( $this->getLocationNote() ), $args );
	}

	function getLocationGeothumb() {
		$g = DEFAULT_IMAGE;
		$geothumb = $this->get('location_geothumb');
		if( $geothumb ) {
			$g = site_page( $geothumb, CURRENT_CONFERENCE_PATH );
		}
		return $g;
	}

	function locationHasGeo() {
		return
			null !== $this->get('location_lat') &&
			null !== $this->get('location_lng');
	}

	function getLocationZoom() {
		$z = $this->get('location_zoom');
		return isset( $z ) ? $z : Location::DEFAULT_ZOOM;
	}

	function getLocationGeoOSM() {
		return sprintf(
			'https://www.openstreetmap.org/?mlat=%1$s&mlon=%2$s#map=%3$s/%1$s/%2$s',
			$this->get('location_lat'),
			$this->get('location_lng'),
			$this->getLocationZoom()
		);
	}

	function printLocationLeaflet() {
		printf(
			'<div data-lat="%s" data-lng="%s" data-zoom="%s" id="map"></div>',
			$this->get('location_lat'),
			$this->get('location_lng'),
			$this->getLocationZoom()
		);
	}

	function normalizeLocation() {
		$this->integers(
			'location_ID',
			'location_zoom'
		);
		$this->floats(
			'location_lat',
			'location_lng'
		);
	}
}

class Location extends Queried {
	use LocationTrait;

	/**
	 * Database table name
	 */
	const T = 'location';

	/**
	 * Maximum UID length
	 *
	 * @override Queried::MAXLEN_UID
	 */
	const MAXLEN_UID = 64;

	const DEFAULT_ZOOM = 17;

	function __construct() {
		$this->normalizeLocation($this);
	}
}
