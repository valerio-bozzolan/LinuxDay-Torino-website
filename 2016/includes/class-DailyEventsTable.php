<?php
# Linux Day 2016 - Print a daily rappresentation of events
# Copyright (C) 2016, 2017 Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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
class DailyEventsTable {
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

	function __construct( $conference_ID, $chapter_ID ) {

		$events = DailyEvents::fromConferenceChapter( $conference_ID, $chapter_ID );

		foreach($events as $event) {
			$track_uid = $event->getTrackUID();

			$this->events[ $event->hour ][ $track_uid ] = $event;

			if( ! isset( $this->tracks[ $event->track_uid ] ) ) {
				$this->tracks[ $track_uid ] = $event;
			}
		}

		// The number of hours is the hour of the last event
		$this->hours = $events ? end($events)->hour : 0;

		$this->n = count($events);
	}

	/**
	 * It seems that it can exists a `table` function in a class but you CAN'T call it without a parse error.
	 * PHP MERDA.
	 */
	function printTable() {
		if( ! isset( $this->tracks ) ) {
			_e("asd! No.");
			return;
		}
	?>

		<table class="bordered striped hoverable responsive-table">
		<thead>
			<tr>
				<th><!-- asd --></th>

				<?php foreach($this->tracks as $track): ?>
				<th class="tooltipped" data-position="top" data-tooltip="<?php _esc_attr( $track->getTrackLabel() ) ?>"><?php echo $track->getTrackName() ?></th>
				<?php endforeach ?>
			</tr>
		</thead>
		<tbody>

			<?php for($h = 1; $h <= $this->getHours(); $h++): ?>
			<tr class="hoverable">
				<th><?php printf(
					__("%d° ora"),
					$h
				) ?></th>
				<?php foreach($this->getTracks() as $track): ?>
				<td><?php
					if( isset( $this->events[$h][$track->track_uid] ) ) {
						$event_title = $this->events[$h][$track->track_uid]->getEventTitle();

						$title = HTML::a(
							$this->events[$h][$track->track_uid]->getEventURL( ROOT ),
							sprintf(
								"<strong>%s</strong>",
								$event_title
							),
							sprintf(
								__("Talk %s"),
								$event_title
							)
						);
						printf(
							__("%s<br /> di %s."),
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

		</tbody>
		</table>

	<?php
	}

	private function getImplodedUsers($h, $t) {
		$users = $this->getUsers($h, $t);

		if( ! $users ) {
			return "//";
		}

		$n = count($users);
		foreach($users as & $user) {
			$user = $user->getUserLink( ROOT );
		}

		$last = $n > 1 ? array_pop($users) : false;
		$s = implode( __(", "), $users);
		if($last) {
			$s = sprintf( __("%s e %s"), $s, $last);
		}

		return $s;
	}

	private function getUsers($h, $t) {
		$event_ID = $this->events[$h][$t]->getEventID();

		return User::factoryByEvent( $event_ID )
			->select(
				'user_name',
				'user_surname',
				'user_uid'
			)
			->queryResults();
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

	function countTracks() {
		return count( $this->tracks );
	}
}
