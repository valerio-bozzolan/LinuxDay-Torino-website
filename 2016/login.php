<?php
# Linux Day 2016 - Admin login page
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Ludovico Pavesi, Rosario Antoci, Linux Day Torino
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

$status = null;

if( is_action( 'logout' ) ) {
	logout();
}

if( is_action( 'login' ) && isset( $_POST['user_uid'], $_POST['user_password'] ) ) {
	login( $status );
}

switch( $status ) {
	case Session::LOGIN_FAILED:
		error_die("Wrong e-mail or password");
		break;
	case Session::USER_DISABLED:
		error_die("User disabled");
		break;
}

Header::spawn( null, [
	'title' => __( "Login" ),
] );

if( is_logged() ):
?>

	<form method="post" class="card-panel">
		<?php form_action( 'logout' ) ?>
		<p class="flow-text"><?= __("Sei loggato!") ?></p>
		<p>
			<button type="submit" class="btn waves-effect"><?=
				 __( "Sloggati" )
				 .
				 icon('exit_to_app', 'left')
			?></button>
		</p>
	</form>

<?php else: ?>
	<div class="card-panel">
		<form method="post">
			<?php form_action( 'login' ) ?>
			<div class="row">
				<div class="input-field col s12 m6">
					<input name="user_uid" id="user_uid" type="text" class="validate"<?= value( @$_REQUEST['user_uid'] ) ?> />
					<label for="user_uid"><?= __("Nome utente") ?></label>
				</div>
				<div class="input-field col s12 m6">
					<input name="user_password" id="user_password" type="password" class="validate" />
					<label for="user_password"><?= __("Password") ?></label>
				</div>
			</div>
			<div class="col s12">
				<p><button class="btn waves-effect purple" type="submit">
					<?= __("Accedi") ?>
					<?= icon() ?>
				</button></p>
			</div>
		</form>
	</div>
<?php
endif;

Footer::spawn();
