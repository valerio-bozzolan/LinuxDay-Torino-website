<?php
# Linux Day 2016 - single event profile page
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

$conference = FullConference::factoryFromUID( @ $_GET['conference'] )
	->queryRow();

$conference or die_with_404();

$event = FullEvent::queryByConferenceAndUID(
	$conference->getConferenceID(),
	@ $_GET['uid']
);
$event or die_with_404();

$event->isEventEditable() or error_die("Can't edit event");

$permalink = CURRENT_CONFERENCE_PATH . "/event-edit.php?" . http_build_query( [
	'uid'        => $event->getEventUID(),
	'conference' => $event->getConferenceUID()
] );

if( isset( $_POST['action'] ) ) {
	if( $_POST['action'] === 'add-user' && isset( $_POST['user'] ) ) {
		// Add user

		$user = User::factoryFromUID( $_POST['user'] )
			->select( User::ID )
			->queryRow();

		if( $user ) {
			EventUser::delete($event->getEventID(), $user->getUserID());

			insert_row('event_user', [
				new DBCol( Event::ID, $event->getEventID(), 'd' ),
				new DBCol( User::ID,  $user->getUserID(),   'd' ),
			] );
		}
	} elseif( $_POST['action'] === 'update-user' && isset( $_POST['user'] ) ) {
		// Update user order

		$user = User::factoryFromUID( $_POST['user'] )
			->select( User::ID )
			->queryRow();

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

Header::spawn('event', [
	'title' => sprintf(
		_("Modifica %s: %s"),
		$event->getChapterName(),
		$event->getEventTitle()
	),
	'url' => $event->getEventURL()
] );
?>
	<p><?php echo HTML::a(
		$event->getEventURL( ROOT ),
		_("Vedi") . icon('account_box', 'left')
	) ?></p>

	<div class="row">
		<div class="col s12 m6">
			<div class="card-panel">
				<h3><?php _e("Aggiungi utente") ?></h3>
				<form action="<?php echo $permalink ?>" method="post">
					<input type="hidden" name="action" value="add-user" />
					<select name="user" class="browser-default">
						<?php $users = User::factory()
							->select( [
								User::UID,
								User::NAME,
								User::SURNAME,
							] )
							->orderBy( User::NAME )
							->queryGenerator();
						?>
						<?php foreach( $users as $user ): ?>
							<option value="<?php echo $user->getUserUID() ?>">
								<?php _esc_html( $user->getUserFullname() ) ?>
							</option>
						<?php endforeach ?>
					</select>
					<p><button type="submit" class="btn"><?php _e("Aggiungi") ?></button></p>
				</form>
			</div>
		</div>
	</div>

	<?php $users = $event->factoryUserByEvent()
		->orderBy('event_user_order')
		->query(); ?>
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

<?php

Footer::spawn();
