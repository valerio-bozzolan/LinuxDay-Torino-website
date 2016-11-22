<?php
# Linux Day 2016 - Licenses
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

class Licenses {
	private $licenses;

	function __construct() {
		$this->add('gnu-gpl',         "GNU GPL",           "GNU General Public License",              'https://www.gnu.org/licenses/gpl-3.0.html');
		$this->add('gnu-gpl-v3',      "GNU GPL v3",      _("GNU General Public License, versione 3"), 'https://www.gnu.org/licenses/gpl-3.0.html');
		$this->add('gnu-gpl-v2',      "GNU GPL v2",      _("GNU General Public License, versione 2"), 'https://www.gnu.org/licenses/gpl-2.0.html');
		$this->add('gnu-agpl',        "GNU AGPL",          "GNU Affero General Public License",       'https://www.gnu.org/licenses/agpl-3.0.html');
		$this->add('apache',          "Apache 2.0",      _("Licenza Apache, versione 2.0"),           'https://www.apache.org/licenses/LICENSE-2.0.html');
		$this->add('mit',             "MIT",             _("Licenza MIT"),                            'https://opensource.org/licenses/MIT');
		$this->add('php',             "PHP",             _("Licenza PHP"),                            'http://www.php.net/license/3_01.txt');
		$this->add('odbl',            "ODbl",              "Open Data Commons Open Database License", 'http://opendatacommons.org/licenses/odbl/');
		$this->add('cc-by',           "CC By 4.0",       _("Creative Commons - Attribuzione 4.0 Internazionale"), _('https://creativecommons.org/licenses/by/4.0/deed.it') );
		$this->add('cc-by-sa-3.0',    "CC By-Sa 3.0",    _("Creative Commons - Attribuzione - Condividi allo stesso modo 3.0 Unported"), _('https://creativecommons.org/licenses/by-sa/3.0/deed.it') );
		$this->add('cc-by-sa-4.0',    "CC By-Sa 4.0",    _("Creative Commons - Attribuzione - Condividi allo stesso modo 4.0 Internazionale"), _('https://creativecommons.org/licenses/by-sa/4.0/deed.it') );
		$this->add('cc-by-nc-sa-4.0', "CC By-Nc-Sa 4.0", _("Creative Commons - Attribuzione - Non commerciale - Condividi allo stesso modo 4.0 Internazionale"), _('https://creativecommons.org/licenses/by-nc-sa/4.0/deed.it') );
		$this->add('jquery',          "jQuery",          _("Licenza jQuery"),                         'https://github.com/jquery/jquery/blob/master/LICENSE.txt');
		$this->add('bsd-2',           "BSD-2",             "BSD-2",                                   'https://www.gnu.org/licenses/license-list.html#FreeBSD');
		$this->add('aal',             "AAL",               "Attribution Assurance License",           'https://opensource.org/licenses/AAL');
		$this->add('wtfpl',           "WTFPL",           _("Fai cosa c**** ti pare Public License"), _('https://it.wikipedia.org/wiki/WTFPL') );
	}

	function add($code, $short, $name, $url) {
		$this->licenses[$code] = new License($short, $name, $url);
		return $this;
	}

	function get($code) {
		return $this->licenses[$code];
	}
}

class License {
	public $short;
	public $name;
	public $url;

	function __construct($short, $name, $url) {
		$this->short = $short;
		$this->name  = $name;
		$this->url   = $url;
	}

	function getShort() {
		return $this->short;
	}

	function getName() {
		return $this->name;
	}

	function getURL() {
		return $this->url;
	}

	function getLink($classes = null, $other = null) {
		if(null === $other) {
			$other = 'target="_blank"';
		}

		return HTML::a(
			$this->getURL(),
			$this->getShort(),
			$this->getName(),
			$classes,
			$other
		);
	}
}
