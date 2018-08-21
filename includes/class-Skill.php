<?php
# Linux Day 2016 - Construct a database skill
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

trait SkillTrait {

	/**
	 * Get the skill ID
	 *
	 * @return int
 	 */
	public function getSkillID() {
		return $this->nonnull( 'skill_ID' );
	}

	/**
	 * Get the skill UID
	 *
	 * @return int
 	 */
	public function getSkillUID() {
		return $this->get( 'skill_uid' );
	}

	/**
	 * Normalize a Skill object
	 */
	protected function normalizeSkill() {
		$this->integers( 'skill_ID' );
	}
}

/**
 * A Skill is something you are able to do it
 */
class Skill extends Queried {
	use SkillTrait;

	/**
	 * Database table name
	 */
	const T = 'skill';

	/**
	 * Maximum UID length
	 *
	 * @override
	 */
	const MAXLEN_UID = 32;

	const SUBJECT     = 'subject';
	const PROGRAMMING = 'programming';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeSkill();
	}
}
