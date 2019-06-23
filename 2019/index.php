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
    OVERVIEW SECTION
============================== -->
<section id="overview" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-6 col-sm-6">
				<h3>Linux Day Torino 2019 sarà un evento bello.</h3>
				<p><a href="<?= esc_attr( $conference->getConferenceCalURL() ) ?>" title="iCal">Salvalo immantinente sul calendario</a>!</p>
				<h4>Fase 1: Call for Paper!</h4>
				<p>Hai <b>idee</b>? Concept? Proposte? Hai un <b>logo</b> e un motto meno orribili di questa immagine? Entra nella <a href="https://lists.linux.it/listinfo/ldto"><b>mailing list comitato Linux Day Torino</b></a>!</p>
			</div>

			<div class="col-md-6 col-sm-6">
				<img src="/2019/images/placeholder-cose.png" class="img-responsive" alt="Overview">
			</div>

		</div>
	</div>
</section>


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

<?php /*


<!-- =========================
    VIDEO SECTION
============================== -->
<section id="video" class="parallax-section">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-10">
				<h2>Watch Video</h2>
				<h3>Quisque ut libero sapien. Integer tellus nisl, efficitur sed dolor at, vehicula finibus massa. Sed tincidunt metus sed eleifend suscipit.</h3>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet consectetuer diam nonummy.</p>
			</div>
			<div class="col-md-6 col-sm-10">
				<div class="embed-responsive embed-responsive-16by9">
					<!-- iframe class="embed-responsive-item" src="https://www.youtube.com/embed/6sqk9MT9Tfg" allowfullscreen></iframe -->
				</div>
			</div>

		</div>
	</div>
</section>


*/ ?>

<!-- =========================
    SPEAKERS SECTION   
============================== -->
<section id="speakers" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<div class="section-title">
					<h2>Creative Speakers</h2>
					<p>Non vogliamo annoiarti. Ti caricheremo di <b>idee</b>, energia e <b>libertà digitali</b>.</p>
					<p>I candidati relatori saranno vagliati dal comitato Linux Day Torino e mostrati a breve.</b>
				</div>
			</div>

			<!-- Testimonial Owl Carousel section
			================================================== -->
			<div id="owl-speakers" class="owl-carousel">

				<div class="item col-md-3 col-sm-3">
					<div class="speakers-wrapper">
						<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="speakers">
							<div class="speakers-thumb">
								<h3>Mario Rossi</h3>
								<h6>Smanettone</h6>
							</div>
					</div>
				</div>

				<div class="item col-md-3 col-sm-3">
					<div class="speakers-wrapper">
						<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="speakers">
							<div class="speakers-thumb">
								<h3>Giovanna Bianchi</h3>
								<h6>Nerdona</h6>
							</div>
					</div>
				</div>

				<div class="item col-md-3 col-sm-3">
					<div class="speakers-wrapper">
						<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="speakers">
							<div class="speakers-thumb">
								<h3>Joe Vanni</h3>
								<h6>Tizio a caso</h6>
							</div>
					</div>
				</div>

				<div class="item col-md-3 col-sm-3">
					<div class="speakers-wrapper">
						<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="speakers">
							<div class="speakers-thumb">
								<h3>Mariolino Rossino</h3>
								<h6>Smanettino</h6>
							</div>
					</div>
				</div>

				<div class="item col-md-3 col-sm-3">
					<div class="speakers-wrapper">
						<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="speakers">
							<div class="speakers-thumb">
								<h3>Mario Rossi Rossi</h3>
								<h6>Doppio smanettone</h6>
							</div>
					</div>
				</div>
				
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
					<h2>Programma</h2>
					<p>I temi affrontati e i talk sono in fase di definizione.</p>
				</div>
			</div>
		</div>

			<?php foreach(['14:00', '15:00', '16:00', '17:00'] as $time): ?>
			<div class="row border-bottom">
				<?php foreach(['Base', 'Dev', 'Sys', 'Misc'] as $room): ?>
				<div class="col-xs-12 col-sm-3">
					<h3>Da definire</h3>
					<h4>Di <a href="#">Relatore Da Definire</a></h4>
					<h6>
						<span><i class="fa fa-clock-o"></i>&nbsp;<?= $time ?></span><!--
						--><span><i class="fa fa-map-marker"></i>&nbsp;<a href="#">Aula <?= $room ?></a></span><br>
					</h6>
					<p>Breve descrizione. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ullamcorper eros at semper egestas.</p>
					<p><i class="fa fa-info-circle"></i><a href="#">&nbsp;γνῶθι σαυτόν</a><br><i class="fa fa-calendar"></i><a href="tropical.php?cose=robe" title="Talk da definire">&nbsp;Salva sul calendario</a></p>
				</div>
				<?php endforeach ?>
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
			<div class="col-md-offset-1 col-md-5 col-sm-8">
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
		</div>

		<div class="row">
			<noscript><?= __("Abilita JavaScript per vedere la mappa") ?></noscript>
			<?= $conference->printLocationLeaflet() ?>
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
					<p>La società per cui lavori (o la tua società!) potrebbe avere questo spazio! Hai tempo fino al 30 agosto ore 23:59 per candidarsi.</p>
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
			<p><?= printf(
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

<?php /*
<section id="contact" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-offset-1 col-md-5 col-sm-6">
				<div class="contact_des">
					<h3>New Event</h3>
					<p>Proin sodales convallis urna eu condimentum. Morbi tincidunt augue eros, vitae pretium mi condimentum eget. Suspendisse eu turpis sed elit pretium congue.</p>
					<p>Mauris at tincidunt felis, vitae aliquam magna. Sed aliquam fringilla vestibulum. Praesent ullamcorper mauris fermentum turpis scelerisque rutrum eget eget turpis.</p>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat. Lorem ipsum dolor.</p>
					<a href="#" class="btn btn-danger">DOWNLOAD NOW</a>
				</div>
			</div>

			<div class="col-md-5 col-sm-6">
				<div class="contact_detail">
					<div class="section-title">
						<h2>Keep in touch</h2>
					</div>
					<form action="#" method="post">
						<input name="name" type="text" class="form-control" id="name" placeholder="Name">
					  	<input name="email" type="email" class="form-control" id="email" placeholder="Email">
					  	<textarea name="message" rows="5" class="form-control" id="message" placeholder="Message"></textarea>
						<div class="col-md-6 col-sm-10">
							<input name="submit" type="submit" class="form-control" id="submit" value="SEND">
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</section>

*/ ?>
<?php template( 'footer' );
