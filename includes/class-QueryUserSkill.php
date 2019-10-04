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
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

// load dependent traits
class_exists( 'QueryUser', true );
class_exists( 'QuerySkill', true );

trait QueryUserSkillTrait {

	use QueryUserTrait;
	use QuerySkillTrait;

	/**
	 * Where the UserSkill is the specified one
	 *
	 * @param  object $userskill UserSkill
	 * @return self
	 */
	public function whereUserSkill( $userskill ) {
		return $this->whereUser(  $userskill )
		            ->whereSkill( $userskill );
	}

}

class QueryUserSkill extends Query {

	use QueryUserSkillTrait;

	/**
	 * Univoque Skill ID column name
	 */
	protected $SKILL_ID = 'user_skill.skill_ID';

	/**
	 * Univoque Skill ID column name
	 */
	const USER_ID = 'user_skill.user_ID';

	/**
	 * Constructor
	 *
	 * @param DB $db Database connection
	 */
	public function __construct( $db = null ) {

		// set database and default result class
		parent::__construct( $db = null, UserSkill::class );

		// set table FROM
		$this->from( UserSkill::T );
	}

}
