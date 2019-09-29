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

/*
 * This is the footer of the website
 *
 * Available variables:
 *
 *  $back: when is set, the back button is displayed
 */

// do not visit directly
defined( 'ABSPATH' ) or exit;

?>
<!-- =========================
	FOOTER SECTION
============================== -->

<?php if( isset( $back ) ): ?>
	<div class="container">
		<a class="btn btn-primary" href="<?= keep_url_in_language( CURRENT_CONFERENCE_ROOT . _ ) ?>"><?= __( "Torna al Linux Day Torino" ) ?></a>
	</div>
<?php endif ?>

<footer>
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<p><?= sprintf(
					__( "I contenuti di questo sito sono liberamente fruibili in licenza di contenuto libero %s." ),
					Licenses::instance()->get( 'cc-by-sa-4.0' )->getLink()
				) ?></p>
				<p><?= sprintf(
					__( "Puoi clonare questo design con &hearts; scaricandolo da %s." ),
					'<a href="http://www.templatemo.com/page/1">Templatemo</a>'
				) ?></p>
				<p><?= sprintf(
					__( "Il motore del sito è rilasciato in licenza di software libero %s." ),
					Licenses::instance()->get( 'gnu-agpl' )->getLink()
				) ?></p>
				<p><?= __( "Non si applicano politiche sulla protezione dei tuoi dati in quanto non ti abbiamo trasmesso cookie o altre tecnologie di tracciamento personale." ) ?></p>

				<div class="footer-hack">
					<p><?= __( "Gli Hacker sono i benvenuti su questo sito!" ) ?></p>
<pre>
git clone <?= REPO ?>

cd LinuxDay-Torino-website
vagrant up
</pre>
				</div>

				<ul class="social-icon">
					<li><a href="https://www.facebook.com/LinuxDayTorino/" class="fa fa-facebook"></a></li>
					<li><a href="https://twitter.com/linuxdaytorino" class="fa fa-twitter"></a></li>
				</ul>

			</div>
		</div>
		<div class="row" id="happy-hacking">
			<div class="col-md-12 col-sm-12">
				<p><em>Share your Freedom!</em></p>
			</div>
		</div>
	</div>
</footer>

<!-- =========================
	 SCRIPTS
============================== -->
<script src="<?= CURRENT_CONFERENCE_ROOT ?>/js/jquery.js"></script>
<script src="<?= CURRENT_CONFERENCE_ROOT ?>/js/bootstrap.min.js"></script>
<script src="<?= CURRENT_CONFERENCE_ROOT ?>/js/jquery.parallax.js"></script>
<script src="<?= CURRENT_CONFERENCE_ROOT ?>/js/owl.carousel.min.js"></script>
<script src="<?= CURRENT_CONFERENCE_ROOT ?>/js/smoothscroll.js"></script>
<script src="<?= CURRENT_CONFERENCE_ROOT ?>/js/custom.js"></script>
<script>
jQuery( function(){
	jQuery( '[data-toggle="tooltip"]' ).tooltip();
} );
</script>
</body>
</html>
