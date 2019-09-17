<?php
# Linux Day Torino website
# Copyright (C) 2019 Valerio Bozzolan and contributors
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
 * Require a certain page from the template directory
 *
 * @param $name string page name (to be sanitized)
 * @param $args mixed arguments to be passed to the page scope
 */
function template( $template_name, $template_args = [] ) {
	extract( $template_args, EXTR_SKIP );
	return require CURRENT_CONFERENCE_ABSPATH . "/template/$template_name.php";
}

/**
 * Return a Materialize icon tag
 *
 * @param string $icon Icon name
 * @param string $c    Additional class name
 */
function icon( $icon = 'send', $c = null ) {
	if( $c !== null ) {
		$icon = "$icon $c";
	}
	return "<i class=\"fa fa-$icon\" aria-hidden=\"true\"></i>";
}
