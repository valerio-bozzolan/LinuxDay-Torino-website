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

class Talk {

    // queryTalks() sets these variables
    private $title;
    public $track;
    private $start;
    private $end;
    public $hour;

    // These are used both in database queries (tracks.name) and displayed to the user!
    static $AREAS = ['Base', 'Dev', 'Sysadmin', 'Misc'];
    const HOURS = 4;

    function __construct() {
        self::prepareTalk($this);
    }

    static function prepareTalk(& $t) {
        if( isset( $t->talk_ID ) ) {
            $t->talk_ID   = (int) $t->talk_ID;
        }
        if( isset( $t->talk_hour ) ) {
            $t->talk_hour = (int) $t->talk_hour;
        }
    }

    /**
     * The human-readable name of the talk type (a.k.a. track), can be called statically.
     *
     * @param string|null $t track or null to use $this->track
     * @return string
     * @see Talk::$AREAS
     */
    function getTalkType($t = null) {
        if($t === null) {
            isset($this->talk)
            || error_die("Missing talk type");

            // Yay for recursion!
            return self::getTalkType($this->track);
        }

        return sprintf(
            _("Area %s"),
            $t
        );
    }

    /**
     * The human-readable talk hour, can be called statically.
     *
     * @param int|null $h hour or null to use $this->hour
     * @return string
     */
    function getTalkHour($h = null) {
        if( $h === null ) {
            isset( $this->hour )
            || error_die("Missing talk hour");

            return self::getTalkHour( $this->hour );
        }

        return sprintf( _("%d° ora"), $h );
    }

    function getTalkUsers() {
        isset( $this->talk_ID )
        || error_die("Missing talk_ID");

        return query_results(
            sprintf(
                "SELECT " .
                "user.user_uid, ".
                "user.user_name, ".
                "user.user_surname ".
                " FROM ".
                $GLOBALS[JOIN]('talker', 'user').
                " WHERE ".
                "talker.talk_ID = %d AND ".
                "talker.user_ID = user.user_ID"
                ,
                $this->talk_ID
            )
        );
    }

    function getTalkTitle() {
        return $this->title;
    }

	static function queryTalks() {
	    $where = '';
        $count_minus_one = count(self::$AREAS)-1;
	    for($i = 0; $i <= $count_minus_one; $i++) {
	        $where .= ' tracks.name=\''.self::$AREAS[$i].'\'';
            if($i !== $count_minus_one) {
                $where .= ' OR';
            }
        }

		$talks = query_results(
			"SELECT ".
				"`events`.title, ".
				"tracks.name AS track, ".
				"`events`.`start`, ".
				"`events`.`end` ".
			" FROM `events`".
			" JOIN tracks ".
				"ON tracks.id=`events`.track ".
            " WHERE (".$where.") AND `events`.conference_id=".CONFERENCE_ID.
			" ORDER BY ".
				"`events`.`start`, tracks.name",
			'Talk'
		);


        // try to guess hours...
        $start_times = [];
        foreach($talks as $talk) {
            $start_times[] = $talk->start;
        }
        $start_to_hour_counter = array_flip(array_values(array_unique($start_times)));

        foreach($talks as $talk) {
            $talk->hour = $start_to_hour_counter[$talk->start];
        }

        return $talks;
	}
}
