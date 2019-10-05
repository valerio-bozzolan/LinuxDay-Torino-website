<?php
# Linux Day Torino website - Licenses
# Copyright (C) 2016, 2018 Valerio Bozzolan
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

/**
 * Collector of some known licenses
 */
class Licenses {

	/**
	 * All the registered licenses indexed by code
	 *
	 * @var array
	 */
	private $licenses = [];

	/**
	 * Instance of this singleton
	 *
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Get the singleton instance
	 *
	 * @return self
	 */
	public static function instance() {
		if( !self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->add('aal',             "AAL",                "Attribution Assurance License",            'https://opensource.org/licenses/AAL');
		$this->add('apache',          "Apache 2.0",      __("Licenza Apache, versione 2.0"),            'https://www.apache.org/licenses/LICENSE-2.0.html');
		$this->add('bsd-2',           "BSD-2",              "BSD-2",                                    'https://www.gnu.org/licenses/license-list.html#FreeBSD');
		$this->add('cc-by',           "CC By 4.0",       __("Creative Commons - Attribuzione 4.0 Internazionale"),     __('https://creativecommons.org/licenses/by/4.0/deed.it') );
		$this->add('cc-by-sa-2.0',    "CC By-Sa 2.0",    __("Creative Commons - Attribuzione - Condividi allo stesso modo 2.0 Generico"), __('https://creativecommons.org/licenses/by-sa/2.0/deed.it') );
		$this->add('cc-by-sa-3.0',    "CC By-Sa 3.0",    __("Creative Commons - Attribuzione - Condividi allo stesso modo 3.0 Unported"), __('https://creativecommons.org/licenses/by-sa/3.0/deed.it') );
		$this->add('cc-by-sa-4.0',    "CC By-Sa 4.0",    __("Creative Commons - Attribuzione - Condividi allo stesso modo 4.0 Internazionale"), __('https://creativecommons.org/licenses/by-sa/4.0/deed.it') );
		$this->add('cc-by-nc-sa-4.0', "CC By-Nc-Sa 4.0", __("Creative Commons - Attribuzione - Non commerciale - Condividi allo stesso modo 4.0 Internazionale"), __('https://creativecommons.org/licenses/by-nc-sa/4.0/deed.it') );
		$this->add('gnu-fdl',         "GNU FDL",            "GNU Free Documentation License",           'https://www.gnu.org/licenses/fdl-1.3.html' );
		$this->add('gnu-gpl',         "GNU GPL",            "GNU General Public License",               'https://www.gnu.org/licenses/gpl-3.0.html' );
		$this->add('gnu-gpl-v3',      "GNU GPL v3",      __("GNU General Public License, versione 3"),  'https://www.gnu.org/licenses/gpl-3.0.html');
		$this->add('gnu-gpl-v2',      "GNU GPL v2",      __("GNU General Public License, versione 2"),  'https://www.gnu.org/licenses/gpl-2.0.html');
		$this->add('gnu-agpl',        "GNU AGPL",           "GNU Affero General Public License",        'https://www.gnu.org/licenses/agpl-3.0.html');
		$this->add('jquery',          "jQuery",          __("Licenza jQuery"),                          'https://github.com/jquery/jquery/blob/master/LICENSE.txt');
		$this->add('mit',             "MIT",             __("Licenza MIT"),                             'https://opensource.org/licenses/MIT');
		$this->add('odbl',            "ODbl",               "Open Data Commons Open Database License",  'http://opendatacommons.org/licenses/odbl/');
		$this->add('php',             "PHP",             __("Licenza PHP"),                             'http://www.php.net/license/3_01.txt');
		$this->add('wtfpl',           "WTFPL",           __("Fai cosa c**** ti pare Public License"),__('https://it.wikipedia.org/wiki/WTFPL') );
	}

	/**
	 * Register another License
	 *
	 * @param  string $code  License code
	 * @param  string $short License short name (English)
	 * @param  string $name  License long name  (internationalized)
	 * @param  string $url   License URL (internationalized)
	 * @return self
	 */
	public function add( $code, $short, $name, $url ) {
		$this->licenses[ $code ] = new License( $code, $short, $name, $url );
		return $this;
	}

	/**
	 * Get all the registered Licenses
	 *
	 * @return array
	 */
	public function all() {
		return $this->licenses;
	}

	/**
	 * Get a single License
	 *
	 * @param  string $code License code
	 * @return License
	 */
	public function get( $code ) {
		return $this->licenses[ $code ];
	}
}

class License {

	public $code;
	public $short;
	public $name;
	public $url;

	function __construct( $code, $short, $name, $url ) {
		$this->code  = $code;
		$this->short = $short;
		$this->name  = $name;
		$this->url   = $url;
	}

	/**
	 * Get the License code
	 *
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * Get the License short name
	 *
	 * @return string
	 */
	public function getShort() {
		return $this->short;
	}

	/**
	 * Get the License long name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Get the License URL
	 *
	 * @return string
	 */
	public function getURL() {
		return $this->url;
	}

	/**
	 * Get a link to this License
	 *
	 * @param  string $classes Set custom classes
	 * @param  string $other Set custom inline tags
	 * @return string
	 */
	public function getLink( $classes = null, $other = null ) {
		if( null === $other ) {
			$other = 'target="_blank"';
		}

		return HTML::a(
			$this->getURL(),
			$this->getShort(),
			esc_html( $this->getName() ),
			$classes,
			$other
		);
	}
}
