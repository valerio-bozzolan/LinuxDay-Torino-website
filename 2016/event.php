<?php
# Linux Day 2016 - single event page (an event lives in a conference)
# Copyright (C) 2016, 2017, 2018 Valerio Bozzolan, Linux Day Torino
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

$conference = FullConference::factoryFromUID( CURRENT_CONFERENCE_UID )
	->queryRow();

$conference or die_with_404();

$event = FullEvent::factoryByConferenceAndUID(
	$conference->getConferenceID(),
	@ $_GET['uid']
)->queryRow();

$event or die_with_404();

FORCE_PERMALINK and $event->forceEventPermalink();

$args = [
	'title' => sprintf(
		__("%s: %s"),
		$event->getChapterName(),
		$event->getEventTitle()
	),
	'url' => $event->getEventURL()
];

if( $event->hasEventImage() ) {
	$args['og'] = [
		'image' => $event->getEventImage()
	];
}

// Adding subscribers
$subscribed = null;
if( isset( $_POST['subscription_email'] ) && $event->areEventSubscriptionsAvailable() ) {
	$email = $_POST['subscription_email'];

	if( filter_var($email, FILTER_VALIDATE_EMAIL) ) {
		$event->addSubscription($email);

		$args['alert']      = __("Grazie per esserti iscritto.");
		$args['alert.type'] = Messagebox::INFO;
		$subscribed         = true;
	} else {
		$args['alert']      = __("E-mail non valida.");
		$args['alert.type'] = Messagebox::ERROR;
		$subscribed         = false;
	}
}

