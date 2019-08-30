<?php
# Linux Day 2016 - single event profile page
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Linux Day Torino
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.

require 'load.php';

// inherit the Conference or specify one
$conference_uid = CURRENT_CONFERENCE_UID;
if( isset( $_REQUEST['conference'] ) ) {
	$conference_uid = $_REQUEST['conference'];
}

// check if the Conference exists
$conference = FullConference::factoryFromUID( $conference_uid )
	->queryRow();

if( !$conference ) {
	die_with_404();
}

// retrieve the Event (if existing)
$event = null;
if( isset( $_GET['uid'] ) ) {
	$event = FullEvent::queryByConferenceAndUID(
		$conference->getConferenceID(),
		$_GET['uid']
	);

	if( !$event ) {
		die_with_404();
	}

	if( !$event->isEventEditable() ) {
		error_die("Can't edit event");
	}
} else {
	// check if there are permissions to add event
	if( !has_permission( 'add-event' ) ) {
		die( 'missing permissions' );
	}
}

if( $_POST ) {

	if( $event ) {

		/*
		 *
		 */
		if( is_action( 'save-event' ) ) {

			$data = [];
			$data[] = new DBCol( Event::TITLE,       $_POST['title'],       's'  );
			$data[] = new DBCol( Event::LANGUAGE,    $_POST['language'],    's'  );
			$data[] = new DBCol( Event::SUBTITLE,    $_POST['subtitle'],    's'  );
			$data[] = new DBCol( Event::ABSTRACT,    $_POST['abstract'],    's'  );
			$data[] = new DBCol( Event::DESCRIPTION, $_POST['description'], 's'  );
			$data[] = new DBCol( Event::START,       $_POST['start'],       's'  );
			$data[] = new DBCol( Event::END,         $_POST['end'],         's'  );
			$data[] = new DBCol( Event::IMAGE,       $_POST['image'],       's'  );
			$data[] = new DBCol( Chapter::ID,        $_POST['chapter'],     'd'  );
			$data[] = new DBCol( Room::ID,           $_POST['room'],        'd'  );
			$data[] = new DBCol( Track::ID,          $_POST['track'],       'd'  );

			if( $event ) {
				Event::factory()
					->whereInt( Event::ID, $event->getEventID() )
					->update( $data );
			} else {
				Event::factory()
					->insert( $data );

				$id = last_inserted_ID();
				$event = FullEvent::factoryFromID( $id );
				http_redirect( $event->getFullEventEditURL(), 303 );
			}
		}

		/*
		 * Add the user
		 */
		if( is_action( 'add-user' ) && isset( $_POST['user'] ) ) {
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
		}

		/**
		 * Update an user order
		 */
		if( is_action( 'update-user' ) && isset( $_POST['user'] ) ) {

			$user = User::factoryFromUID( $_POST['user'] )
				->select( User::ID )
				->queryRow();

			if( $user ) {
				if ( !empty( $_POST['delete'] ) ) {
					// Delete user

					EventUser::delete( $event->getEventID(), $user->getUserID() );

				} elseif( isset( $_POST['order'] ) ) {

					// change order
					EventUser::factory()
						->whereInt( Event::ID, $event->getEventID() )
						->whereInt( User ::ID, $user->getUserID()   )
						->update( [
							new DBCol( EventUser::ORDER, $_POST['order'], 'd')
						] );
				}
			}
		}
	}

	// post -> redirect -> get
	http_redirect( $_SERVER[ 'REQUEST_URI' ] );
}

if( $event ) {
	Header::spawn( 'event', [
		'title' => sprintf(
			__("Modifica %s: %s"),
			$event->getChapterName(),
			$event->getEventTitle()
		),
		'url' => $event->getEventURL()
	] );
} else {
	Header::spawn( 'event', [
		'title' => sprintf(
			__( "Aggiungi %s" ),
			__( "Evento" )
		),
	] );
}

