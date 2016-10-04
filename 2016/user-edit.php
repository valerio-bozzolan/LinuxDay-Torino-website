<?php
# Linux Day 2016 - Single user profile page
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
	$user = User::getUser( $_REQUEST['uid'] );
}

$user	|| error_die("Missing user");

$user->hasPermissionToEditUser()
	|| error_die("Can't edit user");

if( isset( $_POST['action'], $_POST['skill_uid'], $_POST['skill_score'] ) ) {
	$skill = Skill::getSkill( $_POST['skill_uid'] );

	$skill || error_die( sprintf(
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
			$skill = Skill::getSkill( $_POST['skill_uid'] );

			insert_row('user_skill', [
				new DBCol('user_ID',     $user->getUserID(),    'd'),
				new DBCol('skill_ID',    $skill->getSkillID(),  'd'),
				new DBCol('skill_score', $_POST['skill_score'], 'd')
			] );
			break;
	}
}

new Header('user', [
	'title' => $user->getUserFullname(),
	'url'   => $user->getUserURL(),
	'og'    => [
		'image' => $user->getUserImage(),
		'type'  => 'profile',
		'profile:first_name' => $user->user_name,
		'profile:last_name'  => $user->user_surname
	]
] );
?>
	<p><?php echo HTML::a(
		$user->getUserURL(),
		_("Vedi") . icon('account_box', 'left')
	) ?></p>

	<h3><?php _e("Aggiungi skill") ?></h3>
	<p class="red flow-text">Se stai pensando di aggiungere skill già associate a questo utente... sei avvertito/a :3</p>
	<div class="row">
		<div class="col s12 m4">
			<div class="card-panel">
				<form method="post">
					<input type="hidden" name="action" value="add-skill" />
					<input type="hidden" name="uid" value="<?php echo $user->getUserUID() ?>" />
					<div class="row">
						<div class="col s6">
							<select name="skill_uid" class="browser-default">
								<?php $skills = query("SELECT * FROM {$T('skill')} ORDER BY skill_uid") ?>
								<?php if($skills->num_rows): ?>
									<?php while($skill = $skills->fetch_object('Skill') ): ?>
										<option value="<?php echo $skill->getSkillUID() ?>"><?php _esc_html( $skill->skill_title ) ?></option>
									<?php endwhile ?>
								<?php endif ?>
							</select>
						</div>
						<div class="col s6">
							<input type="text" name="skill_score" value="0" />
						</div>
						<div class="col s6">
							<button type="submit"><?php _e("Applica") ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<h3><?php _e("Modifica skill") ?></h3>
	<?php $skills = $user->queryUserSkills(); ?>
	<?php if( $skills->num_rows ): ?>
		<div class="row">
		<?php $i = 0; ?>
		<?php while( $skill = $skills->fetch_object('Skill') ): ?>
			<div class="col s12 m4">
				<div class="card-panel">
					<form method="post">
						<input type="hidden" name="action" value="change-skill" />
						<input type="hidden" name="uid" value="<?php echo $user->getUserUID() ?>" />
						<div class="row">
							<div class="col s6">
								<input type="text" name="skill_uid" value="<?php echo $skill->skill_uid ?>" />
							</div>
							<div class="col s6">
								<input type="text" name="skill_score" value="<?php echo $skill->skill_score ?>" />
							</div>
							<div class="col s6">
								<input type="checkbox" name="skill_delete" value="yes" id="skill-<?php echo $i ?>" />
								<label for="skill-<?php echo $i++ ?>"><?php _e("Elimina") ?></label>
							</div>
							<div class="col s6">
								<button type="submit"><?php _e("Applica") ?></button>
							</div>
							<div class="col s12">
								<p><?php echo $skill->getSkillPhrase() ?></p>
							</div>
						</div>
					</form>
				</div>
			</div>
		<?php endwhile ?>
		</div>
	<?php endif ?>
</form>

<?php new Footer();
