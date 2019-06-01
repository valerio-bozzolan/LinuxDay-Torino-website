<?php
# Linux Day 2016 - Construct a database Subscription
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Linux Day Torino
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

	/**
	 * Get the subscription ID
	 *
	 * @return int
	 */
	public function getSubscriptionID() {
		return $this->nonnull( 'subscription_ID' );
	}

	/**
	 * Get the subscription e-mail
	 *
	 * @return string
	 */
	public function getSubscriptionEmail() {
		return $this->get('subscription_email');
	}

	function getSubscriptionDate($f = 'Y-m-d H:i:s') {
		return $this->get('subscription_date')->format($f);
	}

	/**
	 * Normalize a Subscription object
	 */
	protected function normalizeSubscription() {
		$this->integers(
			'subscription_ID',
			'event_ID'
		);
		$this->booleans( 'subscription_confirmed' );
	}
}

/**
 * A Subscription is someone subscribed to a certain Event
 */
class Subscription extends Queried {
	use SubscriptionTrait;

	/**
	 * Database table name
	 */
	const T = 'subscription';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeSubscription();
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
