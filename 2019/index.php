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

if( !$conference ) {
	die_with_404();
}

template( 'header', [
	'conference' => $conference,
	'title'      => $conference->getConferenceTitle(),
	'intro'      => true,
	'canonical'  => $conference->getConferenceURL( true ),
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

		<div class="row">
			<div class="col-md-12">
                		<p class="lead">
                		    <br><br><br><?= __("L'accesso all'evento è libero e gratuito. Non è richiesta registrazione.") ?>
		                </p>
			</div>
		</div>
	</div>
</section>

<!-- =========================
    PHOTOS SECTION
============================== -->
<section id="photos" class="parallax-section">
	<div class="container">
		<div class="row">
			<?php foreach(array_diff(['.', '..'], scandir('./images/photos/')) as $photo): ?>
				<div class="col-sm-4">
					<a href="<?= CURRENT_CONFERENCE_ROOT ?>/images/photos/<?= basename($photo) ?>" data-lightbox="roadtrip">
						<img src="<?= CURRENT_CONFERENCE_ROOT ?>/images/photos/<?= basename($photo) ?>" class="img-responsive" alt="Linux Day Torino 2019">
					</a>
				</div>
			<?php endforeach ?>
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
				</div>
			</div>
		</div>
		<div class="row border-bottom">
		<?php foreach( [ 'base', 'dev', 'sys', 'misc' ] as $track ): ?>
			<div class="col-xs-12 col-sm-3">
				<h2 class="room-title room-title-<?= esc_attr( $track ) ?>"><?php printf(
					__( "Aula %s" ),
					$track
				) ?></h2>
				<div class="row">
					<?php
						// every Event should start when the Conference starts
						$last_event_start = $conference->getConferenceStart();
					?>
					<?php foreach( Homepage19::eventsFromConferenceTrack( $conference, $track ) as $event ): ?>
						<?php $last_event_start = $event->get( Event::START ) ?>
						<div class="col-xs-12">
							<h3><?= HTML::a(
								$event->getEventURL(),
								esc_html( $event->getEventTitle() )
							) ?></h3>

							<?php if( $event->hasEventSubtitle() ): ?>
								<h3 class="event-subtitle"><?= esc_html( $event->getEventSubtitle() ) ?></h3>
							<?php endif ?>

							<h4><?= sprintf(
								__( "Di %s"),
								Homepage19::listEventAuthors( $event, __( "Speaker Segreto" ) )
							) ?></h4>
							<p>
								<span><i class="fa fa-clock-o"></i>&nbsp;<?=
									$event->getEventStart( 'H:i' )
								?> (<?=	$event->getHumanEventDuration( [ 'long' => false ] ) ?>)</span>
								<br />
								<span><i class="fa fa-map-marker"></i>&nbsp;<?php printf(
									__( "Aula %s" ),
									esc_html( $track )
								) ?></span>
							</p>

							<?php
								if( $event->hasEventAbstract() ) {
									echo $event->getEventAbstractHTML();
								}
							?>

							<p>
								<i class="fa fa-info-circle"></i>&nbsp;<a href="<?= esc_attr( $event->getEventURL() ) ?>">info</a>
								&nbsp;
								<i class="fa fa-calendar"></i><a href="<?= esc_attr( $event->getEventCalURL() ) ?>" title="<?= esc_attr( $event->getEventTitle() ) ?>">&nbsp;<?= __( "Memo" ) ?></a>
							</p>

							<?php if( $event->isEventEditable() ): ?>
								<?= HTML::a(
									$event->getFullEventEditURL(),
									__( "Modifica" )
								) ?>
							<?php elseif( $event->isEventTranslatable() ): ?>
								<?= HTML::a(
									$event->getEventTranslateURL(),
									__( "Traduci" )
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
		<div class="row">
			<div class="col-sm-12 text-center">
				<div>
					<img class="img-fluid" src="<?= CURRENT_CONFERENCE_ROOT ?>/images/planimetria.png" alt="<?= esc_attr( __( "planimetria" ) ) ?>" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="section-title">
					<h2><?= __( "Streaming" ) ?></h2>
					<p><?= sprintf(
						__( "Prendi parte alla conferenza, in diretta dall'aula: %s." ),
						__( "Aula Misc" )
					)  ?></p>
					<p><?= sprintf(
						__( "Inizio streaming: ore %s. Fine: %s." ),
						'14:00',
						'18:00'
					) ?></p>
					<iframe width="720" height="404" src="./streaming.html" frameborder="0" allowfullscreen></iframe>
					<p><?= sprintf(
						__( "Grazie a %s per lo streaming!" ),
						HTML::a(
							'https://www.top-ix.org/',
							"TOP-IX"
						)
					) ?></p>
					<p><?= __( "Le altre tracce saranno registrate e pubblicate sui social nei giorni successivi!" ) ?></p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- =========================
   GNU/Linux Installation Party
============================== -->
<section id="lip-info" class="parallax-section">
	<div class="container">
		<div class="row">
			<h2 class="text-center"><?= __( "Nello stesso momento" ) ?>&hellip;</h2>
			<div class="col-md-6">
				<img class="img-responsive" src="<?= CURRENT_CONFERENCE_ROOT ?>/images/gnu-linux-installation-party-ds.jpg" title="GNU/Linux installation party DSLite DSLinux" />
			</div>
			<div class="col-md-6">
				<div class="jumbotron">
					<h3><?= sprintf(
						__( "Cos'è il %s" ),
						"Linux Installation Party"
					) ?></h3>
					<p><?= __( "Porta con te il tuo computer portatile, uno smartphone, un tostapane, una centrale termonucleare, o qualsiasi cosa che potrebbe essere convertita a GNU/Linux e aiuteremo noi nella loro liberazione!" ) ?></p>
				</div>
				<p><small><em><?= sprintf(
					__( "L'immagine di %s e di %s disponibili rispettivamente in licenza %s e %s." ),

					// DS Linux
					HTML::a(
						'https://commons.wikimedia.org/wiki/File:Ds_lite_with_slot-2_device_running_dslinux.jpg',
						"DSLinux"
					),

					// GNU & Freedo
					HTML::a(
						'https://commons.wikimedia.org/wiki/File:GNU_and_Freedo.svg',
						"GNU & Freedo"
					),

					// DS Linux's license
					__( "pubblico dominio" ),

					// GNU & Freedo license
					sprintf(
						"%s+%s",

						// GNU is in GNU FDL
						license( 'gnu-fdl'      )->getLink(),

						// Freedo is in CC BY SA 2.0
						license( 'cc-by-sa-2.0' )->getLink()
					)
				) ?></em></small></p>
			</div>
		</div>
	</div>
</section>

<!-- =========================
   Other stuff
============================== -->
<section id="other-stuff" class="parallax-section">
	<div class="container">
		<h2 class="text-center"><?= __( "Ma non finisce qui!" ) ?></h2>
		<div>
			<img class="img-responsive" src="<?= CURRENT_CONFERENCE_ROOT ?>/images/corso-linux-base-gnu-freedo.jpg" title="<?= esc_attr( __( "Corsi GNU/Linux" ) ) ?>" />
		</div>
		<div class="jumbotron">
			<h3><?= __( "Corsi GNU/Linux" ) ?></h3>
			<p><?= __( "Ti aspettiamo al Linux Day, ma nei giorni successivi organizzeremo anche dei veri e propri corsi (gratuiti!) di livello base ed avanzato, sull'uso di GNU/Linux in ambito personale e industriale." ) ?></p>
			<p><?= __( "Che aspetti? Prenota un posto anche per i corsi!" ) ?></p>
			<a href="https://linux.studenti.polito.it/wp/corso-gnu-linux-base-autunno-2019/"><?= __( "Iscrizione ai corsi GNU/Linux" ) ?></a>
		</div>
</section>

<!-- =========================
   Other stuff
============================== -->
<section id="other-stuff" class="parallax-section">
	<div class="container">
		<h2 class="text-center"><?= __( "Assistenza tecnica" ) ?></h2>
		<div class="jumbotron">
			<p><?= __( "Ti aspettiamo al Linux Day, ma dopo questa conferenza non ti lasceremo certo da solo!" ) ?></p>

			<ul>
				<li>
					<?= Markdown::parse( __( "Ogni mercoledì, sportello di assistenza gratuita al software libero, all'**Officina Informatica Libera**, in via Oddino Morgari 14, a Torino." ) ) ?>
					<p><a href="https://informaticalibera.info/"><?= __( "Contatti" ) ?></a> (<?= sprintf(
						__( "prossimo: %s" ),
						__( "30 ottobre" )
					) ?>)</p>
				</li>
				<li>
					<?= Markdown::parse( __( "Ogni terzo sabato del mese, sportello di assistenza gratuita al software libero, con il **GLugTO**, al Polo culturale Lombroso16" ) ) ?>
					<p><a href="https://www.glugto.org/index.php/2016/11/07/lombrosognu/"><?= __( "Contatti" ) ?></a> (<?= sprintf(
						__( "prossimo: %s" ),
						__( "2 novembre" )
					) ?>)</p>
				</li>
			</ul>
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
        							<p><?= sprintf(
        								__( "Cos'è il %s" ),
        								"Linux Day"
        							) ?></p>
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
   						<div class="panel-heading" role="tab" id="faq-price">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
        							<p><?= __( "Quanto costa?" ) ?></p>
        						</a>
      						</h4>
    					</div>
   						<div id="collapsePrice" class="panel-collapse collapse" role="tabpanel" aria-labelledby="faq-price">
      						<div class="panel-body">
      							<p><?= __( "L'evento è completamente gratuito ed è unicamente possibile grazie al sostegno di tutte le community di Torino e di chi crede in loro." ) ?></p>
      						</div>
   						 </div>
 					</div>

 					<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="faq-record">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-record" aria-expanded="false" aria-controls="collapse-record">
        							<p><?= __( "Registrerete i talk?" ) ?></p>
        						</a>
      						</h4>
    					</div>
   						<div id="collapse-record" class="panel-collapse collapse" role="tabpanel" aria-labelledby="faq-record">
      						<div class="panel-body">
      							<p><?= __( "Per favore cerca di venire di persona! Abbiamo bisogno del tuo aiuto fisico per rendere questa community attiva e straordinaria! In ogni caso il nostro Media Partner farà il possibile per registrare più tracce possibili, forse anche con uno streaming." ) ?></p>
      						</div>
   						 </div>
 					</div>

 					<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="faq-tshirt">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
        							<p><?= __( "Come prenoto una T-shirt?" ) ?></p>
        						</a>
      						</h4>
    					</div>
   						<div id="collapse-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="faq-tshirt">
      						<div class="panel-body">
      							<p><?= __( "Comunicaci la tua taglia ed il genere (uomo/donna) e te la terremo da parte fresca per l'evento!" ) ?></p>
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
				<h2><?= __( "Dove" ) ?></h2>
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
						__( "Anche i bus %s e %s fermano abbastanza vicino." ),
						"14, 35",
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
   Media Partner
============================== -->
<section id="media-partner">
	<div class="container text-center">
		<h2><?= __( "Con il supporto di…" ) ?></h2>
		<div class="row">
			<div class="col-sm-6 col-md-4 col-lg-3">
				<p>Sponsor</p>
				<a href="http://www.b-play.com/" title="B-Play">
					<img src="<?= CURRENT_CONFERENCE_ROOT ?>/images/bplay.png" alt="B-Play" />
				</a>
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<p>Location</p>
				<a href="https://www.toolboxoffice.it/" title="Toolbox">
					<img src="<?= ROOT ?>/2019/images/toolbox.jpg" alt="Toolbox" />
				</a>
				<a href="http://fablabtorino.org/" title="FabLab Torino">
					<img src="<?= ROOT ?>/2019/images/fablab.png" alt="FabLab Torino" />
				</a>
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<p>Italian Linux Society</p>
				<a href="https://www.ils.org/" title="Italian Linux Society">
					<img src="<?= ROOT ?>/2018/images/ils.png" alt="Italian Linux Society" />
				</a>
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<p><?= __( "Media Partner" ) ?></p>
				<a href="https://www.top-ix.org/" title="TOP-IX">
					<img src="<?= CURRENT_CONFERENCE_ROOT ?>/images/topix.png" alt="TOP-IX" />
				</a>
				<a href="https://www.facebook.com/gdgtorino" title="GDG">
					<img src="<?= CURRENT_CONFERENCE_ROOT ?>/images/gdg.png" alt="GDG" />
				</a>
			</div>
		</div>
	</div>
</section>

<section id="patronage">
	<div class="container text-center">
		<h2><?= __( "Con il patrocinio di…" ) ?></h2>
			<div class="col-sm-6 col-md-4 col-lg-3 col-lg-offset-3">
				<img class="img-responsive reduce-height" src="<?= ROOT ?>/2016/static/partner/metropoli.png" alt="Città metropolitana di Torino" />
			</div>
			<div class="col-sm-6 col-md-4 col-lg-3">
				<img class="img-responsive reduce-height" src="<?= ROOT ?>/2016/static/partner/comune.jpg" alt="Comune di Torino" />
			</div>
		</div>
	</div>
</section>

<!-- =========================
    CONTACT SECTION
============================== -->
<section id="contact" class="parallax-section">
	<div class="container text-center">
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

<script>
$( function () {

	var $window   = $( window );
	var $chapters = $( '#program > .container > .row > .col-xs-12 > .row' );

	/**
	 * Make columns at the same minimum height on desktop
	 *
	 * The name is because of this feature is a madbob order. asd
	 */
	function tableBobbification() {
		var windowWidth = $window.width();
		var minHeight = 0;
		var column = 0;

		if( windowWidth < 768 ) {
			$chapters.children().css( 'min-height', 'unset' );
			return;
		}

		do {
			column++;
			var $firstRow = $chapters.children( ':nth-child(' + column + ')' );
			$firstRow.each( function () {
				var height = $(this).height();
				if( height > minHeight ) {
					minHeight = height;
				}
			} );
			$firstRow.css( 'min-height', minHeight + 'px' );
		} while( $firstRow.length > 0 );
	};

	tableBobbification();

	$(window).resize( tableBobbification );
} );
</script>

<?php template( 'footer' );
