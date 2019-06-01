<?php
# Linux Day 2016 - API to generate a strange ical file
# Copyright (C) 2019 Ludovico Pavesi
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

function get_ical($id, $title, $start, $end, $url = null, $description = null, $geo_x = null, $geo_y = null) {
    $rn = "\r\n";
    
    $dtstart = date('Ymd\Tgis\Z', $start);
    $dtstart = date('Ymd\Tgis\Z', $end);
    $dtstart = date('Ymd\Tgis\Z', time());
    $title = htmlspecialchars($title);
    if($description === null) {
        $opt_description = '';
    } else {
        $opt_description = 'DESCRIPTION:' + htmlspecialchars($description);
    }
    if($url === null) {
        $opt_url = '';
    } else {
        $opt_url = 'URL;VALUE=URI:' + htmlspecialchars($url);
    }
    if($geo_x === null || $geo_y === null) {
        $opt_geo = '';
    } else {
        $opt_geo = "GEO:$geo_x;$geo_y";
    }

    $ics = <<<EOD
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//ldto/asd//NONSGML v1.0//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
UID:$id
SUMMARY:$title
$opt_description
$opt_url
DTSTART:$dtstart
DTEND:$dtend
DTSTAMP:$dtstamp
END:VEVENT
END:VCALENDAR
EOD;

return str_replace(["\n"], "\r\n", $ics);

}
