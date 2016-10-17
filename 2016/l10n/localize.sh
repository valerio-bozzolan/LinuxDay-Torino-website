#!/bin/sh
#############################################################################
#
# Copyright (C) 2016  Valerio Bozzolan
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

# The copyright older of your localization
copyright="Linux Day 2016 website contributors"

# The prefix of your localization's files
# You have to know how GNU Gettext works to change it.
package="linuxday"

rtfm() {
	echo Usage:
	echo $1 SITE_ROOT
	echo Example:
	echo $1 ./2016
}

path="$1"

if [ -z "$path" ]; then
	rtfm $0
	exit 1
fi

# Generate/update the .pot file from the single script (index.php)
xgettext \
	--copyright-holder="$copyright" \
	--package-name=$package \
	--from-code=UTF-8 \
	--keyword=_e \
	--default-domain=$package \
	-o "$path"/l10n/$package.pot \
	"$path"/*.php \
	"$path"/*/*.php

#!/bin/bash

package="linuxday"
path="./2016"

# Find all useless comments (= line numbers in trebbia.php)
replace=($(grep -oE '[0-9]{4}/l10n/trebbia.php:[0-9]+' "$path"/l10n/$package.pot | sort -h -t: -k2))

comments=()
paths=()
linenumbers=()

for comment in "${replace[@]}"
do
	comments+=($comment)
	tmp=(${comment//:/ })
	paths+=(${tmp[0]})
	# don't ask why. Or do ask, but I don't know the answer.
	tmpn=${tmp[1]}
	tmpn2=$(($tmpn-1))
	linenumbers+=($tmpn2)
done

# The whole point of sorting was to read sequentially every line in trebbia.php and keep only the right ones, but the task proved too difficult.
# So here we go: a O(n^2) algorithm, or possibly worse! Yay!

i=0
for comment in $comments
do
	# Get string description from trebbia.php, remove "//" from beginning
	description=$(sed -n ${linenumbers[$i]}p "$path"/../${paths[$i]} | cut -c 4-)
	# aaaaand... this doesn't work.
	sed -i 's#"'${comment}'"#"'$description'"#g' "$path"/l10n/$package.pot
	((i+=1))
done


# Generate/update the .po files from the .pot file
find "$path"/l10n -name \*.po -execdir msgmerge -o $package.po $package.po ../../$package.pot \;

# Generate/update the .mo files from .po files
find "$path"/l10n -name \*.po -execdir msgfmt -o $package.mo $package.po \;
