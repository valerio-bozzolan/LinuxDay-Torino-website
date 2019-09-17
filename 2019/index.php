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

require 'load.php';

enqueue_js('jquery');
enqueue_js('typed');
enqueue_js('leaflet');
enqueue_js('leaflet.init');
enqueue_css('leaflet');

$conference = FullConference::factoryFromUID( CURRENT_CONFERENCE_UID )
	->queryRow();

$conference or die_with_404();

FORCE_PERMALINK
	and $conference->forceConferencePermalink();

template( 'header', [
	'conference' => $conference,
] );

?>

<!-- =========================
    DETAIL SECTION
============================== -->
<section id="detail" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-4 col-sm-4">
				<i class="fa fa-group"></i>
				<h3><?= __( "Tutti insieme" ) ?></h3>
				<p><?= __( "LAN party, installation party, mini Restart Party. Porta un amico da convertire: ci divertiremo insieme a tutte le community." ) ?></p>
			</div>

			<div class="col-md-4 col-sm-4">
				<i class="fa fa-clock-o"></i>
				<h3><?php printf(
					__( "%s sessioni" ),
					4
				) ?></h3>
				<p><?= __( "Scegli fra l'<b>aula base</b>, l'aula per <b>sistemisti</b> o <b>programmatori</b> e divertiti!" ) ?></p>
			</div>

			<div class="col-md-4 col-sm-4">
				<i class="fa fa-microphone"></i>
				<h3><?php printf(
					__( "%s relatori" ),
					16
				) ?></h3>
				<p><?= __( "Programmatori, ingegneri, avvocati, professionisti nell'ambito del software libero. Tutti insieme a Torino." ) ?></p>
			</div>

		</div>
	</div>
</section>

<!-- =========================
    PROGRAM SECTION
============================== -->
<section id="program" class="parallax-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="section-title">
					<h2><?= __( "Programma" ) ?></h2>
					<p><?= __( "Ecco un assaggio dei temi che verranno affrontati:" ) ?></p>
				</div>
			</div>
		</div>
		<div class="row border-bottom">
		<?php foreach( [ 'base', 'dev', 'sys', 'misc' ] as $track ): ?>
			<div class="col-xs-12 col-sm-3">
				<p><?php printf(
					__( "Aula %s" ),
					$track
				) ?></p>
				<div class="row">
					<?php
						// every Event should start when the Conference starts
						$last_event_start = $conference->getConferenceStart();

						// query all the events that belongs to this conference
						// and that belongs to this chapter
						// order by date
						$events =
							FullEvent::factoryByConference( $conference->getConferenceID() )
								->whereStr( Track::UID, $track )
								->orderBy(  Event::START, 'ASC' )
								->queryResults();
					?>
					<?php foreach( $events as $event ): ?>
						<?php $last_event_start = $event->get( Event::START ) ?>
						<div class="col-xs-12">
							<h3><?= esc_html( $event->getEventTitle() ) ?></h3>

							<?php if( $event->hasEventSubtitle() ): ?>
								<h3 class="event-subtitle"><?= esc_html( $event->getEventSubtitle() ) ?></h3>
							<?php endif ?>

							<h4><?= sprintf(
								__( "Di %s"),
								Homepage19::listEventAuthors( $event, __( "Speaker Segreto" ) )
							) ?></h4>
							<h6>
								<span><i class="fa fa-clock-o"></i>&nbsp;<?=
									$event->getEventStart( 'H:i' )
								?></span><!--
								--><span><i class="fa fa-map-marker"></i>&nbsp;<?php printf(
									__( "Aula %s" ),
									esc_html( $track )
								) ?></span>
							</h6>

							<?php if( $event->hasEventAbstract() ): ?>
								<p><?= $event->getEventAbstractHTML() ?></p>
							<?php endif ?>

							<p>
								<i class="fa fa-info-circle"></i>&nbsp;<a href="<?= esc_attr( $event->getEventURL() ) ?>">info</a>
							</p>
							<p>
								<i class="fa fa-calendar"></i><a href="<?= esc_attr( $event->getEventCalURL() ) ?>" title="<?= esc_attr( $event->getEventTitle() ) ?>">&nbsp;<?= __( "Salva sul calendario" ) ?></a>
							</p>

							<?php if( $event->isEventEditable() ): ?>
								<?= HTML::a(
									$event->getFullEventEditURL(),
									__( "Modifica" )
								) ?>
							<?php endif ?>
						</div>
					<?php endforeach ?>

					<?php if( has_permission( 'add-event' ) ): ?>
						<?php
							$one_hour = new DateInterval('PT1H');

							// add one hour to the last event to suggest a new one
							$last_event_start = clone $last_event_start;
							$last_event_start->add( $one_hour );

							$last_event_end   = clone $last_event_start;
							$last_event_end->add( $one_hour );
						?>
						<div class="col-xs-12">
							<a href="<?= esc_attr( $conference->getURLToCreateEventInConference( [
								'chapter' => 'talk',
								'track'   => $track,
								'start'   => $last_event_start->format( 'Y-m-d H:i:s' ),
								'end'     => $last_event_end  ->format( 'Y-m-d H:i:s' ),
							] ) ) ?>"><?= __( "Aggiungi" ) ?></a>
						</div>
					<?php endif ?>
				</div>
			</div>
		<?php endforeach ?>
		</div>
	</div>
</section>

<!-- =========================
    FAQ SECTION   
