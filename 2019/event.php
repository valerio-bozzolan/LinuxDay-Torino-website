<?php
# Linux Day 2019 - single event page (an event lives in a conference)
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

$event = FullEvent::factory()
	->select( Location::fields() )
	->joinLocation()
	->whereConferenceUID( CURRENT_CONFERENCE_UID )
	->whereEventUID( $_GET['uid' ] )
	->queryRow();

if( !$event ) {
	die_with_404();
}

// well, this Event has all the Conference stuff
$conference = $event;

$args = [
	'conference' => $conference,
	'title' => sprintf(
		__("%s: %s"),
		$event->getChapterName(),
		$event->getEventTitle()
	),
	'canonical' => $event->getEventURL( true ),
];

if( $event->hasEventImage() ) {
	$args['og'] = [
		'image' => $event->getEventImage( true ),
	];
}

template( 'header', $args );
?>

<section class="container">
	<h1><?= esc_html( $event->getEventTitle() ) ?></h1>

	<?php if( $event->hasEventSubtitle() ): ?>
		<h2><?= esc_html( $event->getEventSubtitle() ) ?></h2>
	<?php endif ?>

	<?php if( $event->isEventEditable() ): ?>
	<p><?= HTML::a(
		$event->getFullEventEditURL(),
		__("Modifica") . icon('edit', 'left')
	) ?></p>
	<?php endif ?>
</section>

<section class="container">
	<div class="row">
		<div class="col-sm-12 col-md-5 col-lg-4">
			<div class="row">
				<div class="col-sm-6 col-md-12">
					<img class="img-responsive hoverable" src="<?= esc_attr(
						$event->hasEventImage()
							? $event->getEventImage()
							: DEFAULT_IMAGE
					) ?>" alt="<?= esc_attr( $event->getEventTitle() ) ?>" />
				</div>
			</div>
		</div>

		<!-- Start room -->
		<div class="col-sm-12 col-md-6 offset-md-1 col-lg-5 offset-lg-3">
			<table class="table table-responsive">
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
							esc_html( $conference->getLocationName() ),
							$conference->getLocationAddress(),
							null,
							'target="_blank"'
						) ?></small><br />
						<small><?= esc_html( $conference->getLocationAddress() ) ?></small>
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
</section>

	<!-- Start event abstract -->
	<?php if( $event->hasEventAbstract() ): ?>
		<section class="container">
			<div class="jumbotron">
				<h3><?= __("Abstract") ?></h3>
				<?= $event->getEventAbstractHTML( ['p' => 'flow-text'] ) ?>
			</div>
		</section>
	<?php endif ?>
	<!-- End event abstract -->

	<!-- Start event description -->
	<?php if( $event->hasEventDescription() ): ?>
		<section class="container">
			<div class="jumbotron">
				<h3><?= __( "Descrizione" ) ?></h3>
				<?= $event->getEventDescriptionHTML( ['p' => 'flow-text'] ) ?>
			</div>
		</section>
	<?php endif ?>
	<!-- End event description -->

	<!-- Start event description -->
	<?php if( $event->hasEventNote() ): ?>
		<section class="container">
			<h3><?= __("Note") ?></h3>
			<?= $event->getEventNoteHTML( ['p' => 'flow-text'] ) ?>
		</section>
	<?php endif ?>
	<!-- End event description -->

	<!-- Start files -->
	<?php $sharables = $event->factorySharebleByEvent()
		->queryGenerator();
	?>
	<?php if( $sharables->valid() ): ?>
		<section class="container">
		<h3><?= __("Materiale") ?></h3>
		<div class="row">
			<?php foreach( $sharables as $sharable ): ?>
			<div class="col-sm-12">
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
		</section>
	<?php endif ?>
	<!-- End files -->

	<!-- Start speakers -->
	<section class="container">
		<h3><?= __("Relatori") ?></h3>

		<?php $users = $event->factoryUserByEvent()
			->queryGenerator(); ?>

		<?php if( $users->valid() ): ?>
			<div class="row">
			<?php foreach( $users as $user ): ?>
				<div class="col-sm-12 col-md-6">
					<div class="row">
						<div class="col-sm-4 col-lg-3">
							<p><a class="tooltipped" href="<?= esc_attr(
								$user->getUserURL()
							) ?>" title="<?= esc_attr( sprintf(
								__("Profilo di %s"),
								$user->getUserFullname()
							) ) ?>">
								<img class="circle img-responsive hoverable" src="<?= esc_attr(
									$user->getUserImage( 256 )
								) ?>" alt="<?= esc_attr(
									$user->getUserFullname()
								) ?>" />
							</a></p>
						</div>
						<div class="col-sm-8 col-lg-9">
							<p><?= HTML::a(
								$user->getUserURL(),
								"<h4>" . esc_html( $user->getUserFullname() ) . "</h4>",
								sprintf(
									__("Profilo di %s"),
									$user->getUserFullname()
								)
							) ?></p>
						</div>
					</div>
				</div>
			<?php endforeach ?>
			</div>
		<?php else: ?>
			<p><?= __("L'elenco dei relatori non è ancora noto.") ?></p>
		<?php endif ?>
	</section>
	<!-- End speakers -->

	<?php
	$previous = $event->factoryPreviousFullEvent()
		->limit( 1 )
		->queryRow();

	$next = $event->factoryNextFullEvent()
		->limit( 1 )
		->queryRow();
	?>
	<?php if($previous || $next): ?>
	<!-- Stard previous/before -->
	<section class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-6">
				<?php if( $previous ): ?>
					<h3><?= __( "Preceduto da" ) ?></h3>
					<h3><?= HTML::a(
						$previous->getEventURL(),
						icon( 'arrow-left' ) . ' ' . esc_html( $previous->getEventTitle() )
					) ?></h3>
					<time datetime="<?= $previous->getEventStart('Y-m-d H:i') ?>"><?= $previous->getEventHumanStart() ?></time>
				<?php endif ?>
			</div>
			<div class="col-sm-12 col-md-6 col-lg-6 text-right">
				<?php if( $next ): ?>
					<h3><?= __( "A seguire" ) ?></h3>
					<h3><?= HTML::a(
						$next->getEventURL(),
						esc_html( $next->getEventTitle() ) . ' ' . icon( 'arrow-right' )
					) ?></h3>
					<time datetime="<?= $next->getEventStart('Y-m-d H:i') ?>"><?= $next->getEventHumanStart() ?></time>
				<?php endif ?>
			</div>
		</div>
	</section>
	<!-- End previous/before -->
	<?php endif ?>

<?php

template( 'footer', [
	'back' => true,
] );
