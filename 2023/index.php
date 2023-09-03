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
 * This file is the homepage of the website.
 */

// Load the framework and configs.
require 'load.php';

// Embed the HTML header.
template( 'header' );

// Start body of the page.
?>

	<div class="inner">
		<header>
			<h1><?= __( "Entra a far parte dell'Entusiasmante Linux Day Torino 2023 come Relatore!" ) ?></h1>
			<p><?= __(
				"Ti appassiona il mondo Linux? Hai conoscenze da condividere, esperienze da raccontare o ".
				"progetti entusiasmanti legati all'Open Source? Allora questa è l'opportunità che stavi aspettando! ".
				"Il Linux Day Torino sta cercando speaker appassionati e competenti per arricchire la sua edizione 2023."
			) ?></p>
		</header>
		<section class="tiles">
			<article class="style1">
				<span class="image">
					<img src="<?= CURRENT_CONFERENCE_PATH ?>/images/pic01.jpg" alt="" />
				</span>
				<a href="#">
					<h2><?= strtoupper( __( "Base" ) ) ?></h2>
					<div class="content">
						<p><?= __( "Introduzione a Linux, concetti fondamentali e novità." ) ?></p>
					</div>
				</a>
			</article>
			<article class="style2">
				<span class="image">
					<img src="<?= CURRENT_CONFERENCE_PATH ?>/images/pic02.jpg" alt="" />
				</span>
				<a href="#">
					<h2><?= strtoupper( __( "Sys" ) ) ?></h2>
					<div class="content">
						<p><?= __( "Amministrazione di sistema, trucchi e suggerimenti, buone pratiche." ) ?></p>
					</div>
				</a>
			</article>
			<article class="style3">
				<span class="image">
					<img src="<?= CURRENT_CONFERENCE_PATH ?>/images/pic03.jpg" alt="" />
				</span>
				<a href="#">
					<h2><?= strtoupper( __( "Dev" ) ) ?></h2>
					<div class="content">
						<p><?= __( "Sviluppo di software Open Source, linguaggi di programmazione, progetti e tool." ) ?></p>
					</div>
				</a>
			</article>
			<article class="style4">
				<span class="image">
					<img src="<?= CURRENT_CONFERENCE_PATH ?>/images/pic04.jpg" alt="" />
				</span>
				<a href="#">
					<h2><?= strtoupper( __( "Misc") ) ?></h2>
					<div class="content">
						<p><?= __( "Argomenti vari legati a Linux, Open Source e tecnologia." ) ?></p>
					</div>
				</a>
			</article>
			<article class="style5">
				<span class="image">
					<img src="<?= CURRENT_CONFERENCE_PATH ?>/images/pic05.jpg" alt="" />
				</span>
				<a href="#">
					<h2 title="<?= esc_attr( __("Linux Installation Party") ) ?>"><?= __( "LIP" ) ?></h2>
					<div class="content">
						<p><?= __( "Linux Installation Party e assistenza gratuita." ) ?></p>
					</div>
				</a>
			</article>
			<article class="style6">
				<span class="image">
					<img src="<?= CURRENT_CONFERENCE_PATH ?>/images/pic06.jpg" alt="" />
				</span>
				<a href="#">
					<h2><?= __( "Restart Party" ) ?></h2>
					<div class="content">
						<p><?= __( "Riavvia, ripara e ridai vita ai tuoi dispositivi elettronici! Porta il tuo oggetto guasto e impara a ripararlo." ) ?></p>
					</div>
				</a>
			</article>
			<!-- Add more articles as needed... -->
		</section>
	</div>

<?php
// End body of the page.

// Embed the HTML footer.
template( 'footer' );
