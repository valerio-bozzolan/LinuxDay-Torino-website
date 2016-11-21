<?php
# Linux Day 2016 - Single event page (an event lives in a conference)
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
if( isset( $_GET['uid'], $_GET['conference'], $_GET['chapter'] ) ) {
	$event = Event::getByConferenceChapter(
		$_GET['uid'],
		$_GET['conference'],
		$_GET['chapter']
	);
}

$event          || die_with_404();
FORCE_PERMALINK && $event->forceEventPermalink();

$args = [
	'title' => sprintf(
		_("%s: %s"),
		$event->getChapterName(),
		$event->getEventTitle()
	),
	'url'   => $event->getEventURL()
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

	if( filter_var($email, FILTER_VALIDATE_EMAIL)  ) {
		$event->addSubscription($email);

		$args['alert']      = _("Grazie per esserti iscritto.");
		$args['alert.type'] = Messagebox::INFO;
		$subscribed         = true;
	} else {
		$args['alert']      = _("E-mail non valida.");
		$args['alert.type'] = Messagebox::ERROR;
		$subscribed         = false;
	}
}

new Header('event', $args);
?>
	<?php if( $event->hasPermissionToEditEvent() ): ?>
	<p><?php echo HTML::a(
		CONFERENCE . "/event-edit.php?" . http_build_query( [
			'uid'        => $event->getEventUID(),
			'conference' => $event->getConferenceUID()
		] ),
		_("Modifica evento") . icon('edit', 'left')
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
						_esc_attr( $event->getEventTitle() )
					?>" />
				</div>
			</div>
		</div>

		<!-- Start room -->
		<div class="col s12 m6 offset-m1 l5 offset-l3">
			<table class="striped bordered">
				<tr>
					<th><?php echo icon('folder', 'left'); _e("Tema") ?></th>
					<td>
						<?php echo $event->getTrackName() ?><br />
						<small><?php echo $event->getTrackLabel() ?></small>
					</td>
				</tr>
				<tr>
					<th><?php echo icon('room', 'left'); _e("Dove") ?></th>
					<td>
						<?php echo $event->getRoomName() ?><br />
						<small>@ <?php echo HTML::a(
							$event->getLocationGeoOSM(),
							$event->getLocationName(),
							$event->getLocationAddress(),
							null,
							'target="_blank"'
						) ?></small><br />
						<small><?php echo $event->getLocationAddress() ?></small>
					</td>
				</tr>
				<tr>
					<th><?php echo icon('access_time', 'left'); _e("Quando") ?></th>
					<td>
						<?php echo $event->getEventHumanStart() ?><br />
						<small><?php printf(
							_("%s alle %s"),
							$event->getEventStart( _("d/m/Y") ),
							$event->getEventStart('H:i')
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
		<h3><?php _e("Abstract") ?></h3>
		<?php echo $event->getEventAbstractHTML(['p' => 'flow-text']) ?>
	</div>
	<?php endif ?>
	<!-- End event abstract -->

	<!-- Start event description -->
	<?php if( $event->hasEventDescription() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?php _e("Descrizione") ?></h3>
		<?php echo $event->getEventDescriptionHTML(['p' => 'flow-text']) ?>
	</div>
	<?php endif ?>
	<!-- End event description -->

	<!-- Start subscriptions -->
	<?php if( $event->areEventSubscriptionsAvailable() ): ?>
	<div class="divider"></div>
	<div class="section">
		<?php if( $subscribed === true ): ?>
			<p class="flow-text"><?php _e("Invita anche i tuoi amici ad iscriversi condividendo l'indirizzo di questa pagina.") ?></p>
		<?php else: ?>
			<form method="post">
				<div class="row">
					<div class="col s12 m6 l8">
						<div class="card-panel">
							<h3><?php _e("Iscrizioni") ?></h3>
							<p class="flow-text"><?php _e("Le sottoscrizioni sono ancora aperte. Inserisci la tua e-mail per segnalare il tuo interesse:") ?></p>
							<div class="row">
								<div class="col s12 l6 input-field">
									<label for="subscription_email"><?php _e("E-mail") ?></label>
									<input type="email" name="subscription_email" id="subscription_email" />
								</div>
								<div class="col s12 l6 input-field">
									<button type="submit" class="btn purple darken-3 waves-effect"><?php _e("Sottoscrivi"); echo icon('send', 'right') ?></button>
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
		<h3><?php _e("Note") ?></h3>
		<?php echo $event->getEventNoteHTML(['p' => 'flow-text']) ?>
	</div>
	<?php endif ?>
	<!-- End event description -->

	<!-- Start files -->
	<?php $sharables = $event->querySharables() ?>
	<?php if( $sharables->num_rows ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?php _e("Materiale") ?></h3>
		<div class="row">
			<?php $i = 0 ?>
			<?php while( $sharable = $sharables->fetch_object('Sharable') ): ?>
			<div class="col s12">
				<?php if( $sharable->isSharableDownloadable() ): ?>
					<p class="flow-text">
						<?php printf(
							_("Scarica %s distribuibile sotto licenza %s."),
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
						<source src="<?php echo $sharable->getSharablePath() ?>" type="<?php echo $sharable->getSharableMIME() ?>" />
					</video>
					<?php endif ?>
				<?php else: ?>
					<p class="flow-text">
						<?php printf(
							_("Vedi %s distribuibile sotto licenza %s."),
							HTML::a(
								$sharable->getSharablePath(),
								icon('share', 'left') . $sharable->getSharableTitle(['prop' => true]),
								null,
								null,
								'target="_blank"'
							),
							$sharable->getSharableLicense()->getLink()
						) ?>
					</p>
				<?php endif ?>
			</div>
			<?php endwhile ?>
		</div>
	</div>
	<?php endif ?>
	<!-- End files -->

	<!-- Start speakers -->
	<div class="divider"></div>
	<div class="section">
		<h3><?php _e("Relatori") ?></h3>

		<?php $users = $event->queryEventUsers(); ?>

		<?php if( $users->num_rows ): ?>
			<div class="row">
			<?php while( $user = $users->fetch_object('User') ): ?>
				<div class="col s12 m6">
					<div class="row valign-wrapper">
						<div class="col s4 l3">
							<a class="tooltipped" href="<?php
								echo $user->getUserURL()
							?>" title="<?php _esc_attr( sprintf(
								_("Profilo di %s"),
								$user->getUserFullname()
							) ) ?>" data-tooltip="<?php _esc_attr(
								$user->getUserFullname()
							) ?>">
								<img class="circle responsive-img hoverable" src="<?php
									echo $user->getUserImage(256)
								?>" alt="<?php _esc_attr(
									$user->getUserFullname()
								) ?>" />
							</a>
						</div>
						<div class="col s8 l9">
							<?php echo HTML::a(
								$user->getUserURL(),
								"<h4>{$user->getUserFullname()}</h4>",
								sprintf(
									_("Profilo di %s"),
									$user->getUserFullname()
								),
								'valign'
							) ?>
						</div>
					</div>
				</div>
			<?php endwhile ?>
			</div>
		<?php else: ?>
			<p><?php _e("L'elenco dei relatori non è ancora noto.") ?></p>
		<?php endif ?>
	</div>
	<!-- End speakers -->

	<?php
	$previous = $event->getPreviousEvent( [
		'event_uid', 'event_title', 'chapter_uid', 'conference_uid', 'event_start'
	] );
	$next     = $event->getNextEvent( [
		'event_uid', 'event_title', 'chapter_uid', 'conference_uid', 'event_start'
	] );
	?>
	<?php if($previous || $next): ?>
	<!-- Stard previous/before -->
	<div class="divider"></div>
	<div class="section">
		<div class="row">
			<div class="col s12 m6">
				<?php if( $previous ): ?>
					<h3><?php echo icon('navigate_before'); _e("Preceduto da") ?></h3>
					<p class="flow-text">
						<?php echo HTML::a(
							$previous->getEventURL(),
							$previous->getEventTitle()
						) ?>
						<time datetime="<?php echo $previous->getEventStart('Y-m-d H:i') ?>"><?php echo $previous->getEventHumanStart() ?></time>
					</p>
				<?php endif ?>
			</div>
			<div class="col s12 m6 right-align">
				<?php if( $next ): ?>
					<h3><?php _e("A seguire"); echo icon('navigate_next') ?></h3>
					<p class="flow-text">
						<?php echo HTML::a(
							$next->getEventURL(),
							$next->getEventTitle()
						) ?>
						<time datetime="<?php echo $next->getEventStart('Y-m-d H:i') ?>"><?php echo $next->getEventHumanStart() ?></time>
					</p>
				<?php endif ?>
			</div>
		</div>
	</div>
	<!-- End previous/before -->
	<?php endif ?>

	<script>
	$(document).ready(function () {
		$('.tooltipped').tooltip();
	});
	</script>
<?php new Footer();
