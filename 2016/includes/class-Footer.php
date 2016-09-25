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
<footer class="page-footer <?php echo BACK ?>">
	<div class="container">
		<div class="row">
			<div class="col s12 m6">
				<h5 class="white-text"><code>#LDTO2016</code></h5>
			</div>
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
				<h5 class="white-text">Edizioni Passate</h5>
				<ul>
					<li><a class="grey-text text-lighten-3" href="http://linuxdaytorino.org/2015">2015, Dipartimento di Biotecnologie</a></li>
					<li><a class="grey-text text-lighten-3" href="http://linuxdaytorino.org/2014">2014, Politecnico di Torino</a></li>
					<li><a class="grey-text text-lighten-3" href="http://linuxdaytorino.org/2013">2013, Politecnico di Torino</a></li>
					<li><a class="grey-text text-lighten-3" href="http://linuxdaytorino.org/2012">2012, Cortile del Maglio</a></li>
					<li><a class="grey-text text-lighten-3" href="http://linuxdaytorino.org/2011">2011, Cascina Roccafranca</a></li>
					<li><a class="grey-text text-lighten-3" href="http://linuxdaytorino.org/2010">2010, Cascina Roccafranca</a></li>
					<li><a class="grey-text text-lighten-3" href="http://linuxdaytorino.org/2009">2009, Cascina Roccafranca</a></li>
					<li><a class="grey-text text-lighten-3" href="http://linuxdaytorino.org/2008">2008, Cascina Roccafranca</a></li>
					<li><a class="grey-text text-lighten-3" href="http://linuxdaytorino.org/2007">2007, Cascina Rocccafranca</a></li>
				</ul>
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
