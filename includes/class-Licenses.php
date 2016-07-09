<?php
# Copyright (C) 2016 Valerio Bozzolan
#
# Linux Day 2016 - Licenses
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

class Licenses {
	private $licenses;

	function __construct() {
		$this->add('gnu-gpl',    "GNU GPL",      "GNU General Public License",              'https://www.gnu.org/licenses/gpl-3.0.html')
		     ->add('gnu-gpl-v2', "GNU GPL v2", _("GNU General Public License, version 2"),  'https://www.gnu.org/licenses/gpl-2.0.html')
		     ->add('gnu-agpl',   "GNU AGPL",     "GNU Affero General Public License",       'https://www.gnu.org/licenses/agpl-3.0.html')
		     ->add('apache',     "Apache 2.0", _("Apache License, Version 2.0"),            'https://www.apache.org/licenses/LICENSE-2.0.html')
		     ->add('mit',        "MIT",        _("MIT License"),                            'https://opensource.org/licenses/MIT')
		     ->add('php',        "PHP",        _("PHP License"),                            'http://www.php.net/license/3_01.txt')
		     ->add('odbl',       "ODbl",         "Open Data Commons Open Database License", 'http://opendatacommons.org/licenses/odbl/')
		     ->add('cc-by',      "CC By 4.0",  _("Creative Commons - Attribuzione 4.0 Internazionale"), _('https://creativecommons.org/licenses/by/4.0/deed.it') );
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
}
