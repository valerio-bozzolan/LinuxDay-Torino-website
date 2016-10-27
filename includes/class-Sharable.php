<?php
# Linux Day 2016 - Construct a database sharable
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

trait SharableTrait {
	function getSharableID() {
		isset( $this->sharable_ID )
			|| error_die("Missing sharable_ID");

		return $this->sharable_ID;
	}

	function getSharableTitle($args = []) {
		property_exists($this, 'sharable_title')
			|| error_die("Missing sharable title");

		if( ! isset( $this->sharable_title ) ) {
			return $this->getDefaultSharableTitle($args);
		}

		return _( $this->sharable_title );
	}

	/**
	 * Retrieve something usable as a title
	 */
	function getDefaultSharableTitle($args = []) {

		if( $this->sharable_type === 'youtube' ) {
			if( isset( $args['prop'] ) && $args['prop'] ) {
				return sprintf(
					_("il %s"),
					_("video esterno")
				);
			} else {
				return _("video esterno");
			}
		}

		// Get filename from "/asd/asd/asd/(filename)"
		$i = 0;
		while( strpos($this->sharable_path, '/', $i) !== false ) {
			$i++;
		}
		return substr($this->sharable_path, $i);
	}

	function isSharableImage() {
		return $this->sharable_type === 'image';
	}

	function isSharableVideo() {
		return $this->sharable_type === 'video';
	}

	function isSharableDocument() {
		return $this->sharable_type === 'document';
	}

	function isSharableDownloadable() {
		return $this->sharable_type !== 'youtube';
	}

	function getSharableLicense() {
		return license( $this->sharable_license );
	}

	function getSharablePath() {
		$t = $this->sharable_type;
		$p = $this->sharable_path;

		if($t === 'youtube') {
			return "https://www.youtube.com/watch?v={$p}";
		}

		return site_page($p, ROOT);
	}

	function getSharableMIME() {
		return $this->sharable_mimetype;
	}
}

class Sharable {
	use SharableTrait;

	function __construct() {
		self::normalize($this);
	}

	static function normalize(& $t) {
		if( isset( $t->sharable_ID ) ) {
			$t->sharable_ID = (int) $t->sharable_ID;
		}
	}

	static function querySharables($event_ID) {
		global $T;

		return query(
			sprintf(
				"SELECT * FROM {$T('sharable')} WHERE event_ID = %d",
				$event_ID
			),
			'Sharable'
		);
	}
}
