<?php
# Linux Day 2016 - Construct a database chapter
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

trait ChapterTrait {
	function getChapterID() {
		isset( $this->chapter_ID )
			|| error_die("Missing chapter_ID");

		return $this->room_ID;
	}

	function getChapterUID() {
		isset( $this->chapter_uid )
			|| error_die("Missing chapter_uid");

		return $this->chapter_uid;
	}

	function getChapterName() {
		return _( $this->chapter_name );
	}
}

class Chapter {
	use ChapterTrait;

	function __construct() {
		self::normalize($this);
	}

	static function normalize(& $t) {
		if( isset( $t->chapter_ID ) ) {
			$t->chapter_ID = (int) $t->chapter_ID;
		}
	}

	static function get($uid) {
		global $T;

		return query_row(
			sprintf(
				"SELECT * FROM {$T('chapter')} WHERE chapter_uid = '%s'",
				esc_sql( luser_input( $uid, 32) )
			),
			'Chapter'
		);
	}
}
