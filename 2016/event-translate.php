<?php
# Linux Day Torino Website - Event translation page
# Copyright (C) 2019 Valerio Bozzolan, Linux Day Torino contributors
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

// load the framework
require 'load.php';

// only allow translators
// read the Event ID
$id = isset( $_GET['id'] )
     ? (int) $_GET['id']
     : null;

// require the Event ID
if( !$id ) {
	die_with_404();
}

// query the Event
$event = ( new QueryEvent() )
	->whereEventID( $id )
	->joinConference()
	->joinTrack()
	->queryRow();

// no Event no party
if( !$event ) {
	die_with_404();
}

// no permissions no party
if( !$event->isEventEditable() && !has_permission( 'translate' ) ) {
	error_die( 'not enough permissions' );
}

$DEFAULT_LANGUAGE = RegisterLanguage::instance()->getDefault();

// register form action
if( is_action( 'translate-event' ) ) {

	$tosave = [];

	// for each language save the fields
	foreach( all_languages() as $lang ) {

		// do not allow to edit the default language
		if( $lang === $DEFAULT_LANGUAGE ) {
			continue;
		}

		foreach( Event::fields_i18n() as $i18n_column => $label ) {
			// generic column name in this language
			$field = $i18n_column . '_' . $lang->getISO();

			// sent column value
			$value = $_POST[ $field ] ?? null;

			// prepare to be saved
			$tosave[] = new DBCol( $field, $value, 'snull' );
		}
	}

	// update the fields
	( new QueryEvent() )
		->whereEvent( $event )
		->update( $tosave );
}

// print the site header
Header::spawn( null, [
	'title' => $event->getEventTitle(),
] );
?>

<form method="post">

	<p><?= __( "Descrizione" ) ?>
	<div class="row">
		<?php foreach( all_languages() as $lang ): ?>
			<div class="col s12">
				<label><?= $lang->getHuman() ?></label>
				<textarea name="<?= Event::DESCRIPTION ?>"<?php

					// mark source language as readonly
					if( $lang === $DEFAULT_LANGUAGE ) {
						echo " readonly";
					}

				?>><?=
					// textarea content
					esc_html( $event->get( Event::DESCRIPTION . '_' . $lang->getISO() ) )
				?></textarea>
			</div>
		<?php endforeach ?>
	</div>

	<div class="row">
		<div class="col s12">
			<button class="btn waves-effect" type="submit"><?= __( "Salva" ) ?></button>
		</div>
	</div>

</form>

<?php
Footer::spawn();
