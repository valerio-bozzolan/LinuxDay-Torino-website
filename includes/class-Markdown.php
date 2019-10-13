<?php
# Linux Day Torino website - Markdown autoloader
# Copyright (C) 2016, 2018, 2019 Valerio Bozzolan
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

include LIBMARKDOWN_PATH;

if( !file_exists( LIBMARKDOWN_PATH ) ) {
	error_die( 'please install php-markdown package or define a different LIBMARKDOWN_PATH into your /load.php' );
}

class Markdown {

	/**
	 * Prase a string in markdown and return an HTML rappresentation
	 *
	 * @param  string $s
	 * @param  array  $args
	 * @return array
	 */
	public static function parse( $s, $args = [] ) {

		// avoid <script> tags and so on
		$s = strip_tags( $s );

		// call libmarkdown stuff
		$s = markdown( $s );

		// Custom paragraph class
		if( ! empty( $args['p'] ) ) {

			$p = sprintf(
				'<p class="%s">',
				$args['p']
			);

			$s = str_replace( '<p>', $p, $s );
		}

		// stripping displayed link protocols
		$s = str_replace( [
			'>http://',
			'>https://'
		], '>', $s);

		// target blank as default
		$s = str_replace('<a ', '<a target="_blank" ', $s );

		// avoid 'javascript:' as URL
		if( preg_match( '/ href=. *javascript/', $s ) ) {
			$s = '<!-- XSS -->';
		}

		// avoid headings
		$s = strip_tags( $s, '<b><em><a><code><br><p><strong><ul><ol><li>' );

		return $s;
	}
}
