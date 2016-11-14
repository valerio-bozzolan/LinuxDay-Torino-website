<?php
# Linux Day 2016 - Single event profile page
# Copyright (C) 2016 Valerio Bozzolan
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

$event = null;
if( isset( $_GET['uid'], $_GET['conference'] ) ) {
	$event = Event::getByConference(
		$_GET['uid'],
		$_GET['conference']
	);
}

$event	|| error_die("Missing event");

$event->hasPermissionToEditevent()
	|| error_die("Can't edit event");

$permalink = CONFERENCE . "/event-edit.php?" . http_build_query( [
	'uid'        => $event->getEventUID(),
	'conference' => $event->getConferenceUID()
] );

if( isset( $_POST['action'] ) ) {
	if( $_POST['action'] === 'add-user' && isset( $_POST['user'] ) ) {
		// Add user

		$user = User::get( $_POST['user'] );
		if( $user ) {
			EventUser::delete($event->getEventID(), $user->getUserID());

			insert_row('event_user', [
				new DBCol('event_ID', $event->getEventID(), 'd'),
				new DBCol('user_ID',  $user->getUserID(),   'd')
			] );
		}
	} elseif( $_POST['action'] === 'update-user' && isset( $_POST['user'] ) ) {
		// Update user order

		$user = User::get( $_POST['user'] );

		if( $user ) {
			if ( ! empty( $_POST['delete'] ) ) {
				// Delete user

				EventUser::delete($event->getEventID(), $user->getUserID());

			} elseif( isset( $_POST['order'] ) ) {
				// Change order

				query_update(
					'event_user',
					new DBCol('event_user_order', $_POST['order'], 'd'),
					sprintf(
						'event_ID = %d AND user_ID = %d',
						$event->getEventID(),
						$user->getUserID()
					)
				);
			}
		}
	}
}

new Header('event', [
	'title' => sprintf(
		_("Modifica %s: %s"),
		$event->getChapterName(),
		$event->getEventTitle()
	),
	'url'   => $event->getEventURL()
] );
?>
	<p><?php echo HTML::a(
		$event->getEventURL(),
		_("Vedi") . icon('account_box', 'left')
	) ?></p>

	<div class="row">
		<div class="col s12 m6">
			<div class="card-panel">
				<h3><?php _e("Aggiungi utente") ?></h3>
				<form action="<?php echo $permalink ?>" method="post">
					<input type="hidden" name="action" value="add-user" />
					<select name="user" class="browser-default">
						<?php $users = query(
							"SELECT user_uid, user_name, user_surname ".
							"FROM {$T('user')} ORDER BY user_name"
						) ?>
						<?php while( $user = $users->fetch_object('User') ): ?>
							<option value="<?php echo $user->getUserUID() ?>">
								<?php echo $user->getUserFullname() ?>
							</option>
						<?php endwhile ?>
					</select>
					<p><button type="submit" class="btn"><?php _e("Aggiungi") ?></button></p>
				</form>
			</div>
		</div>
	</div>

	<?php $users = $event->queryEventUsers('event_user_order') ?>
	<?php if( $users->num_rows ): ?>
	<h2><?php _e("Modifica ordine") ?></h2>
	<div class="row">
		<?php $i = 0 ?>
		<?php while( $user = $users->fetch_object('EventUser') ): ?>
			<?php $i++; ?>
			<div class="col s12 m6">
				<div class="card-panel">
					<div class="row">
					<form action="<?php echo $permalink ?>" method="post">
						<input type="hidden" name="action" value="update-user" />
						<div class="col s12 m6">
							<input type="text" name="user" value="<?php echo $user->getUserUID() ?>" />
						</div>
						<div class="col s12 m6">
							<input type="number" name="order" value="<?php echo $user->getEventUserOrder() ?>" />
						</div>
						<div class="col sq12 m6">
							<input type="checkbox" name="delete" value="yes" id="asd-<?php echo $i ?>" />
							<label for="asd-<?php echo $i ?>"><?php _e("Elimina") ?></label>
						</div>
						<div class="col s12 m6">
							<p><button type="submit" class="btn"><?php _e("Salva") ?></button></p>
						</div>
					</form>
					</div>
				</div>
			</div>
		<?php endwhile ?>
	</div>
	<?php endif ?>

<?php new Footer();
