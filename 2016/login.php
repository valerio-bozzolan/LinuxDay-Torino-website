<?php
# Linux Day 2016 - Admin login page
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Ludovico Pavesi, Rosario Antoci, Linux Day Torino
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

isset($_GET['logout'])
	and logout();

isset( $_POST['user_uid'], $_POST['user_password'] )
	and login($status);

switch($status) {
	case Session::LOGIN_FAILED:
		error_die("Wrong e-mail or password");
		break;
	case Session::USER_DISABLED:
		error_die("User disabled");
		break;
}

Header::spawn('home');

if( is_logged() ):
?>
	<p class="flow-text"><?php _e("Sei loggato!") ?></p>
	<p><?php echo HTML::a(
		CURRENT_CONFERENCE_PATH . '/login.php?logout',
		_("Sloggati") . icon('exit_to_app', 'left')
	) ?></p>

<?php else: ?>
	<div class="card-panel">
		<form method="post">
			<div class="row">
				<div class="input-field col s12 m6">
					<input name="user_uid" id="user_uid" type="text" class="validate"<?php
						echo HTML::property('value', @$_REQUEST['user_uid'] )
					?> />
					<label for="user_uid"><?php _e("E-mail") ?></label>
				</div>
				<div class="input-field col s12 m6">
					<input name="user_password" id="user_password" type="password" class="validate" />
					<label for="user_password"><?php _esc_attr( _("Password") ) ?></label>
				</div>
			</div>
			<div class="col s12">
				<p><button class="btn waves-effect purple" type="submit" name="action">
					<?php _e("Accedi") ?>
					<?php echo icon() ?>
				</button></p>
			</div>
		</form>
	</div>
<?php
endif;

Footer::spawn();