?>

	<?php if( $event ): ?>
		<p><?= HTML::a(
			$event->getEventURL(),
			__("Vedi") . icon('account_box', 'left')
		) ?></p>
	<?php endif ?>

	<form method="post">
		<?php form_action( 'save-event' ) ?>

		<div class="row">

			<div class="col s12 m4 l3">
				<div class="card-panel">
					<label for="event-title"><?= __( "Titolo" ) ?></label>
					<input type="text" name="title" id="event-title" required<?php
						if( $event ) {
							echo value( $event->get( Event::TITLE ) );
						}
					?> />
				</div>
			</div>

			<div class="col s12 m4 l3">
				<div class="card-panel">
					<label for="event-subtitle"><?= __( "Sottotitolo" ) ?></label>
					<input type="text" name="subtitle" id="event-subtitle"<?php
						if( $event ) {
							echo value( $event->get( Event::SUBTITLE ) );
						}
					?> />
				</div>
			</div>

			<div class="col s12 m4 l3">
				<div class="card-panel">
					<label for="event-language"><?= __( "Lingua" ) ?></label>
					<input type="text" name="language" id="event-language" maxlenght="2"<?php
						if( $event ) {
							echo value( $event->get( Event::LANGUAGE ) );
						}
					?> />
				</div>
			</div>

		</div>

		<div class="row">

			<!-- chapters -->
			<div class="col s12 m4 l3">
				<div class="card-panel">
					<label for="chapter"><?= __( "Capitolo" ) ?></label>
					<select name="chapter">
						<?php
							// get every chapter
							$chapters =
								Chapter::factory()
									->orderBy( Chapter::NAME )
									->queryGenerator();

							// generate select options
							foreach( $chapters as $chapter ) {
								$option = ( new HTML( 'option' ) )
									->setText( esc_html( $chapter->getChapterName() ) )
									->setAttr( 'value', $chapter->getChapterID() );

								// eventually select this chapter
								$selected = false;
								if( $event ) {
									$selected = $event->getChapterID() === $chapter->getChapterID();
								} elseif( isset( $_GET['chapter'] ) ) {
									$selected = $_GET['chapter'] === $chapter->getChapterUID();
								}

								if( $selected ) {
										$option->setAttr( 'selected', 'selected' );
								}

								echo $option->render();
							}
						?>
					</select>
				</div>
			</div>
			<!-- /chapters -->

			<!-- tracks -->
			<div class="col s12 m4 l3">
				<div class="card-panel">
					<label for="track"><?= __( "Traccia" ) ?></label>
					<select name="track">
						<?php
							// select all the available tracks for this Location
							$tracks =
								Track::factory()
									->orderBy( Track::NAME )
									->queryGenerator();

							// generate a select option for each track
							foreach( $tracks as $track ) {
								$option = ( new HTML( 'option' ) )
									->setText( esc_html( $track->getTrackName() ) )
									->setAttr( 'value', $track->getTrackID() );

								// eventually auto-select this track
								$selected = false;
								if( $event ) {
									$selected = $event->getTrackID() === $track->getTrackID();
								} elseif( isset( $_GET['track'] ) ) {
									$selected = $_GET['track'] === $track->getTrackUID();
								}

								if( $selected ) {
										$option->setAttr( 'selected', 'selected' );
								}

								echo $option->render();
							}
						?>
					</select>
				</div>
			</div>
			<!-- /tracks -->

			<!-- rooms -->
			<div class="col s12 m4 l3">
				<div class="card-panel">
					<label for="room"><?= __( "Stanza" ) ?></label>
					<select name="room">
						<?php
							// select all the available rooms for this Location
							$rooms =
								Room::factory()
									->whereInt( Location::ID, $conference->getLocationID() )
									->orderBy( Room::NAME )
									->queryGenerator();

							// generate a select option for each room
							foreach( $rooms as $room ) {
								$option = ( new HTML( 'option' ) )
									->setText( esc_html( $room->getRoomName() ) )
									->setAttr( 'value', $room->getRoomID() );

								// eventually auto-select this room
								$selected = false;
								if( $event ) {
									$selected = $event->getRoomID() === $room->getRoomID();
								} elseif( isset( $_GET['room'] ) ) {
									$selected = $_GET['room'] === $room->getRoomUID();
								}

								if( $selected ) {
										$option->setAttr( 'selected', 'selected' );
								}

								echo $option->render();
							}
						?>
					</select>
				</div>
			</div>
			<!-- /rooms -->

		</div>


		<div class="row">

			<div class="col s12 m4 l3">
				<div class="card-panel">
					<label for="event-start"><?= __( "Inizio" ) ?></label>
					<input type="text" name="start" required placeholder="Y-m-d H:i:s"<?php
						if( $event ) {
							echo value( $event->getEventStart()->format( 'Y-m-d H:i:s' ) );
						}
					?> />
				</div>
			</div>

			<div class="col s12 m4 l3">
				<div class="card-panel">
					<label for="event-end"><?= __( "Fine" ) ?></label>
					<input type="text" name="end" required placeholder="Y-m-d H:i:s"<?php
						if( $event ) {
							echo value( $event->getEventEnd()->format( 'Y-m-d H:i:s' ) );
						}
					?> />
				</div>
			</div>

		</div>
		<div class="row">

			<div class="col s12 m6">
				<div class="card-panel">
					<label for="event-abstract"><?= __( "Abstract" ) ?></label>
					<textarea name="abstract" class="materialize-textarea"><?php
						if( $event ) {
							echo esc_html( $event->get( Event::ABSTRACT ) );
						}
					?></textarea>
					<?php if( $event ): ?>
						<div><?= $event->getEventAbstractHTML() ?></div>
					<?php endif ?>
				</div>
			</div>

			<div class="col s12 m6">
				<div class="card-panel">
					<label for="event-description"><?= __( "Descrizione" ) ?></label>
					<textarea name="description" class="materialize-textarea"><?php
						if( $event ) {
							echo esc_html( $event->get( Event::DESCRIPTION ) );
						}
					?></textarea>
					<?php if( $event ): ?>
						<div><?= $event->getEventDescriptionHTML() ?></div>
					<?php endif ?>
				</div>
			</div>

		</div>
		<div class="row">

			<div class="col s12 m6">
				<div class="card-panel">
					<label for="event-image"><?= __( "Immagine" ) ?></label>
					<input type="text" name="image"<?php
						if( $event ) {
							echo value( $event->get( Event::IMAGE ) );
						}
					?>/ >
					<?php if( $event && $event->hasEventImage() ): ?>
						<img src="<?= esc_attr( $event->getEventImage() ) ?>" class="responsive-img" alt="<?= esc_attr( $event->getEventTitle() ) ?>" />
					<?php endif ?>
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col s12">
				<button type="submit" class="btn waves-effect"><?= __( "Salva" ) ?></button>
			</div>
		</div>
	</form>

	<?php if( $event ): ?>
	<div class="row">
		<div class="col s12 m6">
			<div class="card-panel">
				<h3><?php printf(
					__( "Aggiungi %s" ),
					__( "Utente" )
				) ?></h3>
				<form action="" method="post">
					<?php form_action( 'add-user' ) ?>
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
							<option value="<?= $user->getUserUID() ?>">
								<?= esc_html( $user->getUserFullname() ) ?>
							</option>
						<?php endforeach ?>
					</select>
					<p><button type="submit" class="btn"><?= __("Aggiungi") ?></button></p>
				</form>
			</div>
		</div>
	</div>
	<?php endif ?>

	<?php if( $event ): ?>
		<?php $users = $event->factoryUserByEvent()
			->select( [
				User::UID,
				EventUser::ORDER,
			] )
			->defaultClass( EventUser::class )
			->orderBy( EventUser::ORDER )
			->queryGenerator();
		?>

		<?php if( $users->valid() ): ?>
			<h3><?php printf(
				__( "Modifica %s" ),
				__( "Ordinamento" )
			) ?></h3>
			<div class="row">
				<?php foreach( $users as $i => $user ): ?>
					<div class="col s12 m6">
						<div class="card-panel">
							<div class="row">
							<form action="" method="post">
								<?php form_action( 'update-user' ) ?>
								<div class="col s12 m6">
									<input type="text" name="user"<?= value( $user->getUserUID() ) ?> />
								</div>
								<div class="col s12 m6">
									<input type="number" name="order"<?= value( $user->getEventUserOrder() ) ?>" />
								</div>
								<div class="col sq12 m6">
									<input type="checkbox" name="delete" value="yes" id="asd-<?= $i ?>" />
									<label for="asd-<?= $i ?>"><?= __("Elimina") ?></label>
								</div>
								<div class="col s12 m6">
									<p><button type="submit" class="btn"><?= __("Salva") ?></button></p>
								</div>
							</form>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		<?php endif ?>
	<?php endif ?>

<?php

Footer::spawn();
