<?php
# Linux Day 2016 - Single conference page
# Copyright (C) 2016 Valerio Bozzolan, Ludovico Pavesi, Rosario Antoci
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
	$conference = Conference::getConference( $_GET['uid'] );
}

$conference
	|| die_with_404();

FORCE_PERMALINK
	&& $conference->forceConferencePermalink();

enqueue_js('leaflet');
enqueue_js('leaflet.init');
enqueue_js('scrollfire');
enqueue_css('leaflet');
enqueue_css('home');

// Support for non-JavaScript
inject_in_module('header', function() {
	echo "\n\t<noscript><style>#map {display: none}</style></noscript>";
} );

new Header('conference', [
	'show-title' => false,
	'head-title' => $s = $conference->getConferenceTitle(),
	'title'      => $s,
	'url'        => $conference->getConferenceURL()
] );
?>
	<div class="header">
		<div class="center-align">
			<h1><?php echo HTML::a(
				$conference->getConferenceURL(),
				strtoupper( SITE_NAME ),
				null,
				TEXT
			) ?></h1>
		</div>
	</div>
	<div class="section">
		<div class="row valign-wrapper">
			<div class="col s12 m2 l1 center-align hide-on-small-only">
				<img src="<?php echo XXX ?>/linuxday-200.png" alt="<?php _e("Linux Day 2016") ?>" class="responsive-img" />
			</div>
			<div class="col s12 m10 l11">
				<p class="flow-text"><?php printf(
					_(
						"Il Linux Day è la principale manifestazione italiana di promozione di software libero e sistemi operativi %s/%s. ".
						"Quest'anno a Torino si terrà presso il <strong>%s</strong> dell'%s, di <strong>%s</strong>, il <strong>%s</strong>, ".
						"dalle <strong>%s</strong>."
					),
					HTML::a(
						_('https://it.wikipedia.org/wiki/GNU'),
						'GNU',
						null,
						'black-text hoverable'
					),
					HTML::a(
						_('https://it.wikipedia.org/wiki/Linux_%28kernel%29'),
						'Linux',
						null,
						'black-text hoverable'
					),
					_("Dipartimento di Informatica"),
					_("Università degli studi di Torino"),
					_("sabato"),
					_("22 ottobre 2016"),
					$conference->getConferenceStart("H:i"),
					$conference->getConferenceEnd("H:i")
				) ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col s12 m8">
				<blockquote class="flow-text">
					// How to write good code<br />
					<strong>$software</strong>: 
					function(<span class="yellow hoverable">play</span>, 
					<span class="teal white-text hoverable">freedom</span>, 
					<span class="purple darken-2 white-text hoverable">friends</span>) { /* RTFM */ }
				</blockquote>
			</div>
			<div class="col s12 m4">
				<p class="flow-text"><?php _e("Il tema di quest'anno a livello nazionale è... il <code>coding</code>!") ?></p>
			</div>
		</div>
	</div>
	<div id="where" class="divider" data-show="#where-section"></div>
	<div id="where-section" class="section">
		<h3><?php _e("Come arrivare") ?></h3>
		<div class="row">
			<div class="col s12 m4">
				<p class="flow-text"><?php echo $conference->getLocationName() ?></p>
				<?php $conference->printLocationNote(['p' => 'flow-text']) ?>
			</div>
			<div class="col s10 m8">
				<div class="card-panel">
					<?php $conference->printLocationLeaflet() ?>
					<noscript>
						<img class="responsive-img" src="<?php echo $conference->getLocationGeothumb() ?>" alt="<?php _esc_html( $conference->getLocationName() ) ?>">
						<p><?php _e("Abilitare JavaScript per la mappa interattiva.") ?></p>
					</noscript>
					<div class="row valign-wrapper">
						<div class="col s8">
							<p class="flow-text"><?php echo $conference->getLocationAddress() ?></p>
						</div>
						<div class="col s4">
							<p class="right"><?php echo HTML::a(
								$conference->getLocationGeoOSM(),
								icon('place', 'right'),
								sprintf(
									_("Vedi %s su OpenStreetMap"),
									esc_html( $conference->getConferenceTitle() )
								),
								'btn-floating btn-large purple darken-3 waves-effect',
								'target="_blank"'
							) ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="talk" class="divider" data-show="#talk-section"></div>
	<div class="section" id="talk-section">
		<?php $eventsTable = $conference->getDailyEventsTable('talk') ?>

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

		<div class="card-panel hide-on-large-only"><?php echo icon('smartphone', 'left'); _e("<strong>Schermo piccolo?</strong> Puoi scorrere la tabella verso destra.") ?></div>

		<p><?php _e("La tabella potrebbe subire variazioni.") ?></p>
	</div>

	<div id="activities" class="divider" data-show="#activities-section"></div>
	<div class="section" id="activities-section">
		<h3><?php _e("Attività") ?></h3>
		<p class="flow-text"><?php _e("In contemporanea ai talk avranno luogo diverse attività:") ?></p>
		<div class="row">
			<?php $box = function($what, $who, $url = null, $prep = null, $img = null, $attendize = null) {
				if( ! $prep ) {
					$prep = _("da %s");
				}
				$who_text = $who;
				if( $url ) {
					$who = HTML::a($url, $who, null, 'white-text', 'target="_blank"');
				}
				$who_prep = sprintf($prep, $who);
			?>

			<div class="col s12 m6">
				<div class="card-panel hoverable purple darken-3 white-text">
					<?php if( $img ): ?>
					<div class="row"><!-- Start image row -->
						<div class="col s4">
							<img class="responsive-img" src="<?php echo XXX . "/partner/$img" ?>" alt="<?php _esc_attr($who_text) ?>" />
						</div>
						<div class="col s8"><!-- Start text col -->
					<?php endif ?>

							<p>
								<span class="flow-text"><?php echo $what ?></span><br /> 
								<?php printf( _("Gestito %s."), $who_prep ) ?>
							</p>

							<?php if($attendize): ?>
							<p><?php echo HTML::a(
								$attendize,
								_("Prenota"),
								sprintf(
									_("Prenota la tua partecipazione a %s"),
									$what
								),
								'btn white purple-text waves-effect waves-purple hoverable',
								'target="_blank"'
							) ?></p>
							<?php endif ?>

					<?php if( $img ): ?>
						</div><!-- End text col -->
					</div><!-- End image row -->
					<?php endif ?>
				</div>
			</div>

			<?php };

			$box(
				_("Riparazione di apparecchiature elettroniche."),
				_("Associazione Restarters Torino"),
				'http://www.associazionetesso.org',
				_("dall'%s"),
				'restart-party.png'
			);
			$box(
				_("Laboratorio di coding per i più piccoli a tema Linux Day."),
				sprintf(
					_("%s e %s"),
					HTML::a(
						'http://coderdojotorino.it',
						_("CoderDojo Torino 1"),
						null,
						'white-text',
						'target="_blank"'
					),
					HTML::a(
						'http://www.coderdojotorino2.it',
						_("CoderDojo Torino 2"),
						null,
						'white-text',
						'target="_blank"'
					)
				),
				null,
				null,
				'coderdojo.png',
				'https://attendize.ldto.it/e/3/coderdojo-at-linuxday'
			);
			$box(
				_("Allestimento museale di Retrocomputing."),
				"MuBIT",
				'http://mupin.it',
				_("dal %s"),
				'mubit.png'
			);
			$box(
				_("LIP (Linux Installation Party) e assistenza tecnica distribuzioni GNU/Linux."),
				_("volontari")
			);
			?>

		</div>
	</div>

	<div id="rooms" class="divider" data-show="#rooms-section"></div>
	<div class="section" id="rooms-section">
		<h3><?php _e("Planimetria") ?></h3>
		<img class="materialboxed" src="<?php echo ROOT ?>/2016/static/libre-icons/planimetria_dip_info.png" alt="<?php _e("Planimetria Dipartimento di Informatica") ?>" />
	</div>

	<div id="price" class="divider" data-show="#price-section"></div>
	<div class="section" id="price-section">
		<div class="row">
			<div class="col s12 m4">
				<img class="responsive-img circle hoverable" src="<?php echo XXX ?>/4-liberta.png" alt="<?php
					_("Le quattro libertà fontamentali del software libero")
				?>" />
			</div>
			<div class="col s12 m8">
				<p class="flow-text"><?php printf(
					_(
					"Anche quest'anno l'accesso all'evento è completamente gratuito.<br /> ".
					"Non dimenticare di portarti a casa una <em>maglietta</em> o ".
					"qualche dozzina di adesivi e spille! ".
					"È il nostro modo per promuovere ulteriormente il software libero, ".
					"per far sì che altri Linux Day rimangano sempre indipendenti, liberi e gratuiti.<br /> ".
					"Ci vediamo il <strong>%s</strong>!"
					),
					_("22 ottobre")
				) ?></p>

				<!--
				<p><?php echo HTML::a(
					CONFERENCE . '/partner.php',
					_("Scopri i nostri partner") . icon('business', 'right'),
					sprintf(
						_("Partner %s"),
						SITE_NAME
					),
					'btn purple white-text waves-effect waves-light'
				) ?></p>
				-->
			</div>
		</div>
	</div>
<?php new Footer(['home' => false]);
