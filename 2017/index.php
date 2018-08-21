<?php
# Linux Day 2017 - Single conference page
# Copyright (C) 2017, 2018 Roberto Guido, Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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

$conference = FullConference::factoryFromUID( @ $_GET['uid'] )
	->queryRow();

$conference or die_with_404();

FORCE_PERMALINK
	and $conference->forceConferencePermalink();

enqueue_js('leaflet');
enqueue_js('leaflet.init');
enqueue_js('scrollfire');
enqueue_js('typed');
enqueue_css('leaflet');
enqueue_css('home');

Header::spawn('conference', [
	'nav'        => false,
	'show-title' => false,
	'head-title' => $s = $conference->getConferenceTitle(),
	'title'      => $s,
	'url'        => $conference->getConferenceURL(),
	'container'  => false
] );
?>

<section id="introduction">
	<div class="container">
		<div class="center-align">
			<h1 class="uppercase"><?php _e("Linux Day<br />Torino") ?></h1>
			<p class="flow-text typing-smanettone-container"><?php printf(
				_("Se anche tu sei %suno smanettone%s, vieni a trovarci!"),
				'<span class="typing-smanettone">',
				'</span>'
			) ?></p>
			<p><a href="#about" class="btn waves-effect green"><?php _e("Sabato 28 ottobre") ?></a></p>
		</div>
	</div>
</section>

<script>
$('.typing-smanettone').text('');
var typed = new Typed('.typing-smanettone', {
	strings: <?php echo json_encode( [
		_("uno smanettone"),
		_("un programmatore"),
		_("un tipo curioso"),
		_("un sistemista"),
		_("un po' pinguino"),
		_("in modalità incognito"),
		_("un cucciolo di GNU")
	] ); ?>,
	loop: true,
	typeSpeed: 100,
	backDelay: 1000,
	backSpeed: 20,
	showCursor: false
} );
</script>

<section class="container" id="about">
	<div class="center-align">
		<h2><?php _e("Cos'è il Linux Day Torino") ?></h2>
		<div class="container">
			<p class="flow-text"><?php _e(
				"L'edizione sabauda del Linux Day, il grande evento nazionale per la promozione e la ".
				"diffusione di GNU/Linux e del software libero."
			) ?></p>
		</div>
	</div>

	<div class="row">
		<div class="col s12 l5 long-description">
			<p><?php _e(
				"Il Linux Day è un evento che si svolge nello stesso giorno (quest'anno, ".
				"sabato 28 ottobre) in tutta Italia."
			) ?>
			<p><?php _e(
				"Il Comitato Linux Day Torino, costituito informalmente da volontari, ".
				"associazioni e professionisti, organizza dal 2007 l'edizione torinese della ".
				"manifestazione, che si articola su diverse sessioni parallele con talk per ogni ".
				"tipo di interesse."
			) ?></p>
			<p><?php _e(
				"Quest'anno siamo ospitati dal Dipartimento di Informatica dell'Università ".
				"di Torino, in via Pessinetto. L'accesso all'evento è libero e gratuito."
			) ?></p>
			<p><a href="#schedule" class="btn green waves-effect"><?php _e("Vedi il programma") ?></a></p>
		</div>

		<!-- Fuffa :) -->
		<?php $fuffa_box = function ($title, $icon, $phrase) { ?>
			<div class="col s12 l6 center-align">
				<p><i class="material-icons"><?php echo $icon ?></i></p>
				<h3><?php echo $title ?></h3>
				<p><?php echo $phrase ?></p>
			</div>
		<?php }; ?>

		<div class="col s12 l6 offset-l1">
			<div class="row">
				<?php
					$fuffa_box( _("Location"),     'location_on', _("Dipartimento di Informatica UniTo in Via Pessinetto 12, Torino.") );
					$fuffa_box( _("Speakers"), 'event_seat', sprintf(
						_("<b>%d</b> relatori, distribuiti su <b>%d</b> sessioni tematiche."),
						16,
						4
					) );
				?>
			</div>
			<div class="row">
				<?php
					$fuffa_box( _("Quando"), 'access_time', _("<b>28 ottobre 2017</b> dalle 14:00 alle 19:00.") );
					$fuffa_box( _("Extras"), 'extension', _("Linux Install Party, Restart Party, CoderDojo, Open Source Saturday") );
				?>
			</div>
		</div>
		<?php unset( $fuffa_box ) ?>
		<!-- /Fuffa :) -->
	</div>
