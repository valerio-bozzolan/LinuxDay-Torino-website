<?php
# Linux Day 2016 - Homepage
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

class TalkersTable {
	private $talkers = [];

	function getTalkers($h, $t) {
		if( isset( $this->talkers[$h][$t] ) ) {
			return $this->talkers[$h][$t];
		}

		return false;
	}

	function getImplodedTalkers($h, $t) {
		$talkers = $this->getTalkers($h, $t);
		if( ! $talkers ) {
			return _("?");
		}

		$n = count( $talkers ) - 1;

		$last = $talkers[ $n ]->getUserFullName();

		if( $n > 0 ) {
			$comma = _(", ");
			$s = '';
			for($i = 0; $i < $n; $i++) {
				if( $i ) {
					$s .= $comma;
				}
				$s .= $talkers[ $i ]->getUserFullName();
			}

			return sprintf(
				_("%s e %s"),
				$s, $last
			);
		}

		return $last;
	}

	function __construct() {
		$talkers = Talker::queryTalkers();

		foreach($talkers as $talker) {
			$this->talkers[ $talker->talk_hour ][ $talker->talk_type ][] = $talker;
		}
	?>

		<table class="bordered striped hoverable">
			<tr>
				<th><?php _e("Ora") ?></th>

				<?php foreach(Talk::$AREAS as $area): ?>
				<th><?php echo Talk::getTalkType($area) ?></th>
				<?php endforeach ?>
			</tr>

			<?php for($h = 1; $h < Talk::HOURS; $h++): ?>
			<tr class="hoverable">
				<th><?php echo Talk::getTalkHour($h) ?></th>
				<?php foreach(Talk::$AREAS as $area): ?>
				<td><?php
					$talker = $this->getTalkers($h, $area);

					if( $talker ) {
						$title = "<strong>{$talker[0]->getTalkTitle()}</strong>";
						printf(
							_("%s di %s."),
							$title,
							$this->getImplodedTalkers($h, $area)
						);
					} else {
						_e("?");
					}
				?></td>
				<?php endforeach ?>
			</tr>
			<?php endfor ?>

		</table>

	<?php
	}
}
