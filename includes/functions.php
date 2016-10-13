<?php
# Linux Day 2016 - Construct a database conference
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

function datetime2php(& $s) {
	$s = DateTime::createFromFormat('Y-m-d H:i:s', $s);
	$s->setTimezone( new DateTimeZone( DB_TIMEZONE ) );
}

function license($code) {
	expect('LICENSES');

	return $GLOBALS['LICENSES']->get($code);
}

function request_uri() {
	return URL_protocol() . URL_domain() . ROOT . $_SERVER['REQUEST_URI'];
}
