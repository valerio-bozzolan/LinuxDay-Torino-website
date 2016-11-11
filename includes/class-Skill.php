<?php
# Linux Day 2016 - Construct a database skill
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

trait SkillTrait {
	function getSkillCode() {
		$score = $this->skill_score;
		if($score === 0) {
			return $this->skill_uid . '?';
		}
		$piece = ($score <= 0) ? '-' : '+';
		return $this->skill_uid . str_repeat($piece, abs( $score) );
	}

	function isPositiveSkill() {
		return $this->skill_score > 0;
	}

	function getHumanSkillAmount() {
		$n = $this->skill_score;
		$t = $this->skill_type;

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
			esc_html( $this->skill_title )
		);
	}

	function getSkillID() {
		isset( $this->skill_ID )
			|| error_die("Missing skill_ID");

		return $this->skill_ID;
	}

	function getSkillUID() {
		isset( $this->skill_uid )
			|| error_die("Missing skill_uid");

		return $this->skill_uid;
	}
}

class Skill {
	use SkillTrait;

	const SUBJECT = 'subject';
	const PROGRAMMING = 'programming';

	function __construct() {
		self::normalize($this);
	}

	static function normalize(& $t) {
		if( isset( $t->skill_ID ) ) {
			$t->skill_ID = (int) $t->skill_ID;
		}

		if( isset( $t->skill_score ) ) {
			$t->skill_score = (int) $t->skill_score;
		}
	}

	static function get($uid) {
		global $T;

		return query_row(
			sprintf(
				"SELECT * FROM {$T('skill')} WHERE skill_uid = '%s'",
				esc_sql( luser_input( $uid, 32) )
			),
			'Skill'
		);
	}

	static function getQueryUserSkills($user_ID) {
		global $JOIN;

		return sprintf(
			'SELECT '.
				'skill_uid, '.
				'skill_title, ' .
				'skill_score, ' .
				'skill_type '.
				"FROM {$JOIN('user_skill', 'skill')} ".
			'WHERE '.
				'user_skill.user_ID = %d AND '.
				'user_skill.skill_ID = skill.skill_ID ' .
			'ORDER BY skill_score < 0, ABS(skill_score)'

			,

			$user_ID
		);
	}
}
