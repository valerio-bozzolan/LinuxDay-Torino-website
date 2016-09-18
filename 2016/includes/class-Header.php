<?php
# Linux Day 2016 - Header
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

class Header {
	function __construct($menu_uid = null, $args = [] ) {
		$menu = get_menu_entry($menu_uid);

		$args = merge_args_defaults($args, [
			'show-title'  => true,
			'nav-title'   => SITE_NAME_SHORT,
			'nav-url'     => URL,
			'head-title'  => null,
			'title'       => $menu->name,
			'url'         => $menu->url,
			'not-found'   => false,
			'user-navbar' => true,
			'container'   => true
		] );

		if( ! isset( $args['og'] ) ) {
			$args['og'] = [];
		}

		$args['og'] = merge_args_defaults($args['og'], [
			'image'  => XXX . '/ld-2016-logo.png',
			'type'   => 'website',
			'url'    => $args['url'],
			'title'  => $args['title']
		] );

		if( $args['head-title'] === null ) {
			$args['head-title'] = sprintf(
				_("%s - %s"),
				$args['title'],
				$args['nav-title']
			);
		}

		header('Content-Type: text/html; charset=' . CHARSET);

		if( $args['not-found'] ) {
			header('HTTP/1.1 404 Not Found');
		}

		enqueue_css('materialize');
		enqueue_css('materialize.icons');
		enqueue_js('jquery');
		enqueue_js('materialize');

		// Close header - Start
		$args['container'] && inject_in_module('footer', function() { ?>
		</div>
		<!-- End container -->

		<?php } );
		// Close header - End
?>
<!DOCTYPE html>
<html lang="<?php echo ISO_LANG ?>">
<head>
	<title><?php echo $args['head-title'] ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="generator" content="GNU nano" />
	<link rel="copyright" href="//creativecommons.org/licenses/by-sa/4.0/" />

	<link rel="icon" type="image/png" sizes="196x196" href="<?php echo XXX ?>/favicon/logo-192.png" />
	<link rel="icon" type="image/png" sizes="160x160" href="<?php echo XXX ?>/favicon/logo-160.png" />
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo XXX ?>/favicon/logo-96.png" />
	<link rel="icon" type="image/png" sizes="64x64" href="<?php echo XXX ?>/favicon/logo-64.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo XXX ?>/favicon/logo-32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo XXX ?>/favicon/logo-16.png" />

	<!-- Note the amount of code wasted only because they don't follow standards -->
	<link rel="apple-touch-icon" href="<?php echo XXX ?>/favicon/logo-57.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo XXX ?>/favicon/logo-114.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo XXX ?>/favicon/logo-72.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo XXX ?>/favicon/logo-144.png" />
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo XXX ?>/favicon/logo-60.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo XXX ?>/favicon/logo-120.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo XXX ?>/favicon/logo-76.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo XXX ?>/favicon/logo-152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo XXX ?>/favicon/logo-180.png">
	<meta name="msapplication-TileColor" content="#fff" />
	<meta name="msapplication-TileImage" content="<?php echo XXX ?>/favicon/logo-144.png" />
	<!-- Yes... It's a lot of code wasted... -->

<?php load_module('header') ?>

<?php foreach($args['og'] as $id=>$value): ?>
	<meta property="og:<?php echo $id ?>" content="<?php echo $value ?>" />
<?php endforeach ?>
</head>
<!--
 _____ _                     _
|_   _| |__   ___ _ __ ___  (_)___   _ __   ___
  | | | '_ \ / _ \ '__/ _ \ | / __| | '_ \ / _ \
  | | | | | |  __/ | |  __/ | \__ \ | | | | (_) |
  |_| |_| |_|\___|_|  \___| |_|___/ |_| |_|\___/

               _                   _           _      ____ _   _ _   _
 ___ _   _ ___| |_ ___ _ __ ___   | |__  _   _| |_   / ___| \ | | | | |
/ __| | | / __| __/ _ \ '_ ` _ \  | '_ \| | | | __| | |  _|  \| | | | |
\__ \ |_| \__ \ ||  __/ | | | | | | |_) | |_| | |_  | |_| | |\  | |_| |
|___/\__, |___/\__\___|_| |_| |_| |_.__/ \__,_|\__|  \____|_| \_|\___( )
     |___/                                                           |/
                 _   _     _                    _
  __ _ _ __   __| | | |   (_)_ __  _   ___  __ (_)___    ___  _ __   ___
 / _` | '_ \ / _` | | |   | | '_ \| | | \ \/ / | / __|  / _ \| '_ \ / _ \
| (_| | | | | (_| | | |___| | | | | |_| |>  <  | \__ \ | (_) | | | |  __/
 \__,_|_| |_|\__,_| |_____|_|_| |_|\__,_/_/\_\ |_|___/  \___/|_| |_|\___|

        __   _ _         _                        _
  ___  / _| (_) |_ ___  | | _____ _ __ _ __   ___| |___
 / _ \| |_  | | __/ __| | |/ / _ \ '__| '_ \ / _ \ / __|
| (_) |  _| | | |_\__ \ |   <  __/ |  | | | |  __/ \__ \_
 \___/|_|   |_|\__|___/ |_|\_\___|_|  |_| |_|\___|_|___(_)

<3
<?php _e('https://it.wikipedia.org/wiki/GNU') ?>

<3
<?php _e('https://it.wikipedia.org/wiki/Linux_(kernel)') ?>

-->
<body>
	<nav>
		<div class="nav-wrapper teal">
			<a class="brand-logo" href="<?php echo $args['nav-url'] ?>" title="<?php _esc_attr(SITE_DESCRIPTION) ?>">
				<?php echo $args['nav-title'] ?>
			</a>
			<a href="#" data-activates="slide-out" class="button-collapse"><?php echo icon('menu') ?></a>
			<?php print_menu('root', 0, ['main-ul-intag' => 'class="right hide-on-med-and-down"']) ?>

		</div>
		<?php print_menu('root', 0, [
			'main-ul-intag' => 'id="slide-out" class="side-nav"',
			'collapse' => true
		] ) ?>

	</nav>
	<div class="parallax-container" style="height:200px">
		<div class="parallax"><img src="<?php echo XXX ?>/this-is-Wikipedia.jpg" alt="<?php _e("This is Wikipedia") ?>"></div>
	</div>

	<?php if( $args['show-title'] ): ?>
	<header class="container">
		<?php if( isset( $args['url'] ) ): ?>

		<h1><a href="<?php echo $args['url'] ?>"><?php echo $args['title'] ?></a></h1>
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
