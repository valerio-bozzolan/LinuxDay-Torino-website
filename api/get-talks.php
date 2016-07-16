<?php
# Linux Day 2016 - API Documentation
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

require '../load.php';

$talks = query_results(
	"SELECT talk_ID, talk_uid, talk_title, talk_type, talk_hour " .
	"FROM {$T('talk')} " .
	"ORDER BY talk_hour",
	'Talk'
);

foreach($talks as $i => $talk) {
	// Fetch users
	$talks[ $i ]->talkers = $talk->getTalkUsers();

	// Unuseful informations
	unset( $talks[$i]->talk_ID );
}

http_json_header();

$flags = 0;
if( DEBUG ) {
	$flags += JSON_PRETTY_PRINT;
}

echo json_encode( [
		'talks' => $talks
	],
	$flags
);
