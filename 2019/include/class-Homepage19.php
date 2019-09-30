<?php
# Linux Day Torino website
# Copyright (C) 2019 Ludovico Pavesi, Valerio Bozzolan and contributors
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.

/**
 * Some utilities for the 2019 Homepage
 */
class Homepage19 {

	/**
	 * Query all the Events from this Conference
	 *
	 * Query all the events that belongs to this Conference
	 * and that belongs to this Track.
	 *
	 * @param object $conference Conference
	 * @param string $track      Track
	 * @generator
	 */
	public static function eventsFromConferenceTrack( $conference, $track ) {
		return FullEvent::factoryByConference( $conference->getConferenceID() )
				->select( [
					Conference::UID,
					Event::ID_,
					Event::TITLE,
					Event::SUBTITLE,
					Event::ABSTRACT,
					Event::START,
					Event::END,
					Event::UID,
					Track::UID,
					Chapter::UID,
					Room::UID,
				] )
				->whereStr( Track::UID, $track )
				->orderBy(  Event::START, 'ASC' )
				->queryGenerator();
	}

	/**
	 * Get the list some authors of an Event
	 *
	 * @param  Event $event
	 * @param  string $default Default text
	 * @return string
	 */
	public static function listEventAuthors( $event, $default ) {

		// prepare to request Event's Users
		$query = new Query();
		$query->from( EventUser::T );

		// limit to this event
		$query->whereInt( 'event_ID', $event->getEventID() );

		// join with Users
		$query->joinOn( 'INNER', User::T, User::ID_, EventUser::USER_ );

		// order by User name
		$query->orderBy( 'user_name' );

		// run the query and get a Generator
		$users = $query->queryGenerator( EventUser::class );

		// collect the entries
		$all = [];
		foreach( $users as $user ) {
			$all[] = HTML::a(
				$user->getUserURL(),
				esc_html( $user->getUserFullName() )
			);
		}

		return $all
			? implode( ', ', $all )
			: $default;
	}

}