</section>

<section id="location">
	<div class="container">
		<div class="row">
			<div class="col s12 m7 l6">
				<div class="card-panel">
					<h2><?php _e("Location") ?></h2>

					<p><?php _e(
						 "Per il secondo anno il Dipartimento di Informatica dell'Università di Torino ".
						"ospita il Linux Day di Torino. Per avvicinare i professionisti di domani a GNU/Linux, ".
						"al software libero e all'open source."
					) ?></p>

					<p><?php _e("Per raggiungerlo puoi:") ?></p>
					<p><?php _e("Venire in auto, il parcheggio in zona non manca") ?>;<br />
					<?php _e("Prendere il tram 9 o 3 (\"Ospedale Amedeo di Savoia\")") ?>;<br />
					<?php _e("Prendere il bus 59 o 50/") ?>
					</p>
					<noscript><?php _e("Abilita JavaScript per vedere la mappa") ?></noscript>
					<?php $conference->printLocationLeaflet() ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="schedule">

	<div class="container center-align">
		<h2><?php _e("Programma") ?></h2>
		<p><?php _e("Il programma dei talk è in fase di definizione! :)") ?></p>
	</div>

	<div id="schedule-background">

		<!-- Bigdata :) -->
		<div class="row">
			<?php
				$bigdata_box = function ($title, $subject) {
					?>
					<div class="col s12 m4 center-align">
						<h3 class="white-text"><?php echo $title ?></h3>
						<p class="flow-text white-text"><?php echo $subject ?></p>
					</div>
					<?php
				};

				$bigdata_box( 4,  _("sessioni") );
				$bigdata_box( 4,  _("ore") );
				$bigdata_box( 16, _("relatori") );

				unset( $bigdata_box );
			?>
		</div>
		<!-- /Bigdata :) -->
	</div>
</section>

<section class="container" id="extras">
	<div class="center-align">
	<h2><?php _e("Extras") ?></h2>
	<p class="flow-text"><?php _e(
		"Se i talk non dovessero bastare, abbiamo altro con cui animare la giornata!"
	) ?></p>
	</div>

	<!-- extra boxes -->
	<?php $extra_box = function($title, $content) { ?>
		<div class="col s12 m6">
			<div class="card-panel">
				<h5><?php echo $title ?></h5>
				<p><?php echo $content ?></p>
			</div>
		</div>
	<?php }; ?>

	<div class="row">
		<?php
			$extra_box( "Linux Install Party", _("Porta il tuo computer, ti aiuteremo ad installare Linux!") );
			$extra_box( "Restart Party", _("Il frullatore non funziona più? Portalo e lo ripareremo insieme!") );
		?>
	</div>
	<div class="row">
		<?php
			$extra_box( "CoderDojo", sprintf(
				_("Workshop di programmazione di base per bambini e ragazzi dai %d ai %d anni. Prenotazione obbligatoria (disponibile a breve)."),
				7,
				13
			) );
			$extra_box( "Open Source Saturday", _("Vieni a presentare il tuo progetto open source e smanettaci con altri appassionati!") );
		?>
	</div>
	<?php unset( $extra_box ) ?>
	<!-- /extra boxes -->
</section>

<section class="container center-align" id="sponsor">
	<h2><?php _e("Sponsor") ?></h2>
	<p class="flow-text"><?php _e("Grazie al nostro sponsor, che ci aiuta a sostenere le spese e a far crescere l'evento.") ?></p>
	<div class="center-align">
		<a href="http://www.quadrata.it/">
			<img src="<?php echo STATIC_PATH ?>/partner/quadrata.png" alt="Quadrata" />
		</a>
	</div>
</section>

<?php
Footer::spawn( ['home' => false] );
