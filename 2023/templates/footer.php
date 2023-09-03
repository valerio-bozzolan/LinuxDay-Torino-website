<?php
# Linux Day Torino Website
# Copyright (C) 2016-2023 Valerio Bozzolan, Linux Day Torino website contributors
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

/**
 * This file is the footer of the website.
 */

// Do not allow to visit this file directly to avoid confusing things.
if( !defined( 'ABSPATH' ) ) {
	exit;
}
?>

		<!-- End Wrapper -->
		</div>

			<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					<section>
						<h2><?= __( "Partecipa" ) ?></h2>
						<!-- Contact form... -->
					</section>
					<section>
						<h2><?= __( "Segui l'evento" ) ?></h2>
						<ul class="icons">
							<!-- Social media icons... -->
						</ul>
					</section>
					<ul class="copyright">
						<li>&copy; Linux Day Torino. <?= __( "Alcuni diritti riservati") ?></li>
						<li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				</div>
			</footer>

		</div>

		<!-- Scripts -->
		<script src="<?= CURRENT_CONFERENCE_PATH ?>/assets/js/jquery.min.js"></script>
		<script src="<?= CURRENT_CONFERENCE_PATH ?>/assets/js/browser.min.js"></script>
		<script src="<?= CURRENT_CONFERENCE_PATH ?>/assets/js/breakpoints.min.js"></script>
		<script src="<?= CURRENT_CONFERENCE_PATH ?>/assets/js/util.js"></script>
		<script src="<?= CURRENT_CONFERENCE_PATH ?>/assets/js/main.js"></script>

	</body>
</html><?php
