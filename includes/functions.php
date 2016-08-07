<?php
# Linux Day 2016 - Lazy functions
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

function datetime2php(& $s) {
	$s = DateTime::createFromFormat('Y-m-d H:i:s', $s);
	$s->setTimezone( new DateTimeZone( DB_TIMEZONE ) );
}

function the_header( $uid, $args = [] ) {
	new Header($uid, $args);
}

function the_footer( $args = [] ) {
	new Footer($args);
}

function get_iso_lang() {
	$l = [
		'en_US.UTF-8' => 'en'
	];
	if( isset( $l[ LANGUAGE_APPLIED ] ) ) {
		return $l[ LANGUAGE_APPLIED ];
	}
	return 'it';
}

/**
 * A recursive function to generate a menu tree.
 *
 * @param string $uid The menu identifier
 * @param int $level Level of the menu, used internally. Default 0.
 * @param array $args Arguments
 */
function print_menu($uid = null, $level = 0, $args = [] ) {

	$args = merge_args_defaults( $args, [
		'max-level' => 99,
		'main-ul-intag' => 'class="collection"'
	] );

	if( $level > $args['max-level'] ) {
		return;
	}

	$menuEntries = get_children_menu_entries($uid);

	if( ! $menuEntries ) {
		return;
	}
	?>

	<ul<?php if($level === 0): echo HTML::spaced( $args['main-ul-intag'] ); endif ?>>
	<?php foreach($menuEntries as $menuEntry): ?>

		<li>
			<?php echo HTML::a($menuEntry->url, $menuEntry->name, $menuEntry->get('title')) ?>
<?php print_menu( $menuEntry->uid, $level + 1, $args ) ?>

		</li>
	<?php endforeach ?>

	</ul>
	<?php
}

function icon($icon = 'send') {
	return '<i class="material-icons">' . $icon . '</i>';
}

function license($code) {
	expect('LICENSES');

	return $GLOBALS['LICENSES']->get($code);
}
