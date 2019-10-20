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
	->joinChapter()
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

		// do not allow to edit the default language if you are not the Event owner
		if( $lang === $DEFAULT_LANGUAGE && !$event->isEventEditable() ) {
			continue;
		}

		// for each translatable fields
		foreach( Event::fields_i18n() as $i18n_column ) {

			// generic column name in this language
			$field = $i18n_column . '_' . $lang->getISO();

			// sent column value
			$value = isset( $_POST[ $field ] )
			              ? $_POST[ $field ]
			              : null;

			// set empty strings as null
			if( !$value ) {
				$value = null;
			}

			// sanitize the value before update (allow string and null)
			$tosave[] = new DBCol( $field, $value, 'snull' );
		}
	}

	// update the fields
	( new QueryEvent() )
		->whereEvent( $event )
		->update( $tosave );

	// POST -> redirect -> GET
	http_redirect( $_SERVER[ 'REQUEST_URI' ], 303 );
}

// print the site header
Header::spawn( null, [
	'title' => $event->getEventTitle(),
] );
?>

<p><?= HTML::a(
	$event->getConferenceURL(),
	esc_html( $event->getConferenceTitle() ) . icon( 'home', 'left' )
) ?></p>

<p><?= HTML::a(
	// href
	$event->getEventURL(),

	// text
	__( "Vedi" ) . icon( 'account_box', 'left' )
) ?></p>

<form method="post">

	<?php form_action( 'translate-event' ) ?>

	<!-- abstract -->
	<?php template( 'textarea-multilanguage', [
		'event' => $event,
		'field' => Event::ABSTRACT,
		'label' => __( "Abstract" )
	] ) ?>

	<!-- description -->
	<?php template( 'textarea-multilanguage', [
		'event' => $event,
		'field' => Event::DESCRIPTION,
		'label' => __( "Descrizione" )
	] ) ?>

	<!-- notes -->
	<?php template( 'textarea-multilanguage', [
		'event' => $event,
		'field' => Event::NOTE,
		'label' => __( "Note" )
	] ) ?>

	<div class="row">
		<div class="col s12">
			<button class="btn waves-effect" type="submit"><?= __( "Salva" ) ?></button>
		</div>
	</div>

</form>

<?php
Footer::spawn();
