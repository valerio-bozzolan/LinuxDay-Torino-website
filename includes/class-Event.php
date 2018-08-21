<?php
# Linux Day 2016 - Construct a database event
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

trait EventTrait {
	function getEventID() {
		return $this->nonnull('event_ID');
	}

	function getEventUID() {
		return $this->get('event_uid');
	}

	function getEventTitle() {
		return _( $this->get('event_title') );
	}

	function getEventSubtitle() {
		return _( $this->get('event_subtitle') );
	}

	function getEventHumanStart() {
		return HumanTime::diff( $this->get('event_start') );
	}

	function getEventHumanEnd() {
		return HumanTime::diff( $this->get('event_end') );
	}

	function getEventStart($f = 'Y-m-d H:i:s') {
		return $this->get('event_start')->format($f);
	}

	function getEventEnd($f = 'Y-m-d H:i:s') {
		return $this->get('event_end')->format($f);
	}

	function hasEventImage() {
		return null !== $this->get('event_img');
	}

	function getEventImage($base = URL) {
		return site_page( $this->get('event_img') , $base );
	}

	function hasEventDescription() {
		return null !== $this->get('event_description');
	}

	function hasEventAbstract() {
		return null !== $this->get('event_abstract');
	}

	function hasEventNote() {
		return null !== $this->get('event_note');
	}

	function getEventDescription() {
		return $this->get('event_description');
	}

	function getEventAbstract() {
		return $this->get('event_abstract');
	}

	function getEventNote() {
		return $this->get('event_note');
	}

	function getEventDescriptionHTML($args = []) {
		return Markdown::parse( _( $this->getEventDescription() ), $args );
	}

	function getEventAbstractHTML($args = []) {
		return Markdown::parse( _( $this->getEventAbstract() ), $args );
	}

	function getEventNoteHTML($args = []) {
		return Markdown::parse( _( $this->getEventNote() ), $args );
	}

	function factoryUserByEvent() {
		return User::factoryByEvent( $this->getEventID() );
	}

	function factorySharebleByEvent() {
		return Sharable::factoryByEvent( $this->getEventID() );
	}

	function isEventEditable() {
		return has_permission('edit-events');
	}

	/**
	 * Insert subscription if not exists
	 */
	function addSubscription($email) {
		$exists = Subscription::getStandardQuery( $email, $this->getEventID() )->getRow('Subscription');

		$exists || Subscription::insert( $email, $this->getEventID() );

		return $exists;
	}

	function areEventSubscriptionsAvailable() {
		isset( $this->event_subscriptions )
			|| error_die("Missing event_subscriptions");

		return $this->event_subscriptions && ! $this->isEventPassed();
	}

	function isEventPassed() {
		$now = new DateTime('now');
		return $now->diff( $this->get('event_end') )->invert === 1;
	}

	function normalizeEvent() {
		$this->integers('event_ID');
		$this->datetimes(
			'event_start',
			'event_end'
		);
		$this->booleans('event_subscriptions');
	}
}

class Event extends Queried {

	use EventTrait;

	/**
	 * Database table name
	 */
	const T = 'event';

	/**
	 * Maximum UID length
	 *
	 * @override
	 */
	const MAXLEN_UID = 100;

	function __construct() {
		$this->normalizeEvent();
	}
}
