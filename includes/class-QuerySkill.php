<?php
# Linux Day Torino Website
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Linux Day Torino contributors
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.

trait QuerySkillTrait {

	/**
	 * Where the Skill is the specified one
	 *
	 * @param  object $skill
	 * @return self
	 */
	public function whereSkill( $skill ) {
		return $this->whereSkillID( $skill->getSkillID() );
	}

	/**
	 * Where the Skil ID is the specified one
	 *
	 * @param  int $id Skill ID
	 * @return self
	 */
	public function whereSkillID( $id ) {
		return $this->whereInt( $this->SKILL_ID, $id );
	}

}

class QuerySkill extends Query {

	use QuerySkillTrait;

	/**
	 * Univoque Skill ID column name
	 */
	protected $SKILL_ID = 'skill.skill_ID';

	/**
	 * Constructor
	 *
	 * @param DB $db Database connection
	 */
	public function __construct( $db = null ) {

		// set database and default result class
		parent::__construct( $db = null, Skill::class );

		// set table FROM
		$this->from( Skill::T );
	}

}
