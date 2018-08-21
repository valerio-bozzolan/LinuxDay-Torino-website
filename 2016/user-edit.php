<?php
# Linux Day 2016 - single user edit page
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Linux Day Torino
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

$user = User::factoryFromUID( @ $_GET['uid'] )
	->select( [
		User::T . DOT . User::ID,
		User::UID,
		User::NAME,
		User::SURNAME,
		User::ROLE,
	] )
	->queryRow();

$user or error_die("Missing user");

$user->hasPermissionToEditUser() or error_die("Can't edit user");

if( isset( $_POST['action'], $_POST['skill_uid'], $_POST['skill_score'] ) ) {
	$skill = Skill::factoryFromUID( $_POST['skill_uid'] )
		->queryRow();

	$skill or error_die( sprintf(
		"Skill '%s' not found",
		esc_html( $_POST['skill_uid'] )
	) );

	// That's a crap!
	switch( $_POST['action'] ) {
		case 'change-skill':
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
			break;

		case 'add-skill':
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
				new DBCol('skill_score', $_POST['skill_score'], 'd')
			] );
			break;
	}
}

Header::spawn('user', [
	'title' => sprintf(
		_("Modifica utente %s"),
		$user->getUserFullname()
	),
	'url' => $user->getUserURL(),
] );
?>
	<p><?php echo HTML::a(
		$user->getUserURL(),
		_("Vedi") . icon('account_box', 'left')
	) ?></p>

	<h3><?php _e("Aggiungi skill") ?></h3>
	<div class="row">
		<div class="col s12 m4">
			<div class="card-panel">
				<form method="post">
					<input type="hidden" name="action" value="add-skill" />
					<input type="hidden" name="uid" value="<?php echo $user->getUserUID() ?>" />
					<div class="row">
						<div class="col s6">
							<select name="skill_uid" class="browser-default">
								<?php $skills = Skill::factory()
									->orderBy('skill_uid')
									->queryGenerator();
								?>
								<?php foreach( $skills as $skill ): ?>
									<option value="<?php echo $skill->getSkillUID() ?>"><?php _esc_html( $skill->getSkillUID() ) ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="col s6">
							<input type="text" name="skill_score" value="0" />
						</div>
						<div class="col s6">
							<button type="submit" class="btn"><?php _e("Aggiungi") ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<h3><?php _e("Modifica skill") ?></h3>
	<?php $skills = $user->factoryUserSkills()
		->queryGenerator();
	?>
	<?php if( $skills->valid() ): ?>
		<div class="row">
		<?php $i = 0; ?>
		<?php foreach( $skills as $skill ): ?>
			<div class="col s12 m4">
				<div class="card-panel">
					<form method="post">
						<input type="hidden" name="action" value="change-skill" />
						<input type="hidden" name="uid" value="<?php echo $user->getUserUID() ?>" />
						<div class="row">
							<div class="col s6">
								<input type="text" name="skill_uid" value="<?php echo $skill->getSkillUID() ?>" />
							</div>
							<div class="col s6">
								<input type="text" name="skill_score" value="<?php echo $skill->getSkillScore() ?>" />
							</div>
							<div class="col s6">
								<input type="checkbox" name="skill_delete" value="yes" id="skill-<?php echo $i ?>" />
								<label for="skill-<?php echo $i++ ?>"><?php _e("Elimina") ?></label>
							</div>
							<div class="col s6">
								<button type="submit" class="btn"><?php _e("Salva") ?></button>
							</div>
							<div class="col s12">
								<p><?php echo $skill->getSkillPhrase() ?></p>
							</div>
						</div>
					</form>
				</div>
			</div>
		<?php endforeach ?>
		</div>
	<?php endif ?>
</form>

<?php

Footer::spawn();
