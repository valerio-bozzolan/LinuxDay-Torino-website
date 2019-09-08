<?php
# Linux Day Torino - Event
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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

	/**
	 * Get event ID
	 *
	 * @return int
	 */
	public function getEventID() {
		return $this->nonnull( Event::ID );
	}

	/**
	 * Get event UID
	 *
	 * @return string
	 */
	public function getEventUID() {
		return $this->get( Event::UID );
	}

	/**
	 * Get localized event title
	 *
	 * @return string
	 */
	public function getEventTitle() {
		return __( $this->get( Event::TITLE ) );
	}

	/**
	 * Check if the Event has a subtitle
	 *
	 * @return boolean
	 */
	public function hasEventSubtitle() {
		$title = $this->get( Event::SUBTITLE );
		return !empty( $title );
	}

	/**
	 * Get localized event subtitle
	 *
	 * @return string
	 */
	public function getEventSubtitle() {
		return __( $this->get( Event::SUBTITLE ) );
	}

	/**
	 * Get an human event start date
	 *
	 * @return string
	 */
	public function getEventHumanStart() {
		return HumanTime::diff( $this->getEventStart() );
	}

	/**
	 * Get an human event end date
	 *
	 * @return string
	 */
	public function getEventHumanEnd() {
		return HumanTime::diff( $this->getEventEnd() );
	}

	/**
	 * Get event start date
	 *
	 * @param string If present, format of the date
	 * @return DateTime|string
	 */
	public function getEventStart( $format = null ) {
		$date = $this->get( Event::START );
		if( $format ) {
			return $date->format( $format );
		}
		return $date;
	}

	/**
	 * When event end date
	 *
	 * @param string If present, format of the date
	 * @return DateTime|string
	 */
	public function getEventEnd( $format = null ) {
		$date = $this->get( Event::END );
		if( $format ) {
			return $date->format( $format );
		}
		return $date;
	}

	/**
	 * Get the event duration
	 *
	 * @return DateInterval
	 */
	public function getEventDuration( $format ) {
		$start = $this->get( Event::START );
		$end   = $this->get( Event::END   );
		return $start->diff( $end )->format( $format );
	}

	/**
	 * It has an event image?
	 *
	 * @return bool
	 */
	public function hasEventImage() {
		return null !== $this->get( Event::IMAGE );
	}

	/**
	 * Get the path to the Event image
	 *
	 * @param boolean $absolute Try to force an absolute URL
	 * @return string
	 */
	public function getEventImage( $absolute = false ) {
		return site_page( $this->get( Event::IMAGE ), $absolute );
	}

	/**
	 * It has event description?
	 *
	 * @return bool
	 */
	public function hasEventDescription() {
		return null !== $this->get( Event::DESCRIPTION );
	}

	/**
	 * It has an event abstract?
	 *
	 * @return bool
	 */
	public function hasEventAbstract() {
		return null !== $this->get( Event::ABSTRACT );
	}

	/**
	 * It has an event note?
	 *
	 * @return bool
	 */
	function hasEventNote() {
		return null !== $this->get( Event::NOTE );
	}

	/**
	 * Get the event description
	 *
	 * @return string
	 */
	public function getEventDescription() {
		return $this->get( Event::DESCRIPTION );
	}

	/**
	 * Get the event abstract
	 *
	 * @return string
	 */
	public function getEventAbstract() {
		return $this->get( Event::ABSTRACT );
	}

	/**
	 * Get the event note
	 *
	 * @return string
	 */
	public function getEventNote() {
		return $this->get( Event::NOTE );
	}

	function getEventDescriptionHTML( $args = [] ) {
		return Markdown::parse( __( $this->getEventDescription() ), $args );
	}

	function getEventAbstractHTML( $args = [] ) {
		return Markdown::parse( __( $this->getEventAbstract() ), $args );
	}

	function getEventNoteHTML( $args = [] ) {
		return Markdown::parse( __( $this->getEventNote() ), $args );
	}

	/**
	 * Factory Users by this event
	 *
	 * @return Query
	 */
	public function factoryUserByEvent() {
		return User::factoryByEvent( $this->getEventID() );
	}

	/**
	 * Factory Sharables by this event
	 *
	 * @return Query
	 */
	public function factorySharebleByEvent() {
		return Sharable::factoryByEvent( $this->getEventID() );
	}

	/**
	 * You can edit this event?
	 *
	 * @return bool
	 */
	public function isEventEditable() {
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

	/**
	 * Get URL to trop-iCal API for this event
	 *
	 * @param boolean $absolute Set to true for an absolute URL
	 * @return string
	 */
	public function getEventCalURL( $absolute = false ) {
		$event = urlencode( $this->getEventUID() );
		$conf  = urlencode( $this->getConferenceUID() );
		return site_page( "api/tropical.php?conference=$conf&event=$event", $absolute );
	}

	/**
	 * Are event subscriptions available?
	 *
	 * @return bool
	 */
	public function areEventSubscriptionsAvailable() {
		return $this->get( 'event_subscriptions' ) && ! $this->isEventPassed();
	}

	/**
	 * Is event passed?
	 *
	 * @return bool
	 */
	public function isEventPassed() {
		$now = new DateTime('now');
		return $now->diff( $this->get('event_end') )->invert === 1;
	}

	/**
	 * Normalize an Event object
	 */
	protected function normalizeEvent() {
		$this->integers( Event::ID );
		$this->datetimes(
			Event::START,
			Event::END
		);
		$this->booleans('event_subscriptions');
	}
}

/**
 * An Event can be a talk or a lesson etc.
 */
class Event extends Queried {

	use EventTrait;

	/**
	 * Database table name
	 */
	const T = 'event';

	/**
	 * ID column name
	 */
	const ID = 'event_ID';

	/**
	 * UID column name
	 */
	const UID = 'event_uid';

	/**
	 * Title column name
	 */
	const TITLE = 'event_title';

	/**
	 * Subtitle column name
	 */
	const SUBTITLE = 'event_subtitle';

	/**
	 * Image column name
	 */
	const IMAGE = 'event_img';

	/**
	 * Start column name
	 */
	const START = 'event_start';

	/**
	 * End column name
	 */
	const END = 'event_end';

	/**
	 * Description column name
	 */
	const DESCRIPTION = 'event_description';

	/**
	 * Abstract column name
	 */
	const ABSTRACT = 'event_abstract';

	/**
	 * Note column name
	 */
	const NOTE = 'event_note';

	/**
	 * Language column name
	 */
	const LANGUAGE = 'event_language';

	/**
	 * Complete ID column name
	 */
	const ID_ = self::T . DOT . self::ID;

	/**
	 * Complete conference ID column name
	 */
	const CONFERENCE_ = self::T . DOT . Conference::ID;

	/**
	 * Complete room ID column name
	 */
	const ROOM_ = self::T . DOT . Room::ID;

	/**
	 * Complete track ID column name
	 */
	const TRACK_ = self::T . DOT . Track::ID;

	/**
	 * Complete chapter ID column name
	 */
	const CHAPTER_ = self::T . DOT . Chapter::ID;

	/**
	 * Maximum UID length
	 *
	 * @override
	 */
	const MAXLEN_UID = 100;

	/**
	 * Constructor
 	 */
	public function __construct() {
		$this->normalizeEvent();
	}
}
