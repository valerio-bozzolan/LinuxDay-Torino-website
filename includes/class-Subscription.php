<?php
# Linux Day 2016 - Construct a database Subscription
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

trait SubscriptionTrait {
	function getSubscriptionID() {
		isset( $this->subscription_ID )
			|| error_die("Missing subscription_ID");

		return $this->subscription_ID;
	}

	function getSubscriptionEmail() {
		isset( $this->subscription_email )
			|| error_die("Missing subscription_email");

		return $this->subscription_email;
	}


	function getSubscriptionDate($f = 'Y-m-d H:i:s') {
		return $this->subscription_date->format($f);
	}
}

class Subscription {
	use SubscriptionTrait;

	function __construct() {
		self::normalize($this);
	}

	static function normalize(& $t) {
		if( isset( $t->subscription_ID ) ) {
			$t->subscription_ID = (int) $t->subscription_ID;
		}

		if( isset( $t->subscription_date ) ) {
			datetime2php($t->subscription_date);
		}
	}

	static function insert($email, $event_ID, $token = null) {
		$email = luser_input($email, 45);

		insert_row('subscription', [
			new DBCol('subscription_email',     $email,    's'    ),
			new DBCol('subscription_confirmed', 0,         'd'    ),
			new DBCol('subscription_date',      'NOW()',   '-'    ),
			new DBCol('subscription_token',     $token,    'snull'),
			new DBCol('event_ID',               $event_ID, 'd'    )
		] );
		return last_inserted_ID();
	}

	/**
	 * Single subscription
	 */
	static function getStandardQuery($email, $event_ID) {
		$q = self::getStandardQueryAll($event_ID);
		return $q->appendCondition( sprintf(
			"subscription_email = '%s'",
			esc_sql( $email )
		) );
	}

	/**
	 * All subscription
	 */
	static function getStandardQueryAll($event_ID) {
		$q = new DynamicQuery();
		$q->useTable('subscription');
		return $q->appendCondition( sprintf(
			"subscription.event_ID = %d",
			$event_ID
		) );
	}

	static function genToken($length = 20) {
		$dict = '23456789abcdefghijklmnpqrstuvwxyzABCDEFGHLMNPQRSTUVZ';
		$n = strlen($dict) - 1;
		$s = '';
	        for($i=0; $i<$n; $i++) {
	                $s .= $c[ rand(0, $l) ];
	        }
	        return $s;
	}
}