Header::spawn( null, $args );
?>
	<?php if( $event->isEventEditable() ): ?>
	<p><?= HTML::a(
		$event->getFullEventEditURL(),
		__("Modifica evento") . icon('edit', 'left')
	) ?></p>
	<?php endif ?>

	<div class="row">
		<div class="col s12 m5 l4">
			<div class="row">
				<div class="col s6 m12">
					<img class="responsive-img hoverable" src="<?php
						if( $event->hasEventImage() ) {
							echo $event->getEventImage();
						} else {
							echo DEFAULT_IMAGE;
						}
					?>" alt="<?php
						echo esc_attr( $event->getEventTitle() )
					?>" />
				</div>
			</div>
		</div>

		<!-- Start room -->
		<div class="col s12 m6 offset-m1 l5 offset-l3">
			<table class="striped bordered">
				<tr>
					<th><?= icon('folder', 'left'); echo __("Tema") ?></th>
					<td>
						<?= $event->getTrackName() ?><br />
						<small><?= $event->getTrackLabel() ?></small>
					</td>
				</tr>
				<tr>
					<th><?= icon('room', 'left'); echo __("Dove") ?></th>
					<td>
						<?= $event->getRoomName() ?><br />
						<small>@ <?= HTML::a(
							$conference->getLocationGeoOSM(),
							$conference->getLocationName(),
							$conference->getLocationAddress(),
							null,
							'target="_blank"'
						) ?></small><br />
						<small><?= $conference->getLocationAddress() ?></small>
					</td>
				</tr>
				<tr>
					<th><?= icon('access_time', 'left'); echo __("Quando") ?></th>
					<td>
						<?= $event->getEventHumanStart() ?><br />
						<small><?php printf(
							__("%s alle %s"),
							$event->getEventStart('d/m/Y'),
							$event->getEventStart('H:i')
						) ?></small><br />
						<small><?= HTML::a(
							$event->getEventCalURL(),
							__( "Scarica promemoria calendario" )
						) ?></small>
					</td>
				</tr>
			</table>
		</div>
		<!-- End room -->
	</div>

	<!-- Start event abstract -->
	<?php if( $event->hasEventAbstract() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?= __("Abstract") ?></h3>
		<?= $event->getEventAbstractHTML( ['p' => 'flow-text'] ) ?>
	</div>
	<?php endif ?>
	<!-- End event abstract -->

	<!-- Start event description -->
	<?php if( $event->hasEventDescription() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?= __("Descrizione") ?></h3>
		<?= $event->getEventDescriptionHTML( ['p' => 'flow-text'] ) ?>
	</div>
	<?php endif ?>
	<!-- End event description -->

	<!-- Start subscriptions -->
	<?php if( $event->areEventSubscriptionsAvailable() ): ?>
	<div class="divider"></div>
	<div class="section">
		<?php if( true === $subscribed ): ?>
			<p class="flow-text"><?= __("Invita anche i tuoi amici ad iscriversi condividendo l'indirizzo di questa pagina.") ?></p>
		<?php else: ?>
			<form method="post">
				<div class="row">
					<div class="col s12 m6 l8">
						<div class="card-panel">
							<h3><?= __("Iscrizioni") ?></h3>
							<p class="flow-text"><?= __("Le sottoscrizioni sono ancora aperte. Inserisci la tua e-mail per segnalare il tuo interesse:") ?></p>
							<div class="row">
								<div class="col s12 l6 input-field">
									<label for="subscription_email"><?= __("E-mail") ?></label>
									<input type="email" name="subscription_email" id="subscription_email" />
								</div>
								<div class="col s12 l6 input-field">
									<button type="submit" class="btn purple darken-3 waves-effect"><?= __("Sottoscrivi"); echo icon('send', 'right') ?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		<?php endif ?>
	</div>
	<?php endif ?>
	<!-- End subscriptions -->

	<!-- Start event description -->
	<?php if( $event->hasEventNote() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?= __("Note") ?></h3>
		<?= $event->getEventNoteHTML( ['p' => 'flow-text'] ) ?>
	</div>
	<?php endif ?>
	<!-- End event description -->

	<!-- Start files -->
	<?php $sharables = $event->factorySharebleByEvent()
		->queryGenerator();
	?>
	<?php if( $sharables->valid() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?= __("Materiale") ?></h3>
		<div class="row">
			<?php foreach( $sharables as $sharable ): ?>
			<div class="col s12">
				<?php if( $sharable->isSharableDownloadable() ): ?>
					<p class="flow-text">
						<?php printf(
							__("Scarica %s distribuibile sotto licenza %s."),
							HTML::a(
								$sharable->getSharablePath(),
								icon('attachment', 'left') . $sharable->getSharableTitle(['prop' => true]),
								null,
								null,
								'target="_blank"'
							),
							$sharable->getSharableLicense()->getLink()
						) ?>
					</p>
					<?php if( $sharable->isSharableVideo() ): ?>
					<video class="responsive-video" controls="controls">
						<source src="<?= $sharable->getSharablePath() ?>" type="<?= $sharable->getSharableMIME() ?>" />
					</video>
					<?php endif ?>
				<?php else: ?>
					<p class="flow-text">
						<?php printf(
							__("Vedi %s distribuibile sotto licenza %s."),
							HTML::a(
								$sharable->getSharablePath(),
								icon('share', 'left') . $sharable->getSharableTitle( ['prop' => true] ),
								null,
								null,
								'target="_blank"'
							),
							$sharable->getSharableLicense()->getLink()
						) ?>
					</p>
				<?php endif ?>
			</div>
			<?php endforeach ?>
		</div>
	</div>
	<?php endif ?>
	<!-- End files -->

	<!-- Start speakers -->
	<div class="divider"></div>
	<div class="section">
		<h3><?= __("Relatori") ?></h3>

		<?php $users = $event->factoryUserByEvent()
			->queryGenerator(); ?>

		<?php if( $users->valid() ): ?>
			<div class="row">
			<?php foreach( $users as $user ): ?>
				<div class="col s12 m6">
					<div class="row valign-wrapper">
						<div class="col s4 l3">
							<a class="tooltipped" href="<?php
								echo $user->getUserURL( ROOT )
							?>" title="<?= esc_attr( sprintf(
								__("Profilo di %s"),
								$user->getUserFullname()
							) ) ?>" data-tooltip="<?= esc_attr(
								$user->getUserFullname()
							) ?>">
								<img class="circle responsive-img hoverable" src="<?php
									echo $user->getUserImage(256)
								?>" alt="<?= esc_attr(
									$user->getUserFullname()
								) ?>" />
							</a>
						</div>
						<div class="col s8 l9">
							<?= HTML::a(
								$user->getUserURL(),
								"<h4>{$user->getUserFullname()}</h4>",
								sprintf(
									__("Profilo di %s"),
									$user->getUserFullname()
								),
								'valign'
							) ?>
						</div>
					</div>
				</div>
			<?php endforeach ?>
			</div>
		<?php else: ?>
			<p><?= __("L'elenco dei relatori non è ancora noto.") ?></p>
		<?php endif ?>
	</div>
	<!-- End speakers -->

	<?php
	$previous = $event->factoryPreviousFullEvent()
		->select('event_uid', 'event_title', 'chapter_uid', 'conference_uid', 'event_start')
		->limit(1)
		->queryRow();

	$next = $event->factoryNextFullEvent()
		->select('event_uid', 'event_title', 'chapter_uid', 'conference_uid', 'event_start')
		->limit(1)
		->queryRow();
	?>
	<?php if($previous || $next): ?>
	<!-- Stard previous/before -->
	<div class="divider"></div>
	<div class="section">
		<div class="row">
			<div class="col s12 m6">
				<?php if( $previous ): ?>
					<h3><?= icon('navigate_before'); echo __("Preceduto da") ?></h3>
					<p class="flow-text">
						<?= HTML::a(
							$previous->getEventURL( ROOT ),
							$previous->getEventTitle()
						) ?>
						<time datetime="<?= $previous->getEventStart('Y-m-d H:i') ?>"><?= $previous->getEventHumanStart() ?></time>
					</p>
				<?php endif ?>
			</div>
			<div class="col s12 m6 right-align">
				<?php if( $next ): ?>
					<h3><?= __("A seguire"); echo icon('navigate_next') ?></h3>
					<p class="flow-text">
						<?= HTML::a(
							$next->getEventURL( ROOT ),
							$next->getEventTitle()
						) ?>
						<time datetime="<?= $next->getEventStart('Y-m-d H:i') ?>"><?= $next->getEventHumanStart() ?></time>
					</p>
				<?php endif ?>
			</div>
		</div>
	</div>
	<!-- End previous/before -->
	<?php endif ?>

	<script>
	$( function () {
		$( '.tooltipped' ).tooltip();
	});
	</script>
<?php

Footer::spawn();
