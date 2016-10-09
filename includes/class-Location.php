<?php
# Linux Day 2016 - Construct a database Location
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

trait LocationTrait {
	function getLocationName() {
		return _( $this->location_name );
	}

	function getLocationAddress() {
		isset( $this->location_address )
			|| error_die("Missing location_address");

		return $this->location_address;
	}

	function getLocationNote() {
		return nl2br( _( $this->location_note ) );
	}

	function getLocationGeothumb() {
		$g = DEFAULT_IMAGE;
		if( $this->location_geothumb ) {
			$g = site_page( $this->location_geothumb, CONFERENCE );
		}
		return $g;
	}

	function locationHasGeo() {
		return isset( $this->location_lat, $this->location_lon );
	}

	function getLocationZoom() {
		return isset( $this->location_zoom ) ? $this->location_zoom : Location::DEFAULT_ZOOM;
	}

	function getLocationGeoOSM() {
		return sprintf(
			'https://www.openstreetmap.org/?mlat=%1$s&mlon=%2$s#map=%3$s/%1$s/%2$s',
			$this->location_lat,
			$this->location_lon,
			$this->getLocationZoom()
		);
	}

	function printLocationLeaflet() {
		printf(
			'<div data-lat="%s" data-lng="%s" data-zoom="%s" id="map"></div>',
			$this->location_lat,
			$this->location_lon,
			$this->getLocationZoom()
		);
	}
}

class Location {
	use LocationTrait;

	const DEFAULT_ZOOM = 17;

	function __construct() {
		self::normalize($this);
	}

	static function normalize(& $t) {
		if( isset( $t->location_ID ) ) {
			$t->location_ID   = (int) $t->location_ID;
		}
		if( isset( $t->location_lat ) ) {
			$t->location_lat   = (float) $t->location_lat;
		}
		if( isset( $t->location_lon ) ) {
			$t->location_lon   = (float) $t->location_lon;
		}
		if( isset( $t->location_zoom ) ) {
			$t->location_zoom = (int) $t->location_zoom;
		}
	}
}
