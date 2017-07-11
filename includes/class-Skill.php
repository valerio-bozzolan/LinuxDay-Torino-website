<?php
# Linux Day 2016 - Construct a database skill
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

trait SkillTrait {
	function getSkillID() {
		return $this->nonnull('skill_ID');
	}

	function getSkillUID() {
		return $this->get('skill_uid');
	}

	private function normalizeSkill() {
		$this->integers('skill_ID');
	}
}

class Skill extends Queried {
	use SkillTrait;

	const SUBJECT     = 'subject';
	const PROGRAMMING = 'programming';

	function __construct() {
		$this->normalizeSkill();
	}

	static function factory() {
		return Query::factory( __CLASS__ )
			->from('skill');
	}

	static function factoryByUID( $skill_uid ) {
		$skill_uid = self::normalizeUID( $skill_uid );

		return self::factory()
			->whereStr( 'skill_uid', $skill_uid );
	}

	private static function normalizeUID( $skill_uid ) {
		return luser_input( $skill_uid, 32 );
	}
}
