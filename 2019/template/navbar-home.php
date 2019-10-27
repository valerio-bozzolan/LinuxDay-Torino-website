<?php
# Linux Day Torino website
# Copyright (C) 2019 Ludovico Pavesi, Valerio Bozzolan and contributors
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.

/*
 * This is the navbar of the website
 */

/*
 * Args that should be passed:
 *
 * $conference (object) Current conference
 */

// do not visit directly
defined( 'ABSPATH' ) or exit;

$home = keep_url_in_language( CURRENT_CONFERENCE_ROOT . _ );

// get the current URL but without the query string (without the language)
$current_url = $_SERVER['REQUEST_URI'];
$current_url = strtok( $current_url, '?' );

$classes = $top_nav_collapse ? 'top-nav-collapse' : 'navbar-fixed-top';
?>
<!-- =========================
     NAVIGATION LINKS
============================== -->
<div class="navbar custom-navbar <?= $classes ?>" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
			</button>
			<a href="<?= $home ?>#" class="navbar-brand"><?= esc_html( $conference->getConferenceTitle() ) ?></a>
		</div>

		<div class="collapse navbar-collapse">

			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?= $home ?>#intro" class="smoothScroll"><?= __( "Intro" ) ?></a></li>
				<li><a href="<?= $home ?>#photos" class="smoothScroll"><?= __( "Foto" ) ?></a></li>
				<li><a href="<?= $home ?>#program" class="smoothScroll"><?= __( "Programma" ) ?></a></li>
				<li><a href="<?= $home ?>#venue" class="smoothScroll"><?= __( "Dove" ) ?></a></li>
				<li><a href="<?= $home ?>#contact" class="smoothScroll"><?= __( "Contatti" ) ?></a></li>

				<?php foreach( all_languages() as $lang ): ?>
					<?php if( $lang !== latest_language() ): ?>
						<li><a hreflang="<?= $lang->getISO() ?>" href="<?=
							// set the URL to this page, but with this language
							esc_attr( http_build_get_query( $current_url, [
								'l' => $lang->getISO(),
							] ) )
						?>"><?= icon( 'language' ) . ' ' . $lang->getHuman() ?></a></li>
					<?php endif ?>
				<?php endforeach ?>
			</ul>

		</div>
	</div>
</div>
