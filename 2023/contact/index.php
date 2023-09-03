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
 * This is the contact page of the conpherence.
 */

// Load the framework and configs from the parent directory.
require '../load.php';

// Embed the HTML header.
template( 'header' );

// Start body of the page.
?>

	<div class="inner">
		<header>
			<h1>Contatti del Linux Day Torino 2023</h1>
			<p>Restiamo in contatto! Trova qui le informazioni per contattarci e partecipare all'evento.</p>
		</header>
		<section>
			<h2>📧 Email</h2>
			<p>Hai domande o vuoi saperne di più? Scrivici all'indirizzo <a href="mailto:<?= esc_attr( CONTACT_EMAIL ) ?>"><?= CONTACT_EMAIL ?></a>.</p>
		</section>
		<section>
			<h2>📬 Mailing List</h2>
			<p>Iscriviti alla nostra Mailing List per ricevere aggiornamenti e notizie sull'evento: <a href="https://lists.linux.it/listinfo/ldto">https://lists.linux.it/listinfo/ldto</a>.</p>
		</section>
		<section>
			<h2>🌐 Social Media</h2>
			<p>Seguici sui social media per rimanere aggiornato sulle ultime novità:</p>
			<ul>
				<li><a href="https://www.facebook.com/LinuxDayTorino">Facebook</a></li>
				<li><a href="https://twitter.com/linuxdaytorino">Twitter</a></li>
			</ul>
		</section>
	</div>

<?php
// End body of the page.

// Embed the HTML footer.
template( 'footer' );

