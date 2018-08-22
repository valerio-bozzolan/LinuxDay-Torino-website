#!/usr/bin/php
<?php
#############################################################################
#
# Copyright (C) 2016  Valerio Bozzolan, Ludovico Pavesi
#
# Automatize the entire GNU Gettext workflow
#
#############################################################################
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
#
#############################################################################

# The copyright holder of your localization
$copyright="Linux Day 2016 website contributors";

# The prefix of your localization files
# You have to know how GNU Gettext works to change it.
$package="linuxday";

function rtfm() {
	global $argv;
	echo 'Usage:'.PHP_EOL;
	echo $argv[0].' SITE_ROOT'.PHP_EOL;
	echo 'Example:'.PHP_EOL;
	echo $argv[0].' ./project_directory'.PHP_EOL;
}

if(!isset($argc) || $argc !== 2) {
	rtfm();
	exit(1);
}

$path = $argv[1];

$xgettext = <<<EOT
xgettext \
	--copyright-holder="$copyright" \
	--package-name=$package \
	--from-code=UTF-8 \
	--keyword=_e \
	--keyword=__ \
	--default-domain=$package \
	-o "$path"/2016/l10n/$package.pot \
	"$path"/includes/*.php \
	"$path"/2016/*.php \
	"$path"/2016/*/*.php
EOT;

exec($xgettext);

# Get the pot
$pot = file_get_contents($path."/2016/l10n/$package.pot");
$useless_comments = [];

# # Find all useless comments (= line numbers in trebbia.php)
preg_match_all('#[0-9]{4}/l10n/trebbia\.php:[0-9]+#', $pot, $useless_comments);
$useless_comments = $useless_comments[0];

# Separate line number from file name
foreach($useless_comments as $i => $comment) {
	$useless_couples[$i] = explode(':', $comment);
	$useless_couples[$i][1] = ((int) $useless_couples[$i][1])-1;
}

# Found anything?
if(isset($useless_couples)) {
	foreach($useless_couples as $i => $couple) {
		# This is O(n^2), or even worse.
		$line = exec('sed -n ' . $couple[1] . 'p '."$path/2016/../" . $couple[0] . ' | cut -c 4-');
		# Get the line, place it in the pot.
		$pot = str_replace($useless_comments[$i], $line, $pot);
	}
}

# write the pot
file_put_contents($path."/2016/l10n/$package.pot", $pot);

# Generate/update the .po files from the .pot file
exec("find \"$path\"/2016/l10n -name \\*.po -execdir msgmerge -o $package.po $package.po ../../$package.pot \\;");

# Generate/update the .mo files from .po files
exec("find \"$path\"/2016/l10n -name \\*.po -execdir msgfmt -o $package.mo $package.po \\;");
