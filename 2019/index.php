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
<!--

    _-`````-,           ,- '- .
  .'   .- - |          | - .   `.
 /.'  /                     `.   \
:/   :      _...   ..._      ``   :
::   :     /._ .`:'_.._\.    ||   :
::    `._ ./  ,`  :    \ . _.''   .
`:.      |   |  -.  \-. \\_      /
  \:._ _/  ..'  .@)  \@) ` `\ ,.'
     _/,-—'       .- .\,-.`—-`.
       ,'/''     (( \ `  )
        /'/'  \    `-'  (
         '/''  `._,—-—-—-'
          ''/'    .,-—-'
           ''/'      ;:
             ''/''  ''/
               ''/''/''
                 '/'/'
                  `;

                    ..- - .
                   '        `.
                  '.- .  .—-. .
                 |: _ | :  _ :|
                 |`(@)——`.(@) |
                 : .'     `-, :
                 :(_____.-'.' `
                 : `-.__.-'   :
                 `  _.    _.   .
                /  /  `_ '  \    .
               .  :          \\   \
              .  : _      __  .\   .
             .  /             : `.  \
            :  /      '        : `.  .
           '  `      :          : :  `.
         .`_ :       :          / '   |
         :' \ .      :           '__  :
      .-—'   \`-._    .      .' :    `).
    ..|       \   )          :   '._.'  :
   ;           \-'.        ..:         /
   '.           \  - ....-   |        '
      -.         :   _____   |      .'
        ` -.    .'-¯       ¯-`.   .'
            `-¯¯               ¯¯¯

-->
<!-- =========================
    INTRO SECTION
============================== -->
<section id="intro" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<h3>Sabato 26 Ottobre 2019</h3>
				<h1>Linux Day Torino</h1>
				<div class="typing-smanettone-container text-white"><?php printf(
                    __("Se anche tu sei %suno smanettone%s, vieni a trovarci!"),
                    '<span class="typing-smanettone">',
                    '</span>'
                ) ?></div>
				<a href="#overview" class="btn btn-lg btn-default smoothScroll hidden-xs">SCOPRI DI PIÙ</a>
				<!-- <a href="#register" class="btn btn-lg btn-danger smoothScroll">CIAO</a>-->
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

<!-- =========================
    DETAIL SECTION
============================== -->
<section id="detail" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-4 col-sm-4">
				<i class="fa fa-group"></i>
				<h3>All toghether</h3>
				<p>LAN party, installation party. Porta un amico da convertire: ci divertiremo.</p>
			</div>

			<div class="col-md-4 col-sm-4">
				<i class="fa fa-clock-o"></i>
				<h3>Multi-Sessions</h3>
				<p>Scegli fra l'<b>aula base</b>, l'aula per <b>sistemisti</b> o <b>programmatori</b>.</p>
			</div>

			<div class="col-md-4 col-sm-4">
				<i class="fa fa-microphone"></i>
				<h3>Lot of speakers</h3>
				<p>Stiamo raccogliendo i tuoi interessi e scegliendo le persone che sapranno stupirci su questi temi.</p>
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
								<!--<i class="fa fa-info-circle"></i>&nbsp;<a href="#">info</a><br>-->
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
        							Cos'è il Linux Day?
        						</a>
      						</h4>
    					</div>
   						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      						<div class="panel-body">
        						<p><?= __( "È un evento nazionale che si svolge da quasi 20 anni. Si svolge in tutta Italia. Parallelamente. A Torino non mancheremo." ) ?></p>
      						</div>
   						 </div>
 					</div>

    				<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="headingTwo">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          							Posso portare un amico che non capisce nulla?
        						</a>
      						</h4>
    					</div>
   						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      						<div class="panel-body">
                            	<p>Porta rispetto per il tuo amico. Ma soprattutto porta il tuo amico! Abbandonalo all'aula "base" e vedrai che non si annoierà. Oppure portalo all'installation party e lo aiuteremo nella migrazione al software libero!</p>
      						</div>
   						 </div>
 					</div>

 					<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="headingThree">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        							Quanto costa?
        						</a>
      						</h4>
    					</div>
   						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      						<div class="panel-body">
      							<p>L'evento è completamente gratuito.</p>
      						</div>
   						 </div>
 					 </div>

 					<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="headingThree">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
        							Come prenoto una T-shirt?
        						</a>
      						</h4>
    					</div>
   						<div id="collapse-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-4">
      						<div class="panel-body">
      							<p>Contattaci e comunicaci la tua taglia e te la terremo da parte fresca per l'evento!</p>
      							<p>Ti conviene farlo perchè alcune taglie finiscono molto velocemente.</p>
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
				<h2>Luogo</h2>
				<p>La sede del Linux Day Torino 2019 sarà Toolbox Coworking, in via Agostino da Montefeltro 2.</p>
				<p>Per raggiungerci puoi:
				<ul>
					<li>Prendere il tram 4, fermata Ospedale Mauriziano</li>
					<li>Prendere il bus 42, fermata Mauriziano</li>
					<li>Prendere la metropolitana, fermata Dante</li>
					<li>Anche i bus 14, 24, 35 e 63 fermano abbastanza vicino, forse.</li>
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
<section id="sponsors" class="parallax-section">
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
