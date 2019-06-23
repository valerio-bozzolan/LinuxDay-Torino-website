<?php
# Linux Day 2016 - Messagebox
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

class Messagebox {
	const ERROR = 'error';
	const WARN  = 'warning';
	const INFO  = 'info';

	function __construct($message, $type = 'info') { ?>

	<div class="container">
		<div class="card-panel <?= self::color($type) ?>">
			<p class="flow-text"><?= icon( self::icon($type), 'left' ); echo $message ?></p>
		</div>
	</div>

<?php	}

	static function icon($type) {
		$types = [
			'info'    => 'info_outline',
			'error'   => 'error_outline',
			'warning' => 'warning'
		];
		return $types[ $type ];
	}

	static function color($type) {
		$colors = [
			'info'    => 'blue lighten-2',
			'error'   => 'red accent-4 white-text',
			'warning' => 'purple lighten-5'
		];
		return $colors[ $type ];
	}
}
