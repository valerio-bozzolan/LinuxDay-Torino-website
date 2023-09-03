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
 * This file contains general info about the conpherence.
 */

// Load the framework and configs from the parent directory.
require '../load.php';

// Embed the HTML header.
template( 'header' );

// Start body of the page.
?>

	<div class="inner">
		<header>
			<h1>Benvenuti all'Entusiasmante Linux Day Torino 2023!</h1>
		</header>
		<section>
			<p>Il Linux Day Torino è l'evento annuale dedicato a tutti gli appassionati, sviluppatori e professionisti del mondo Linux e dell'open source. È l'opportunità perfetta per condividere conoscenze, esperienze e progetti, e per ampliare la tua rete di contatti nel settore.</p>
			<p>Se hai una passione per Linux e desideri contribuire con il tuo know-how, ti invitiamo a partecipare come relatore nell'edizione 2023.</p>
			<p>Scopri di più sul Linux Day Torino, le categorie di talk disponibili e come candidarti nella sezione <a href="programma.html">Programma</a>.</p>
		</section>
	</div>

<?php
// End body of the page.

// Embed the HTML footer.
template( 'footer' );
