<?php
# Linux Day 2016 - Construct a database user skill
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

trait UserSkillTrait {

	function getSkillScore() {
		return $this->get('skill_score');
	}

	function getSkillCode() {
		$skill_uid = $this->get('skill_uid');
		$score = $this->get('skill_score');
		if($score === 0) {
			return $skill_uid . '?';
		}
		$piece = ($score <= 0) ? '-' : '+';
		return $skill_uid . str_repeat( $piece, abs($score) );
	}

	function getHumanSkillAmount() {
		$n = $this->get('skill_score');
		$t = $this->get('skill_type');

		if($n === 0)  return _("%s per me potrebbe essere qualcosa che si mangia");
		if($n === 1 ) return _("ho conoscenze %s di base");
		if($n === 2)  return $t === Skill::PROGRAMMING ? _("sono discretamente bravo in %s")   : _("sono molto interessato al mondo %s");
		if($n === 3)  return $t === Skill::PROGRAMMING ? _("%s... il mio cavallo di battaglia!") : _("%s... è un mio pensiero fisso!");
		if($n > 3)    return _("%s: l'essenza stessa della mia vita!");
		if($n === -1) return _("%s, sto cercando di smettere...");
		if($n === -2) return _("se mi tocca avere a che fare con %s poi mi faccio una doccia all'acqua ragia");
		if($n === -3) return _("se accenni a %s ti prendo a tastierate");

		return _("sono pronto ad uccidere se sento parlare di %s e non ho paura della galera");
	}

	function getSkillPhrase() {
		return sprintf(
			$this->getHumanSkillAmount(),
			esc_html( $this->get('skill_title') )
		);
	}

	function normalizeUserSkill() {
		$this->integers(
			'skill_score'
		);
		$this->normalizeSkill();
	}
}

class_exists('Skill');

class UserSkill extends Queried {
	use UserSkillTrait;
	use SkillTrait;

	function __construct() {
		$this->normalizeUserSkill();
	}

	static function factory() {
		return Query::factory( __CLASS__ )
			->from('user_skill');
	}

	static function factoryByUser( $user_ID ) {
		return self::factory()
			->whereInt( 'user_skill.user_ID', $user_ID );
	}

	static function factorySkillByUser( $user_ID ) {
		return self::factoryByUser( $user_ID )
			->from('skill')
			->equals('skill.skill_ID', 'user_skill.skill_ID')
			->orderBy('skill_score < 0, ABS(skill_score)');
	}

	static function querySkillByUser( $user_ID ) {
		return factorySkillByUser( $user_ID )
			->queryResults();
	}
}
