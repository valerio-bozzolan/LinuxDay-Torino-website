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
			'title'       => $menu->name,
			'url'         => $menu->url,
			'og'          => [],
			'not-found'   => false,
			'user-navbar' => true,
			'container'   => true
		] );

		header('Content-Type: text/html; charset=' . CHARSET);

		if( $args['not-found'] ) {
			header('HTTP/1.1 404 Not Found');
		}

		enqueue_css('materialize');
		enqueue_css('materialize.icons');
		enqueue_js('jquery');
		enqueue_js('materialize');

		// Close header
		$args['container'] && inject_in_module('footer', function() {
			echo "\t</div>";
		} );
?>
<!DOCTYPE html>
<html lang="<?php echo ISO_LANG ?>">
<head>
	<title><?php echo "{$args['title']} - " . SITE_NAME ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="generator" content="Boz-PHP - Another PHP Framework" />
	<link rel="copyright" href="//creativecommons.org/licenses/by-sa/4.0/" /><?php load_module('header') ?>

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
		<div class="nav-wrapper blue darken-1">
			<a class="brand-logo" href="<?php echo URL ?>" title="<?php _esc_attr(SITE_DESCRIPTION) ?>">
				<?php echo $h1 = strtoupper( SITE_NAME ) ?>

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
	<header>
		<div class="center">
			<h1><?php echo $h1 ?></h1>
			<p><?php echo str_replace(
				['/', 'GNU', 'Linux'], [
					'<b>/</b>',
					HTML::a(
						_('https://it.wikipedia.org/wiki/GNU'),
						'GNU'
					),
					HTML::a(
						_('https://it.wikipedia.org/wiki/Linux_%28kernel%29'),
						'Linux'
					)
				],
				SITE_DESCRIPTION
			) ?></p>
		</div>
		<div class="container">
			<?php if( isset( $args['url'] ) ): ?>

			<h2><a href="<?php echo $args['url'] ?>"><?php echo $args['title'] ?></a></h2>
			<?php else: ?>

			<h2><?php echo $args['title'] ?></h2>
			<?php endif ?>

		</div>
	</header>
	<?php if( $args['container'] ): ?><div class="container"><?php endif ?>

<?php	}
}
