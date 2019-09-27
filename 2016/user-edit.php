<?php
# Linux Day 2016 - single user edit page
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Linux Day Torino
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
	$user = User::factoryFromUID( @ $_GET['uid'] )
		->queryRow();

	if( !$user ) {
		die( "not found" );
	}

	if( !$user->hasPermissionToEditUser() ) {
		error_die( "Can't edit user" );
	}

} else {

	if( !has_permission( 'edit-users' ) ) {
		error_die( "Can't create user" );
	}

}

// register form submit action
if( is_action( 'save-user' ) ) {

	// avoid spaces
	if( $_POST['email'] ) {
		$_POST['email'] = luser_input( $_POST['email'], 32 );
	}

	// generate Gravatar
	if( $_POST['email'] ) {
		$_POST['gravatar'] = md5( $_POST['email'] );
	}

	// prepare data sent via POST
	$data = [];
	$data[] = new DBCol( User::NAME,          $_POST['name'],     's' );
	$data[] = new DBCol( User::SURNAME,       $_POST['surname'],  's' );
	$data[] = new DBCol( User::UID,           $_POST['uid'],      's' );
	$data[] = new DBCol( User::EMAIL,         $_POST['email'],    'snull' );
	$data[] = new DBCol( User::WEBSITE,       $_POST['site'],     'snull' );
	$data[] = new DBCol( User::GRAVATAR,      $_POST['gravatar'], 'snull' );
	$data[] = new DBCol( User::LOVED_LICENSE, $_POST['lovelicense'], 'snull' );

	// promote empty strings to null
	foreach( $data as $row ) {
		$row->promoteNULL();
	}

	if( $user ) {
		// update existing user
		User::factoryByID( $user->getUserID() )
			->update( $data );
	} else {
		// insert a new User
		User::factory()
			->insertRow( $data );
	}

	$id = $user
		? $user->getUserID()
		: last_inserted_ID();

	$user = User::factoryByID( $id )
		->queryRow();

	// POST -> redirect -> GET
	http_redirect( $user->getUserEditURL(), 302 );

}

if( isset( $_POST['action'], $_POST['skill_uid'], $_POST['skill_score'] ) ) {
	$skill = Skill::factoryFromUID( $_POST['skill_uid'] )
		->queryRow();

	$skill or error_die( sprintf(
		"Skill '%s' not found",
		esc_html( $_POST['skill_uid'] )
	) );

	if( is_action( 'change-skill' ) ) {
		if( isset( $_POST['skill_delete'] ) ) {
			// Delete skill checked
			query( sprintf(
				"DELETE FROM {$T('user_skill')} WHERE user_ID = %d AND skill_ID = %d",
				$user->getUserID(),
				$skill->getSkillID()
			) );
		} else {
			// Update skill elsewhere
			query_update('user_skill',
				new DBCol('skill_score', $_POST['skill_score'], 'd' ),
				sprintf(
					'skill_ID = %d',
					$skill->getSkillID()
				)
			);
		}
	}

	if( is_action( 'add-skill' ) ) {

		$skill = Skill::factoryFromUID( $_POST['skill_uid'] )
			->queryRow();

		// If exists, delete it
		query( sprintf(
			"DELETE FROM {$T('user_skill')} WHERE user_ID = %d AND skill_ID = %d",
			$user->getUserID(),
			$skill->getSkillID()
		) );

		insert_row('user_skill', [
			new DBCol('user_ID',     $user->getUserID(),    'd'),
			new DBCol('skill_ID',    $skill->getSkillID(),  'd'),
			new DBCol('skill_score', $_POST['skill_score'], 'd'),
		] );
	}

}

// register action to delete the user
if( $user && is_action( 'delete-user' ) ) {

	// delete the user from the database
	User::factory()
		->whereInt( 'user_ID', $user->getUserID() )
		->delete();

	// POST -> redirect -> GET
	http_redirect( $user->getUserEditURL(), 302 );
}

