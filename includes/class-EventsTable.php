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

/**
 * Print an hour-based events table
 */
class EventsTable {
	/**
	 * @type integer
	 */
	private $hours;

	/**
	 * @type array Array of tracks
	 */
	private $tracks;

	/**
	 * Bi-dimensional array of events indexed by [ $hour ][ $track_uid ]
	 *
	 * @type array Bi-dimensional array of database results
	 */
	private $events;

	/**
	 * Total of events
	 */
	private $n;

	function __construct() {
		$events = Event::queryEvents();

		foreach($events as $event) {
			///////////////////////////////////////////////////////////////////////
			// @include the strangest note somewhere in the Event::queryEvents() //
			///////////////////////////////////////////////////////////////////////
			$this->events[ $event->hour ][ $event->track_uid ] = $event;

			///////////////////////////////////////////////////////////////////////
			// @include the strangest note somewhere in the Event::queryEvents() //
			///////////////////////////////////////////////////////////////////////
			if( ! isset( $this->tracks[ $event->track_uid ] ) ) {
				$this->tracks[ $event->track_uid  ] = $event;
			}
		}

		// The number of hours is the hour of the last event
		$this->hours = end($events)->hour;

		$this->n = count($events);
	}

	/**
	 * It seems that it can exists a `table` function in a class but you CAN'T call it without a parse error.
	 * PHP MERDA.
	 */
	function printTable() {
	?>

		<table class="bordered striped hoverable">
			<tr>
				<th><?php _e("Ora") ?></th>

				<?php foreach($this->tracks as $track): ?>
				<th><?php echo $track->track_name ?></th>
				<?php endforeach ?>
			</tr>

			<?php for($h = 1; $h <= $this->getHours(); $h++): ?>
			<tr class="hoverable">
				<th><?php printf(
					_("%d° ora"),
					$h
				) ?></th>
				<?php foreach($this->getTracks() as $track): ?>
				<td><?php
					if( isset( $this->events[$h][$track->track_uid] ) ) {
						$title = "<strong>{$this->events[$h][$track->track_uid]->event_title}</strong>";
						printf(
							_("%s di %s."),
							$title,
							$this->getImplodedUsers($h, $track->track_uid)
						);
					} else {
						_e("Nessun talk pianificato.");
					}
				?></td>
				<?php endforeach ?>
			</tr>
			<?php endfor ?>

		</table>

	<?php
	}

	function getImplodedUsers($h, $t) {
		$users = $this->getUsers($h, $t);

		if( ! $users ) {
			return _("nessuno");
		}

		$users = $this->events[$h][$t]->users;

		$n = count($users) - 1;

		if($n > 0) {
			$comma = _(", ");
			$s = '';
			for($i = 0; $i < $n; $i++) {
				if( $i ) {
					$s .= $comma;
				}
				$s .= $users[$i]->getUserProfileLink();
			}
			return sprintf(
				_("%s e %s"),
				$s, $users[$n]->getUserProfileLink()
			);
		} else {
			return $users[0]->getUserProfileLink();
		}
	}

	function getUsers($h, $t) {
		return $this->events[$h][$t]->users;
	}

	function getHours() {
		return $this->hours;
	}

	function getTracks() {
		return $this->tracks;
	}

	function countEvents() {
		return $this->n;
	}
}
