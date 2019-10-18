<?php
# Linux Day website - common functions
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

function license($code) {
	return Licenses::instance()->get($code);
}

function request_uri() {
	return URL_protocol() . URL_domain() . ROOT . $_SERVER['REQUEST_URI'];
}

/**
 * Generate a stupid MySQL COALESCE() clause to select the most appropriate i18n database column
 *
 * @param  string $name Base virtual name of the column
 * @param  mixed  $i18n Associative array of languages and column names, or a generic column name like 'column_%s', or nothing to be the "$name_%s"
 * @return string
 */
function i18n_coalesce( $name, $i18n = null ) {

	// current language (e.g. 'en')
	$lang = latest_language()->getISO();

	// TODO: add database fields for Piemontese
	if( $lang === 'pms' ) {
		$lang = 'it';
	}

	// default language of the website
	$default = 'it';

	if( !$i18n ) {
		$i18n = $name . '_%s';
	}

	// allow a generic string
	if( is_string( $i18n ) ) {
		$generic = $i18n;
		$i18n = [];
		$i18n[ $lang    ] = sprintf( $generic, $lang    );
		$i18n[ $default ] = sprintf( $generic, $default );
	}

	// base priority column name
	$base_priority = $i18n[ $default ];

	// try to catch the more specific column, then the default
	if( $lang !== $default && isset( $i18n[ $lang ] ) ) {
		$more_priority = $i18n[ $lang ];
		return "COALESCE( `$more_priority`, `$base_priority` ) AS $name";
	}

	// just pick the default
	return "`$base_priority` AS $name";
}

/**
 * Eventually redirect the request to this permalink
 *
 * It's allowed the 'lang' parameter to be present or not.
 *
 * @param  string $permalink URL of the incoming request (absolute or relative)
 * @return string
 */
function force_permalink( $permalink ) {

	// incoming URL
	$from = BASE_URL . $_SERVER['REQUEST_URI'];

	// force absolute
	$permalink = site_page( $permalink, true );

	// if it's the same request, do nothing
	if( $from === $permalink ) {
		return;
	}

	// do not send a 301 Moved Permanently if the language was missing (maybe the user was just redirected to his language)
	$status = isset( $_GET['l'] )
		? 301  // 301 Moved Permanently
		: 303; // 303 See Other

	// redirect to the correct location
	http_redirect( $permalink, $status );
}

/**
 * Force an URL to have the language argument it it requested the page with it
 *
 * @return string
 */
function keep_url_in_language( $url ) {
	// force an absolute URL
	$url = site_page( $url, true );

	// current language ISO code
	$lang = latest_language()->getISO();

	// force this argument
	return replace_url_args( $url, [
		'l' => $lang,
	] );
}

/**
 * Override parameters in GET query string
 *
 * @param  string $url        The entire URL (no relative URLs they confuse parse_url)
 * @param   array $parameters Associative array, with key = paramter, value = value or null to remove it
 * @return string the new query part of the URL with "?" already placed in front, or an empty string
 * @author Ludovico Pavesi
 * @since  2019-09-30
 */
function replace_url_args( $url, $parameters ) {
	$parsed = parse_url( $url );
	if( isset( $parsed['query'] ) ) {
		parse_str( $parsed['query'], $query );
	} else {
		$query = [];
	}
	foreach( $parameters as $k => $v ) {
		if( $v === null ) {
			unset( $query[ $k ] );
		} else {
			$query[ $k ] = $v;
		}
	}
	return http_build_get_query( $url, $parameters );
}
