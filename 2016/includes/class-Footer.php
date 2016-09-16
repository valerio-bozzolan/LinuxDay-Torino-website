<?php
# Linux Day 2016 - Footer
# Copyright (C) 2016 Valerio Bozzolan
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
	function __construct( $args = [] ) {
		load_module('footer');
?>
<footer class="page-footer teal darken-2">
	<div class="container">
		<div class="row">
			<div class="col s12 m6">
				<h5 class="white-text"><?php echo SITE_NAME ?></h5>
			</div><?php /*
			<div class="col s12 m6">
				<div class="section">
				<h5 class="white-text"><?php _e("Contattaci") ?></h5>
				<table>
					<tr>
						<th class="white-text"><?php _e("E-mail") ?><?php echo icon('email') ?></th>
						<td>
							<code>
								<a class="white-text" href="mailto:<?php echo CONTACT_EMAIL ?>"><?php echo CONTACT_EMAIL ?></a>
							</code>
						</td>
					</tr>
				</table>
				</div>
			</div>
			*/ ?>

		</div>
		<div class="row darken-1 white-text">
			<div class="col s12 m7 l8">
				<p><?php printf(
					_("Tutti i contenuti sono rilasciati sotto ".
					  "licenza di <strong>contenuto culturale libero</strong> %s. ".
					  "Sei libero di distribuire e/o modificare i contenuti ".
					  "anche per scopi commerciali, fintanto che si cita la provenienza e ".
					  "si ricondivide sotto la medesima licenza."
					),
					license('cc-by-sa-4.0')->getLink('yellow-text')
				) ?></p>
			</div>
			<div class="col s12 m5 l4">
				<p><?php
					echo icon('share', 'right');
					printf(
						_("Il sito è distribuito sotto licenza libera %s. Clonalo!"),
						license('gnu-agpl')->getLink('yellow-text')
					);
				?></p>
				<blockquote class="hoverable"><code>git clone https://github.com/0iras0r/ld2016</code></blockquote>
			</div>
			<div class="col s12">
				<p><small><?php
					echo icon('cloud_queue', 'left');
					printf(
						_("Pagina generata in %s secondi con %d query al database."),
						get_page_load(),
						get_num_queries()
					);
				?></small></p>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<p>&copy; <?php echo date('Y') ?> <?php echo SITE_NAME ?> - <?php _e("<b>Alcuni</b> diritti riservati.") ?></p>
		</div>
	</div>
</footer>
<script>
$(document).ready( function () {
	$('.button-collapse').sideNav();
	$('.parallax').parallax();
} );
</script>
</body>
</html>
<!-- <?php _e("Hai notato qualcosa? Non c'è nessun software di tracciamento degli utenti. Non dovremmo vantarcene, dato che dovrebbe essere una cosa normale non regalare i tuoi dati a terzi!") ?> --><?php
	}
}
