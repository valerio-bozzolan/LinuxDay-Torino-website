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
		<a class="btn green darken-3 waves-effect" href="<?php echo URL ?>/">
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

<footer class="page-footer grey lighten-4">
	<div class="container">
		<div class="row">
			<div class="col s12 m7 l8">
				<h5 class="black-text"><code>#LDTO17</code></h5>
				<p class="black-text"><?php printf(
					__("Tutti i contenuti sono rilasciati sotto ".
					  "licenza di <strong>contenuto culturale libero</strong> %s. ".
					  "Sei libero di distribuire e/o modificare i contenuti ".
					  "anche per scopi commerciali, fintanto che si cita la provenienza e ".
					  "si ricondivide sotto la medesima licenza."
					),
					license('cc-by-sa-4.0')->getLink('green-text')
				) ?></p>
				<p class="black-text"><?php printf(
					__("Contattare all'indirizzo %s o al numero %s."),
					HTML::a('mailto:' . CONTACT_EMAIL, CONTACT_EMAIL, null, 'hoverable green-text'),
					HTML::a('tel:+39' . CONTACT_PHONE, CONTACT_PHONE, null, 'hoverable green-text', 'target="_blank"')
				) ?></p>
				<p class="ld-social valign-wrapper">
					<a class="hoverable" href="https://facebook.com/LinuxDayTorino" target="_blank" title="<?php printf(
						__("%s su Facebook"),
						SITE_NAME
					) ?>">
						<img src="<?php echo STATIC_PATH ?>/social/facebook.png" height="32" alt="Facebook" />
					</a>

					<a class="hoverable" href="https://twitter.com/LinuxDayTorino" target="_blank" title="<?php printf(
						__("%s su Twitter"),
						SITE_NAME
					) ?>">
						<img src="<?php echo STATIC_PATH ?>/social/twitter.png" height="32" alt="Twitter" class="circle" />
					</a>

					<?php echo HTML::a(
						'https://blog.linuxdaytorino.org',
						icon('rss_feed', 'ld-blog-icon'),
						__("Blog del Linux Day Torino"),
						'btn-floating waves-effect waves-green ld-blog',
						'target="_blank"'
					) ?>
				</p>
			</div>
			<div class="col s12 m5 l4">
				<h5 class="black-text"><?php _e("Edizioni Passate") ?></h5>
				<ul>
					<?php $ld = function($year, $where) { ?>
					<li><?php echo HTML::a(
						"/$year/",
						"$year, $where",
						sprintf(
							"Linux Day %d %s",
							$year,
							$where
						),
						'hoverable ld-text'
					) ?></li>
					<?php };

					$ld(2016, __("Dipartimento di Informatica") );
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

			</div>
		</div>
	</div>
</footer>
<script>
$( function () {
	$( '.button-collapse' ).sideNav();
	$( '.parallax' ).parallax();
} );
</script>
</body>
</html><?php } }
