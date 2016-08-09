<?php
# Linux Day 2016 - User profile page
# Copyright (C) 2016 Valerio Bozzolan, Ludovico Pavesi
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

require 'load.php';

$user = null;

if( isset( $_GET['uid'] ) ) {
	$user = User::queryUser( $_GET['uid'] );
}

if( $user ) {
	the_header('user', [
		'title' => $user->getUserFullname(),
		'url'   => $user->getUserProfileURL()
	] );
} else {
	the_header('404', [
		'not-found' => true
	] );
	error("nott foond a.k.a. erroro quattrociantoquatto. (Eseguire coi permessi di root NON risolve la situazione)");
	the_footer();
	exit;
}
?>
	<div class="row">
		<div class="col s2 m4">
			<img class="responsive-img" src="<?php
				echo 'https://secure.gravatar.com/avatar/' . md5( $user->user_email ) . '?s=56'
			?>" alt="<?php
				_esc_attr( $user->getUserFullname() )
			?>" title="<?php
				_esc_attr( $user->getUserFullname() )
			?> "/>
		</div>
		<div class="col s10 m4">
			<p><?php printf(
				_("Ciao! Sono <strong>%s</strong>."),
				esc_html( $user->getUserFullname() )
			) ?></p>
		</div>

	</div>

	<?php if( $user->user_site ): ?>
	<div class="row">
		<div class="col s12">
			<?php echo HTML::a(
				$user->user_site,
				_("Sito personale") . icon('send', 'right'),
				null,
				'btn'
			) ?>
		</div>
	</div>
	<?php endif ?>
<?php
the_footer();
