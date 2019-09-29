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
 * This is the introduction of the website
 */

// do not visit directly
defined( 'ABSPATH' ) or exit;
?>
<!-- =========================
    INTRO SECTION
============================== -->
<section id="intro" class="parallax-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<h3><?= __( "Sabato 26 Ottobre 2019" ) ?></h3>
				<h1>Linux Day Torino</h1>
				<div class="typing-smanettone-container text-white"><?php printf(
                    __("Se anche tu sei %suno smanettone%s, vieni a trovarci!"),
                    '<span class="typing-smanettone">',
                    '</span>'
                ) ?></div>
				<a href="#detail" class="btn btn-lg btn-default smoothScroll hidden-xs"><?= esc_attr( __( "SCOPRI DI PIÙ" ) ) ?></a>
			</div>
		</div>
	</div>
</section>

<script>
$('.typing-smanettone').text('');
var typed = new Typed('.typing-smanettone', {
	strings: <?= json_encode( [
		__("uno smanettone"),
		__("un programmatore"),
		__("una persona curiosa"),
		__("in cerca di lavoro"),
		__("un sistemista"),
		__("un po' pinguino"),
		__("in modalità incognito"),
		__("un cucciolo di GNU")
	] ); ?>,
	loop: true,
	typeSpeed: 100,
	backDelay: 1000,
	backSpeed: 20,
	showCursor: false
} );
</script>
