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
	static function prepareSkill(& $t) {
		if( isset( $t->skill_ID ) ) {
			$t->skill_ID = (int) $t->skill_ID;
		}

		if( isset( $t->skill_score ) ) {
			$t->skill_score = (int) $t->skill_score;
		}
	}

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

		if($n === 0)  return _("%s per me potrebbe essere qualcosa che si mangia");
		if($n === 1)  return _("ho conoscenze %s di base");
		if($n === 2)  return _("sono discretamente bravo in %s");
		if($n === 3)  return _("%s è il mio cavallo di battaglia");
		if($n > 3)    return _("%s: l'essenza stessa della mia vita");
		if($n === -1) return _("sono davvero scarso con %s");
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
}

class Skill {
	use SkillTrait;

	function __construct() {
		self::prepareSkill($this);
	}

	static function getQueryUserSkills($user_ID) {
		global $JOIN;

		return sprintf(
			'SELECT '.
				'skill_uid, '.
				'skill_title, ' .
				'skill_score ' .
				"FROM {$JOIN('user_skill', 'skill')} ".
			'WHERE '.
				'user_skill.user_ID = %d AND '.
				'user_skill.skill_ID = skill.skill_ID ' .
			'ORDER BY skill_score < 0, ABS(skill_score)'

			, $user_ID
		);
	}
}
