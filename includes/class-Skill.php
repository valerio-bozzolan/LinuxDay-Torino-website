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
		return $this->nonnull( Skill::ID );
	}

	/**
	 * Get the skill UID
	 *
	 * @return int
 	 */
	public function getSkillUID() {
		return $this->get( Skill::UID );
	}

	/**
	 * Normalize a Skill object
	 */
	protected function normalizeSkill() {
		$this->integers( Skill::ID );
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
	 * ID column name
	 */
	const ID = 'skill_ID';

	/**
	 * UID column name
	 */
	const UID = 'skill_uid';

	/**
	 * Title column name
	 */
	const TITLE = 'skill_title';

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
