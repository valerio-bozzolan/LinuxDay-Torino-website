<?php
# Linux Day 2016 - Print a daily rappresentation of events
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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
	 * Conference
	 *
	 * @type object
	 */
	private $conference;

	/**
	 * Chapter
	 *
	 * @type object
	 */
	private $chapter;

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

	/**
	 * Constructor
	 *
	 * @param $conference object Conference
	 * @param $chaptet object Chapter
	 * @param $fields array Fields to be selected
	 */
	public function __construct( $conference, $chapter, $fields = [] ) {

		$this->conference = $conference;
		$this->chapter    = $chapter;

		$events = DailyEvents::fromConferenceChapter( $conference, $chapter, $fields );

		foreach( $events as $event ) {
			$track_uid = $event->getTrackUID();

			$this->events[ $event->hour ][ $track_uid ] = $event;

			if( ! isset( $this->tracks[ $track_uid ] ) ) {
				$this->tracks[ $track_uid ] = $event;
			}
		}

		// The number of hours is the hour of the last event
		$this->hours = $events ? end( $events )->hour : 0;

		$this->n = count( $events );
	}

	/**
	 * Print the daily events table
	 *
	 * N.B. It seems that it can exists a `table` function in a class but you CAN'T call it without a parse error.
	 * PHP MERDA.
	 */
	public function printTable() {
		if( ! isset( $this->tracks ) ) {
			echo __("asd! No.");
			return;
		}

		$conference_uid = $this->conference->getConferenceUID();
		$chapter_uid = $this->chapter->getChapterUID();
	?>

		<table class="bordered striped hoverable responsive-table">
		<thead>
			<tr>
				<th><!-- asd --></th>

				<?php foreach( $this->tracks as $track ): ?>
				<th class="tooltipped" data-position="top" data-tooltip="<?= esc_attr( $track->getTrackLabel() ) ?>"><?= esc_html( $track->getTrackName() ) ?></th>
				<?php endforeach ?>
			</tr>
		</thead>
		<tbody>

			<?php for( $h = 1; $h <= $this->getHours(); $h++ ): ?>
			<tr class="hoverable">
				<th><?php printf(
					__("%d° ora"),
					$h
				) ?></th>
				<?php foreach( $this->getTracks() as $track ): ?>
				<td><?php
					$track_uid = $track->getTrackUID();
					if( isset( $this->events[ $h ][ $track_uid ] ) ) {
						$event = $this->events[ $h ][ $track_uid ];

						$event_title = $event->getEventTitle();

						$title = HTML::a(
							FullEvent::permalink(
								$conference_uid,
								$event->getEventUID(),
								$chapter_uid
							),
							sprintf(
								"<strong>%s</strong>",
								$event_title
							),
							sprintf(
								__( "Talk %s" ),
								$event_title
							)
						);
						printf(
							__( "%s<br /> di %s." ),
							$title,
							$this->getImplodedUsers( $h, $track_uid )
						);
					} else {
						echo __( "Nessun talk pianificato." );
					}
				?></td>
				<?php endforeach ?>
			</tr>
			<?php endfor ?>

		</tbody>
		</table>

	<?php
	}

	private function getImplodedUsers( $h, $t ) {
		$event_ID = $this->events[ $h ][ $t ]->getEventID();

		$users = User::factoryByEvent( $event_ID )
			->select( [
				User::NAME,
				User::SURNAME,
				User::UID,
			] )
			->queryResults();

		if( ! $users ) {
			return "//";
		}

		foreach( $users as & $user ) {
			$user = $user->getUserLink( ROOT );
		}

		$last = count( $users ) > 1 ? array_pop( $users ) : false;
		$s = implode( __( ", " ), $users );
		if( $last ) {
			$s = sprintf( __( "%s e %s" ), $s, $last );
		}
		return $s;
	}

	/**
	 * Get how much hours
	 *
	 * @return int
	 */
	public function getHours() {
		return $this->hours;
	}

	/**
	 * Get all the tracks
	 *
	 * @return array
	 */
	public function getTracks() {
		return $this->tracks;
	}

	/**
	 * Count all the events
	 *
	 * @return int
	 */
	public function countEvents() {
		return $this->n;
	}

	/**
	 * Count all the tracks
	 *
	 * @return int
	 */
	public function countTracks() {
		return count( $this->tracks );
	}
}
