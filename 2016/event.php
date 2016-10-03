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
if( isset( $_GET['conference'], $_GET['uid'], $_GET['chapter'] ) ) {
	$event = Event::getEventByConferenceChapter(
		luser_input( $_GET['uid']       , 64 ),
		luser_input( $_GET['conference'], 64 ),
		luser_input( $_GET['chapter']   , 64 )
	);
}

$event || die_with_404();

$args = [
	'title' => sprintf(
		_("Talk: %s"),
		$event->event_title
	),
	'url'   => $event->getEventURL()
];

if( $event->hasEventImage() ) {
	$args['og'] = [
		'image' => $event->getEventImage()
	];
}

new Header('event', $args);
?>
	<div class="row">

		<div class="col s12 m4">
			<img class="responsive-img hoverable" src="<?php
				if( $event->hasEventImage() ) {
					echo $event->getEventImage();
				} else {
					echo DEFAULT_IMAGE;
				}
			?>" alt="<?php
				_esc_attr( $event->event_title )
			?>" />
		</div>

		<!-- Start room -->
		<div class="col s12 l8">
			<p class="flow-text"><?php printf(
				_("Il talk si terrà il %s alle ore %s in %s."),
				"<b>{$event->getEventStart("d/m/Y")}</b>",
				"<b>{$event->getEventStart("H:i")}</b>",
				"<b>{$event->room_name}</b>"
			) ?></p>
		</div>
		<!-- End room -->
	</div>

	<!-- Start event description -->
	<?php if( $event->hasEventDescription() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?php _e("Descrizione") ?></h3>
		<p class="flow-text"><?php echo $event->getEventDescription() ?></p>
	</div>
	<?php endif ?>
	<!-- End event description -->

	<div class="divider"></div>

	<div class="section">
		<h3><?php _e("Relatori") ?></h3>

		<?php $users = $event->queryEventUsers(); ?>

		<?php if($users): ?>
			<div class="row">
			<?php while( $user = $users->fetch_object('User') ): ?>
				<div class="col s12 m6">
					<div class="row valign-wrapper">
						<div class="col s12 m4 l3">
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
						<div class="col s12 m4 l9">
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

	<script>
	$(document).ready(function () {
		$('.tooltipped').tooltip();
	});
	</script>
<?php new Footer();