============================== -->
<section id="faq" class="parallax-section">
	<div class="container">
		<div class="row">

			<!-- Section title
			================================================== -->
			<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 text-center">
				<div class="section-title">
					<h2>FAQ</h2>
					<p><?= __( "Domande frequenti" ) ?></p>
				</div>
			</div>

			<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

  					<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="headingOne">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        							<p><?= __( "Cos'è il Linux Day?" ) ?></p>
        						</a>
      						</h4>
    					</div>
   						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      						<div class="panel-body">
        						<p><?= __( "È un evento nazionale che si svolge da quasi 20 anni. Si svolge in tutta Italia, parallelamente, e a Torino non mancheremo." ) ?></p>
        						<p><?= HTML::a(
        							'https://www.linuxday.it/',
        							__( "Informazioni sul Linux Day nazionale" )
        						) ?></p>
      						</div>
   						 </div>
 					</div>

    				<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="headingTwo">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          							<p><?= __( "Posso portare un amico che non capisce nulla?" ) ?></p>
        						</a>
      						</h4>
    					</div>
   						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      						<div class="panel-body">
                            	<p><?= __( "Porta rispetto per il tuo amico. Ma soprattutto porta il tuo amico! Abbandonalo all'aula \"base\" e vedrai che non si annoierà. Oppure portalo all'installation party e lo aiuteremo nella migrazione al software libero!" ) ?></p>
      						</div>
   						 </div>
 					</div>

 					<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="headingThree">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        							<p><?= __( "Quanto costa?" ) ?></p>
        						</a>
      						</h4>
    					</div>
   						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      						<div class="panel-body">
      							<p><?= __( "L'evento è completamente gratuito ed è unicamente possibile grazie al sostegno di tutte le community di Torino e di chi crede in loro." ) ?></p>
      						</div>
   						 </div>
 					 </div>

 					<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="headingThree">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
        							<p><?= __( "Come prenoto una T-shirt?" ) ?></p>
        						</a>
      						</h4>
    					</div>
   						<div id="collapse-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-4">
      						<div class="panel-body">
      							<p><?= __( "Comunicaci la tua taglia e te la terremo da parte fresca per l'evento!" ) ?></p>
      							<p><?= __( "Seriamente, ti conviene dircelo prima perchè alcune taglie finiscono molto velocemente, e ogni anno molte persone rimangono spoglie." ) ?></p>
      						</div>
   						 </div>
 					 </div>

 				 </div>
			</div>

		</div>
	</div>
</section>


<!-- =========================
    VENUE SECTION
============================== -->
<section id="venue" class="parallax-section">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-8">
				<h2><?= __( "Luogo" ) ?></h2>
				<p><?= __( "La sede del Linux Day Torino 2019 sarà Toolbox Coworking, in via Agostino da Montefeltro 2." ) ?></p>
				<p><?= __( "Per raggiungerci puoi:" ) ?></p>
				<ul>
					<li><?php printf(
						__( "Prendere %s, fermata %s" ),
						sprintf(
							__( "il %s" ),
							sprintf(
								__( "tram %s" ),
								"4"
							)
						),
						__( "Ospedale Mauriziano" )
					) ?></li>
					<li><?php printf(
						__( "Prendere %s, fermata %s" ),
						sprintf(
							__( "il %s" ),
							sprintf(
								__( "bus %s" ),
								"42"
							)
						),
						"Mauriziano"
					) ?></li>
					<li><?php printf(
						__( "Prendere %s, fermata %s" ),
						sprintf(
							__( "la %s" ),
							__( "metropolitana" )
						),
						"Dante"
					) ?></li>
					<li><?php printf(
						__( "Anche i bus %s e %s fermano abbastanza vicino, forse." ),
						"14, 24, 35",
						"63"
					) ?></li>
				</ul>
			</div>
			<div class="col-md-6 col-sm-4">
				<noscript><?= __("Abilita JavaScript per vedere la mappa") ?></noscript>
				<?= $conference->printLocationLeaflet() ?>
			</div>
		</div>
	</div>
</section>


<!-- =========================
    SPONSORS SECTION   
============================== -->
<section id="sponsors" class="parallax-section" style="display:none">
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<div class="section-title">
					<h2>Sponsor</h2>
					<p>La società per cui lavori (o la tua società!) potrebbe desiderare questo spazio per poter contribuire alla qualità dell'evento! Contattaci al +39 3290075073.</p>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-6">
				<img src="images/sponsor-img1.jpg" class="img-responsive" alt="sponsors">	
			</div>

			<div class="col-md-3 col-sm-6 col-xs-6">
				<img src="images/sponsor-img2.jpg" class="img-responsive" alt="sponsors">	
			</div>

			<div class="col-md-3 col-sm-6 col-xs-6">
				<img src="images/sponsor-img3.jpg" class="img-responsive" alt="sponsors">	
			</div>

			<div class="col-md-3 col-sm-6 col-xs-6">
				<img src="images/sponsor-img4.jpg" class="img-responsive" alt="sponsors">	
			</div>

		</div>
	</div>
</section>

<!-- =========================
    CONTACT SECTION
============================== -->
<section id="contact" class="parallax-section">
	<div class="container">
		<div class="col-12">
			<h2><?= __( "Contattaci" ) ?></h2>
			<p><?php printf(
				__( "Per contattare il Comitato Linux Day Torino puoi scrivere all'indirizzo email %s o al numero %s." ),
				CONTACT_EMAIL,
				HTML::a(
					'tel:' . CONTACT_PHONE_PREFIX . CONTACT_PHONE,
					CONTACT_PHONE
				)
			) ?></p>
		</div>
	</div>
</section>

<?php template( 'footer' );
