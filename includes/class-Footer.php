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

<footer class="page-footer blue darken-2">
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
			<p><?php printf(
				_("Tutti i contenuti sono rilasciati sotto ".
				  "licenza di <strong>contenuto culturalmente libero</strong> %s. ".
				  "Sei libero di distribuire e/o modificare i contenuti ".
				  "anche per scopi commerciali, fintanto che si cita la provenienza e ".
				  "si ricondivide sotto la medesima licenza."
				),
				HTML::a(
					_('https://creativecommons.org/licenses/by-sa/4.0/deed.it'),
					"CC By-Sa 4.0",
					_("Creative Commons Attribuzione - Condividi allo stesso modo 4.0 Internazionale"),
					'yellow-text'
				)
			) ?></p>
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
	$(".button-collapse").sideNav();
} );
</script>
</body>
</html>
<!-- <?php _e("Hai notato qualcosa? Non c'è nessun software di tracciamento degli utenti. Non dovremmo vantarcene, dato che dovrebbe essere una cosa normale non regalare i tuoi dati a terzi!") ?> -->
<!-- <?php printf(
		_("Pagina generata in %s secondi con %d query al database."),
		get_page_load(),
		get_num_queries()
	) ?> --><?php
	}
}
