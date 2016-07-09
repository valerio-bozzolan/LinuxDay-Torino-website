<?php
# Linux Day 2016 - Homepage
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

require 'load.php';

the_header('home');
?>
	<div class="section">
		<div class="row">
			<p class="flow-text"><?php _e(
				"Il Linux Day è la principale manifestazione italiana di promozione di tecnologia sostenibile. ".
				"Quest'anno a Torino si terrà nel <strong>Dipartimento di Informatica</strong> dell'Università degli studi di Torino, ".
				"di <strong>sabato</strong>, il 22 ottobre 2016."
			) ?></p>
			<div class="col s12 m8">
				<blockquote class="flow-text">
					// How to write good code<br />
					<?php _e('<strong>$software</strong>: function(<span class="yellow">play</span>, <span class="blue lighten-3">freedom</span>, <span class="orange">friends</span>) { }' ) ?>
				</blockquote>
			</div>
			<div class="col s12 m4">
				<p class="flow-text"><?php _e(
					"Il tema di quest'anno a livello nazionale è... il <code>coding</code>!"
				) ?></p>
			</div>
		</div>
	</div>

	<div id="where" class="divider"></div>
	<div class="section">
		<h3><?php _e("Come arrivare") ?></h3>
		<div class="row">
			<div class="col s12 m4">
				<p class="flow-text"><?php _e("Via Pessinetto 12, Torino.") ?></p>
				<p><?php _e(
					"Puoi prendere il tram n°<strong>9</strong> e n°<strong>13</strong>, ".
					"scendendo alla fermata <em>Ospedale Amedeo di Savoia / Dipartimento di Informatica</em>."
				) ?></p>
			</div>
			<div class="col s12 m8">
				<div class="card hoverable">
					<div class="card-image">
						<img src="<?php echo XXX ?>/openstreetmap-unito.svg" alt="<?php _e("Dipartimento di Informatica su OpenStreetMap") ?>">
				        </div>
					<div class="card-content">
						<p></p>
					</div>
					<div class="card-action">
						<a class="btn" href="http://www.openstreetmap.org/?mlat=45.08997&mlon=7.65917#map=17/45.08997/7.65917" title="<?php _e("Dipartimento di Informatica su OpenStreetMap") ?>">
							<?php _e("Vedi su OpenStreetMap") ?>

						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="talk" class="divider"></div>
	<div class="section">
		<h3><?php _e("Talk") ?></h3>
		<p class="flow-text"><?php printf(
			_(
				"Un ampio programma fatto di %s talk di un'ora ciascuno, ".
				"affrontando tematiche riguardanti il software libero su più livelli, ".
				"per soddisfare le esigenze di un ampio pubblico (dai più piccoli, al curioso, fino agli esperti)."
			),
			"<b>16</b>"
		) ?></p>
		<p><?php _e("In seguito si riporta la tabella dei talk suddivisa in quattro categorie:") ?></p>
		<table class="bordered striped hoverable">
			<tr>
				<th></th>

				<th><?php _e("Area Base") ?></th>
				<th><?php _e("Area Dev") ?></th>
				<th><?php _e("Area Sysadmin") ?></th>
				<th><?php _e("Area Misc") ?></th>
			</tr>
			<tr class="hoverable">
				<th><?php
					$ora = function($d) {
						printf(
							_("%d° ora"),
							$d
						);
					};
					$ora(1);
				?></th>

				<?php $dev = function($name, $desc) { ?>
				<td><?php echo $name ?><br /><p><?php echo $desc ?></p></td>

				<?php };
				$dev("Dario Sera",      _("Coding come strumento didattico") );
				$dev("Luigi Maselli",   _("JavaScript") );
				$dev("Massimo Nuvoli",  _("IPV6") );
				$dev("Francesco Tucci", _("Progetto con Arduino") );
				?>

			</tr>
			<tr class="hoverable">
				<th><?php $ora(2) ?></th>

				<?php
				$dev("Flavio Piovesan", _("Il software libero nella PA") );
				$dev("?", _("?") );
				$dev("?", _("?") );
				$dev("?", _("?") );
				?>

			</tr>
			<tr class="hoverable">
				<th><?php $ora(3) ?></th>

				<?php
				$dev("Valerio Bozzolan", _("Introduzione a GNU/Linux") );
				$dev("?", _("?") );
				$dev("?", _("?") );
				$dev("Marco Signoretto", _("WEEE Open - Sostenibilità & Open source") );
				?>

			</tr>
			<tr class="hoverable">
				<th><?php $ora(4) ?></th>

				<?php
				$dev("Manca Renzo Davoli", _("Make FLOSS Sexy") );
				$dev("Mancano Dev", _("?") );
				$dev("Sistemisti!!!", _("?") );
				$dev("Davide Mainardi", _("Security") );
				?>

			</tr>
		</table>
		<p><?php _e("La tabella potrebbe subire variazioni.") ?></p>
	</div>

	<div id="play" class="divider"></div>
	<div class="section">
		<h3><?php _e("Attività") ?></h3>
		<p class="flow-text"><?php _e("In contemporanea ai talk avranno luogo diverse attività:") ?></p>
		<div class="row">
			<?php $box = function($what, $who, $url = null, $prep = null) {
				$who = HTML::a($url, $who, null); ?>

			<div class="col s12 m6 l3">
				<div class="card-panel hoverable">
					<p><?php echo $what ?><br /> <?php printf( _("Gestito %s %s."), _("da"), $who ) ?></p>
				</div>
			</div>

			<?php };

			$box(
				_("Assistenza tecnica software libero (LIP - Linux Installation Party) (Installazione distribuzioni GNU/Linux e helpdesk)"),
				_("Officina Informatica Libera"),
				'http://informaticalibera.info'
			);
			$box(
				_("Riparazione di apparecchiature elettroniche"),
				_("Associazione Tesso"),
				'http://www.associazionetesso.org'
			);
			$box(
				_("Laboratorio di coding per i più piccoli a tema Linux Day"),
				_("CoderDojo Torino"),
				'https://coderdojo.com'
			);
			$box(
				_("Allestimento museale di Retrocomputing"),
				"MUPIN",
				'http://mupin.it'
			); ?>

		</div>
	</div>
<?php
the_footer();
