<?php
# Linux Day 2016 - Header
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Linux Day Torino
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

class Header {
	static function spawn($menu_uid = null, $args = [] ) {
		$menu = menu_entry($menu_uid);

		$args = array_replace( [
			'show-title'  => true,
			'nav'         => true,
			'nav-title'   => SITE_NAME_SHORT,
			'head-title'  => null,
			'title'       => $menu->name,
			'url'         => $menu->url,
			'not-found'   => false,
			'user-navbar' => true,
			'container'   => true,
			'alert'       => null,
			'alert.type'  => null,
			'noindex'     => NOINDEX
		], $args );

		if( ! isset( $args['og'] ) ) {
			$args['og'] = [];
		}

		$args['og'] = array_replace( [
			'image'  => STATIC_URL . '/ld-2017-logo-470.png', // It's better an absolute URL here
			'type'   => 'website',
			'url'    => $args['url'],
			'title'  => $args['title']
		], $args['og'] );

		if( $args['head-title'] === null ) {
			$args['head-title'] = sprintf(
				__("%s - %s"),
				$args['title'],
				$args['nav-title']
			);
		}

		header('Content-Type: text/html; charset=' . CHARSET);

		if( $args['not-found'] ) {
			header('HTTP/1.1 404 Not Found');
		}

		enqueue_css('materialize');
		enqueue_css('materialize.custom');
		enqueue_css('materialize.icons');
		enqueue_js('jquery');
		enqueue_js('materialize');

		// Close header - Start
		$args['container'] && inject_in_module('footer', function() { ?>
		</div>
		<!-- End container -->

		<?php } );
		// Close header - End

		$l = latest_language();

		if($l) {
			$l = $l->getISO();
		} else {
			$l = 'it';
		}
?>
<!DOCTYPE html>
<html lang="<?php echo $l ?>">
<head>
	<title><?php echo $args['head-title'] ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="generator" content="GNU nano" />
	<link rel="license" href="//creativecommons.org/licenses/by-sa/4.0/" />
<?php load_module('header') ?>

<?php foreach($args['og'] as $id=>$value): ?>
	<meta property="og:<?php echo $id ?>" content="<?php echo $value ?>" />
<?php endforeach ?>
<?php if( $args['noindex'] ): ?>
	<meta name="robots" content="noindex" />
<?php endif ?>
</head>
<!--
__        _______
\ \      / / ____|
 \ \ /\ / /|  _|
  \ V  V / | |___
   \_/\_/  |_____|

 ____   ___  _   _ _ _____   _   _ ____  _____
|  _ \ / _ \| \ | ( )_   _| | | | / ___|| ____|
| | | | | | |  \| |/  | |   | | | \___ \|  _|
| |_| | |_| | |\  |   | |   | |_| |___) | |___
|____/ \___/|_| \_|   |_|    \___/|____/|_____|

  ____  ___   ___   ____ _     _____
 / ___|/ _ \ / _ \ / ___| |   | ____|
| |  _| | | | | | | |  _| |   |  _|
| |_| | |_| | |_| | |_| | |___| |___
 \____|\___/ \___/ \____|_____|_____|
    _    _   _    _    _  __   _______ ___ ____ ____
   / \  | \ | |  / \  | | \ \ / /_   _|_ _/ ___/ ___|
  / _ \ |  \| | / _ \ | |  \ V /  | |  | | |   \___ \
 / ___ \| |\  |/ ___ \| |___| |   | |  | | |___ ___) |
/_/   \_\_| \_/_/   \_\_____|_|   |_| |___\____|____/

(Try Piwik instead and anyway do not insert any tracking system if the user is in DNT mode!)

-->
<body>
	<?php if( $args['nav'] ): ?>
	<nav>
		<div class="nav-wrapper green darken-4">
			<a class="brand-logo" href="<?php echo URL . _ ?>" title="<?php _esc_attr(SITE_NAME) ?>">
				<!--
				<img src="<?php echo STATIC_PATH ?>/ld-2017-logo-470.png" alt="<?php _esc_attr(SITE_DESCRIPTION) ?>" />
				-->
				LDTO17
			</a>
			<a href="#" data-activates="slide-out" class="button-collapse"><?php echo icon('menu') ?></a>
			<?php print_menu('root', 0, ['main-ul-intag' => 'class="right hide-on-med-and-down"']) ?>

		</div>
		<?php print_menu('root', 0, [
			'main-ul-intag' => 'id="slide-out" class="side-nav"',
			'collapse' => true
		] ) ?>

	</nav>
	<?php endif ?>

	<?php if( $args['alert'] ) {
		new Messagebox( $args['alert'], $args['alert.type'] );
	} ?>

	<?php if( $args['show-title'] ): ?>
	<header class="container">
		<?php if( isset( $args['url'] ) ): ?>

		<h1><?php echo HTML::a($args['url'], $args['title'], null, TEXT) ?></h1>
		<?php else: ?>

		<h1><?php echo $args['title'] ?></h1>
		<?php endif ?>
	</header>
	<?php endif ?>

	<?php if( $args['container'] ): ?>
	<!-- Start container -->
	<div class="container">

	<?php endif ?>

<?php	}
}