Header::spawn('user', [
	'title' =>
		$user
			? sprintf(
			  	__("Modifica utente %s"),
			  	$user->getUserFullname()
			  )
			: __( "Aggiungi Utente" )
	,
	'url' => $user ? $user->getUserURL() : null,
] );
?>

	<?php if( $user ): ?>
		<p><?= HTML::a(
			$user->getUserURL(),
			__( "Vedi" ) . icon('account_box', 'left')
		) ?></p>
	<?php endif ?>

	<form method="post">
		<?php form_action( 'save-user' ) ?>
		<div class="row">

			<!-- name -->
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<div class="input-field">
						<label for="user-name"><?= __( "Nome" ) ?></label>
						<input type="text" name="name" id="user-name"<?=
							$user
								? value( $user->get( User::NAME ) )
								: ''
						?> />
					</div>
				</div>
			</div>
			<!-- /name -->

			<!-- surname -->
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<div class="input-field">
						<label for="user-surname"><?= __( "Cognome" ) ?></label>
						<input type="text" name="surname" id="user-surname"<?=
							$user
								? value( $user->get( User::SURNAME ) )
								: ''
						?> />
					</div>
				</div>
			</div>
			<!-- /surname -->

			<!-- nickname -->
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<div class="input-field">
						<label for="user-nickname"><?= __( "Nickname" ) ?></label>
						<input type="text" name="uid" id="user-nickname"<?=
							$user
								? value( $user->getUserUID() )
								: ''
						?> />
					</div>
				</div>
			</div>
			<!-- /surname -->

			<!-- e-mail -->
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<div class="input-field">
						<label for="user-email"><?= __( "E-mail" ) ?></label>
						<input type="text" name="email" id="user-email"<?=
							$user
								? value( $user->getUserEmail() )
								: ''
						?> />
					</div>
				</div>
			</div>
			<!-- /e-mail -->

			<!-- gravatar -->
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<div class="input-field">
						<label for="user-gravatar"><?= __( "Gravatar" ) ?></label>
						<input type="text" name="gravatar" id="user-gravatar"<?=
							$user && $user->hasUserGravatar()
								? value( $user->getUserGravatarUID() )
								: ''
						?> />
					</div>
				</div>
			</div>
			<!-- /gravatar -->

			<!-- website -->
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<div class="input-field">
						<label for="user-website"><?= __( "Sito web" ) ?></label>
						<input type="text" name="website" id="user-website"<?=
							$user
								? value( $user->get( User::WEBSITE ) )
								: ''
						?> />
					</div>
				</div>
			</div>
			<!-- /website -->

			<!-- license -->
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<label><?= __( "Licenza preferita" ) ?></label>
					<select name="lovelicense">
						<option value=""<?= selected( $user && !$user->hasUserLovelicense() ) ?>><?= __( "Nessuna" ) ?></option>
						<?php foreach( Licenses::instance()->all() as $license ): ?>
							<option<?php
								// option value
								echo value( $license->getCode() );

								// option selected or not
								if( $user ) {
									echo selected( $license->getCode(), $user->get( 'user_lovelicense' ) );
								}

							?>><?= esc_html( $license->getShort() ) ?></option>
						<?php endforeach ?>
					</select>

					<?php
						if( $user && $user->hasUserLovelicense() ) {
							echo $user->getUserLovelicense()->getLink();
						}
					?>
				</div>
			</div>
			<!-- /license -->

		</div>
		<button type="submit" class="btn"><?= __( "Salva" ) ?></button>
	</form>

	<?php if( $user ): ?>
		<h3><?php printf(
			__( "Aggiungi %s"),
			__( "Skill" )
		) ?></h3>
		<div class="row">
			<div class="col s12 m4">
				<div class="card-panel">
					<form method="post">
						<?php form_action( 'add-skill' ) ?>
						<input type="hidden" name="uid" value="<?= $user->getUserUID() ?>" />
						<div class="row">
							<div class="col s6">
								<select name="skill_uid" class="browser-default" required="required">
									<?php $skills = Skill::factory()
										->orderBy('skill_uid')
										->queryGenerator();
									?>
									<option name="" selected="" value="" disabled="disabled"></option>
									<?php foreach( $skills as $skill ): ?>
										<option value="<?= $skill->getSkillUID() ?>"><?= esc_html( $skill->getSkillUID() ) ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="col s6">
								<input type="text" name="skill_score" value="0" />
							</div>
							<div class="col s6">
								<button type="submit" class="btn"><?= __("Aggiungi") ?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php endif ?>

	<?php if( $user ): ?>
		<?php $skills = $user->factoryUserSkills()
			->queryGenerator();
		?>
		<?php if( $skills->valid() ): ?>
			<h3><?php printf(
				__( "Modifica %s" ),
				__( "Skill" )
			) ?></h3>
			<div class="row">
				<?php $i = 0; ?>
				<?php foreach( $skills as $skill ): ?>
					<div class="col s12 m4">
						<div class="card-panel">
							<form method="post">
								<?php form_action( 'change-skill' ) ?>
								<input type="hidden" name="uid" value="<?= $user->getUserUID() ?>" />
								<div class="row">
									<div class="col s6">
										<input type="text" name="skill_uid" value="<?= $skill->getSkillUID() ?>" />
									</div>
									<div class="col s6">
										<input type="text" name="skill_score" value="<?= $skill->getSkillScore() ?>" />
									</div>
									<div class="col s6">
										<input type="checkbox" name="skill_delete" value="yes" id="skill-<?= $i ?>" />
										<label for="skill-<?= $i++ ?>"><?= __("Elimina") ?></label>
									</div>
									<div class="col s6">
										<button type="submit" class="btn"><?= __("Salva") ?></button>
									</div>
									<div class="col s12">
										<p><?= $skill->getSkillPhrase() ?></p>
									</div>
								</div>
							</form>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		<?php endif ?>
	<?php endif ?>

	<!-- delete -->
	<?php if( $user ): ?>
		<div class="row">
			<div class="col s12">
				<form method="post">
					<?php form_action( 'delete-user' ) ?>
					<button type="submit" class="btn waves-effect red right"><?= __( "Elimina" ) ?></button>
				</form>
			</div>
		</div>
	<?php endif ?>
	<!-- /delete -->
<?php

Footer::spawn();
