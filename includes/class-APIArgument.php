<?php
# Linux Day 2016 - API Argument (see APIDocumentation.php)
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

class APIArgument {
	public $arg;
	public $type;
	public $comment;
	public $optional;

	function __construct($arg, $type, $comment, $optional = false) {
		$this->arg = $arg;
		$this->type = $type;
		$this->comment = $comment;
		$this->optional = $optional;
	}

	public function getArg() {
		return $this->arg;
	}

	public function getType() {
		$s = $this->type;

		if($s === 's')
			return _("stringa");

		return $s;
	}

	public function getComment() {
		return $this->comment;
	}

	public function isOptional() {
		return $this->optional;
	}
}
