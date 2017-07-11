<?php
# Linux Day 2016 - Construct a database event-user relaction
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

trait EventUserTrait {
	function getEventUserOrder() {
		return $this->get('event_user_order');
	}

	/**
	 * Can be called statically.
	 */
	function deleteEventUser($event_ID = null, $user_ID = null) {
		if( $event_ID === null ) {
			$event_ID = $this->getEventID();
		}
		if( $user_ID === null ) {
			$user_ID  = $this->getUserID();
		}
		EventUser::delete($event_ID, $user_ID);
	}

	private function normalizeEventUser() {
		$this->integers('event_user_order');

		$this->normalizeEvent();
		$this->normalizeUser();
	}
}

class_exists('Event');
class_exists('User');

class EventUser extends Queried {
	use EventUserTrait;
	use EventTrait;
	use UserTrait;

	function __construct() {
		$this->normalizeEventUser();
	}

	static function delete($event_ID, $user_ID) {
		query( sprintf(
			"DELETE FROM {$GLOBALS[T]('event_user')} WHERE event_ID = %d AND USER_ID = %d",
			$event_ID,
			$user_ID
		) );
	}
}
