<?php
# Linux Day Torino Website
# Copyright (C) 2016-2023 Valerio Bozzolan, Linux Day Torino website contributors
# Copyright (C) 2023      Rosario Antoci, Linux Day Torino website contributors
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

/**
 * This file is the page about the location of the conpherence.
 */

// Load the framework and configs from the parent directory.
require '../load.php';

// Embed the HTML header.
template( 'header' );
?>
	<div class="inner">
		<header>
			<h1><?= __( "Come Arrivare" ) ?></h1>
		</header>
		<section>
			<h2><?= __( "Dipartimento di Informatica") ?></h2>
			<p><?= sprintf(
				__( "Puoi prendere il tram n°9 e n°3, scendendo alla fermata %s" ),
				__( "Ospedale Amedeo di Savoia / Dipartimento di Informatica.")
			) ?></p>
			<p><?= sprintf(
				__( "Dalla fermata della metropolitana %s puoi prendere il pullman n°%s scendendo alla fermata %s." ),
				__( "XVIII Dicembre" ),
					"59",
				__( "Svizzera" )
			) ?></p>
			<p><?= __( "Via Pessinetto 12, Torino" ) ?></p>
		</section>
	</div>

<?php
// End body of the page.

// Embed the HTML footer.
template( 'footer' );
