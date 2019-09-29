<?php
# Linux Day 2016 - Footer
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Rosario Antoci, Linux Day Torino
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

class Footer {
	static function spawn( $args = [] ) {

		$args = array_replace( [
			'home' => true
		], $args );
?>


	<?php if( $args['home'] ): ?>
	<div class="divider"></div>
	<div class="section">
		<a class="btn purple darken-3 waves-effect" href="<?= keep_url_in_language( CURRENT_CONFERENCE_PATH . _ ) ?>">
			<?php
				printf(
					__("Torna a %s"),
					SITE_NAME
				);
				echo icon('home', 'right');
			?>
		</a>
	</div>
	<?php endif ?>

<?php load_module('footer') ?>

<footer class="page-footer <?= BACK ?>">
	<div class="container">
		<div class="row">
			<div class="col s12 m7 l8">
				<h5 class="white-text"><code>#LDTO2016</code></h5>
				<p class="white-text"><?php printf(
					__("Tutti i contenuti sono rilasciati sotto ".
					  "licenza di <strong>contenuto culturale libero</strong> %s. ".
					  "Sei libero di distribuire e/o modificare i contenuti ".
					  "anche per scopi commerciali, fintanto che si cita la provenienza e ".
					  "si ricondivide sotto la medesima licenza."
					),
					license('cc-by-sa-4.0')->getLink('yellow-text')
				) ?></p>
				<p class="white-text"><?php printf(
					__("Contattare all'indirizzo %s o al numero %s."),
					HTML::a('mailto:'                     . CONTACT_EMAIL, CONTACT_EMAIL, null, 'white-text hoverable'),
					HTML::a('tel:' . CONTACT_PHONE_PREFIX . CONTACT_PHONE, CONTACT_PHONE, null, 'white-text hoverable', 'target="_blank"')
				) ?></p>
				<p class="ld-social valign-wrapper">
					<a class="hoverable" href="https://facebook.com/LinuxDayTorino" target="_blank" title="<?php printf(
						__("%s su Facebook"),
						SITE_NAME
					) ?>">
						<img src="<?= STATIC_PATH ?>/social/facebook.png" height="32" alt="Facebook" />
					</a>

					<a class="hoverable" href="https://twitter.com/LinuxDayTorino" target="_blank" title="<?php printf(
						__("%s su Twitter"),
						SITE_NAME
					) ?>">
						<img src="<?= STATIC_PATH ?>/social/twitter.png" height="32" alt="Twitter" class="circle white" />
					</a>

					<?= HTML::a(
						'https://blog.linuxdaytorino.org',
						icon('rss_feed', 'purple-text text-darken-3 ld-blog-icon'),
						__("Blog del Linux Day Torino"),
						'btn-floating waves-effect waves-purple white purple-text ld-blog',
						'target="_blank"'
					) ?>
				</p>
			</div>
			<div class="col s12 m5 l4">
				<h5 class="white-text"><?= __("Edizioni Passate") ?></h5>
				<ul>
					<?php $ld = function($year, $where) { ?>
					<li><?= HTML::a(
						"/$year/",
						"$year, $where",
						sprintf(
							"Linux Day %d %s",
							$year,
							$where
						),
						'grey-text text-lighten-3 hoverable'
					) ?></li>
					<?php };

					$ld(2015, __("Dipartimento di Biotecnologie")  );
					$ld(2014, __("Politecnico di Torino")  );
					$ld(2013, __("Politecnico di Torino")  );
					$ld(2012, __("Cortile del Maglio")  );

					// You want to fight about this?
					for($year=2011; $year>2006; $year--) {
						$ld($year, __("Cascina Roccafranca")  );
					}
					?>
				</ul>

				<h5 class="white-text"><?= __( "Lingua" ) ?></h5>
				<form method="get">
					<select name="l">
						<?php foreach( all_languages() as $l ): ?>
							<option value="<?= $l->getISO() ?>"<?= selected( $l, latest_language() ) ?>><?= $l->getHuman() ?></option>
						<?php endforeach ?>
					</select>
					<button type="submit" class="btn waves-effect"><?= __( "Scegli" ) ?></button>
				</form>
			</div>
		</div>
		<div class="row darken-1 white-text">
			<div class="col s12">
				<p><small><?php
					echo icon('cloud_queue', 'left');
					printf(
						__("Pagina generata in %s secondi con %d query al database."),
						get_page_load(),
						get_num_queries()
					);
				?></small></p>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - <?= __("<b>Alcuni</b> diritti riservati.") ?></p>
		</div>
	</div>
</footer>
<script>
$( function () {
	$( '.button-collapse' ).sideNav();
	$( '.parallax' ).parallax();
	$( 'select' ).material_select();
} );
</script>
</body>
</html>
<!-- <?= __("Hai notato qualcosa? Non c'è nessun software di tracciamento degli utenti. Non dovremmo vantarcene, dato che dovrebbe essere una cosa normale non regalare i tuoi dati a terzi!") ?> --><?php
	}
}
