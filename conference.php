<?php
# Linux Day 2016 - Conference page
# Copyright (C) 2016 Valerio Bozzolan, Ludovico Pavesi
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

$conference = null;
if( ! empty( $_GET['uid'] ) ) {
	$conference = Conference::getConference(
		luser_input( $_GET['uid'], 64 )
	);
}

$conference
	|| die_with_404();

the_header('conference', [
	'title' => $conference->getConferenceTitle(),
	'url'   => $conference->getConferenceURL()
] );
?>
	<div class="section">
		<div class="row">
			<p class="flow-text"><?php echo $conference->getConferenceDescription() ?></p>
			<?php if( $conference->conference_quote ): ?>
			<div class="col s12 m8">
				<blockquote class="flow-text"><?php echo $conference->getConferenceQuote() ?></blockquote>
			</div>
			<?php endif ?>
			<div class="col s12 m4">
				<p class="flow-text"><?php echo $conference->getConferenceSubtitle() ?></p>
			</div>
		</div>
	</div>

	<div id="where" class="divider"></div>
	<div class="section">
		<h3><?php _e("Come arrivare") ?></h3>
		<div class="row">
			<div class="col s12 m4">
				<p class="flow-text"><?php echo $conference->getLocationName() ?></p>
				<p><?php printf(
					_("%s, %s"),
					$conference->getLocationAddress(),
					$conference->getLocationNote()
				) ?></p>
			</div>
			<div class="col s12 m8">
				<div class="card hoverable">
					<div class="card-image">
						<img src="<?php echo $conference->getLocationGeothumb() ?>" alt="<?php _esc_html( $conference->getLocationName() ) ?>">
				        </div>
					<div class="card-content">
						<p></p>
					</div>
					<div class="card-action">
						<?php echo HTML::a(
							$conference->getLocationGeoOSM(),
							_("Vedi su OpenStreetMap"),
							sprintf(
								_("Vedi %s su OpenStreetMap"),
								esc_html( $conference->getConferenceTitle() )
							),
							'btn',
							'target="_blank"'
						) ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="talk" class="divider"></div>
	<div class="section">
		<?php $eventsTable = $conference->getDailyEventsTable() ?>

		<h3><?php _e("Talk") ?></h3>
		<p class="flow-text"><?php printf(
			_(
				"Un ampio programma fatto di %s talks di un'ora ciascuno distribuiti in %s ore, ".
				"affrontando tematiche riguardanti il software libero su più livelli, ".
				"per soddisfare le esigenze di un ampio pubblico (dai più piccoli, al curioso, fino agli esperti)."
			),
			"<b>{$eventsTable->countEvents()}</b>",
			"<b>{$eventsTable->getHours()}</b>"
		) ?></p>
		<p><?php printf(
			_("In seguito si riporta la tabella dei talk suddivisa in %s categorie:"),
			"<b>{$eventsTable->countTracks()}</b>"
		) ?></p>

		<?php $eventsTable->printTable(); ?>

		<p><?php _e("La tabella potrebbe subire variazioni.") ?></p>
	</div>

	<div id="play" class="divider"></div>
	<div class="section">
		<h3><?php _e("Attività") ?></h3>
		<p class="flow-text"><?php _e("In contemporanea ai talk avranno luogo diverse attività:") ?></p>
		<div class="row">
			<?php $box = function($what, $who, $url = null, $prep = null) {
				if( $url ) {
					$who = HTML::a($url, $who, null);
				} ?>

			<div class="col s12 m6 l3">
				<div class="card-panel hoverable">
					<p><span class="flow-text"><?php echo $what ?></span><br /> <?php printf( _("Gestito %s %s."), _("da"), $who ) ?></p>
				</div>
			</div>

			<?php };

			$box(
				_("Riparazione di apparecchiature elettroniche."),
				_("Associazione Tesso"),
				'http://www.associazionetesso.org'
			);
			$box(
				_("Laboratorio di coding per i più piccoli a tema Linux Day."),
				_("CoderDojo Torino"),
				'https://coderdojo.com'
			);
			$box(
				_("Allestimento museale di Retrocomputing."),
				"MUPIN",
				'http://mupin.it'
			);
			$box(
				_("LIP (Linux Installation Party) e assistenza tecnica distribuzioni GNU/Linux."),
				_("volontari")
			);
			?>

		</div>
	</div>
<?php
the_footer();
