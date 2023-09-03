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
 * This file is the program of the conpherence.
 */

// Load the framework and configs from the parent directory.
require '../load.php';

// Embed the HTML header.
template( 'header' );

// Start body of the page.
?>
	<div class="inner">
		<header>
			<h1><?= __( "Programma del Linux Day Torino 2023") ?></h1>
			<p><?= __( "Partecipa ai talk e alle sessioni interessanti per arricchire la tua conoscenza di Linux e dell'Open Source." ) ?></p>
		</header>
		<section>
			<h2>🎉 Entra a far parte dell'Entusiasmante Linux Day Torino 2023 come Relatore! 🎉</h2>
			<p><?= __( "Ti appassiona il mondo Linux? Hai conoscenze da condividere, esperienze da raccontare o progetti entusiasmanti legati all'open source? Allora questa è l'opportunità che stavi aspettando! Il Linux Day Torino sta cercando relatori appassionati e competenti per arricchire la sua edizione 2023." ) ?></p>
		</section>
		<section>
			<h2>📅 Data dell'Evento: 28 ottobre 2023</h2>
			<p>Save the date! Il Linux Day Torino si terrà il 28 ottobre 2023 dalle 14:00 alle 18:00.</p>
			<p><?= sprintf(
				__( "Le sessioni si svolgeranno in contemporanea, offrendo un totale di %d talk emozionanti!" ),
				16
			) ?></p>
		</section>
		<section>
			<h2>🗣️ Categorie di Talk e Relatori</h2>
			<p><?= __( "I talk saranno suddivisi nelle seguenti categorie, con relatori esperti e appassionati:" ) ?></p>
			<ul>
				<li><strong>BASE:</strong> Introduzione a Linux, concetti fondamentali e novità.</li>
				<li><strong>DEV:</strong> Sviluppo di software open source, linguaggi di programmazione, progetti e tool.</li>
				<li><strong>SYS:</strong> Amministrazione di sistema, trucchi e suggerimenti, best practices.</li>
				<li><strong>MISC:</strong> Argomenti vari legati a Linux, open source e tecnologia.</li>
			</ul>
		</section>
		<section>
			<h2>📌 Scadenza Candidature: 24 settembre 2023</h2>
			<p>Non perdere l'opportunità di condividere la tua voce con la community di appassionati di Linux. Invia la tua proposta entro il 24 settembre 2023. Le candidature saranno valutate attentamente dal nostro comitato organizzativo. Invia la tua candidatura all'indirizzo <a href="mailto:info@ldto.it">info@ldto.it</p>
		</section>
	</div>

<?php
// End body of the page.

// Embed the HTML footer.
template( 'footer' );
