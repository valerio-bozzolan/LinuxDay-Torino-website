<?php
# Linux Day 2016 - Single user profile page
# Copyright (C) 2016, 2017 Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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

$conference = FullConference::queryByUID( @ $_GET['conference'] );
$conference or die_with_404();

$user       = User::queryByUID( $_GET['uid'] );
$user or die_with_404();

FORCE_PERMALINK && $user->forceUserPermalink();

Header::spawn('user', [
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
	<?php if( $user->hasPermissionToEditUser() ): ?>
		<p><?php echo HTML::a(
			CURRENT_CONFERENCE_PATH . "/user-edit.php?uid={$user->getUserUID()}",
			_("Modifica") . icon('edit', 'left')
		) ?></p>
	<?php endif ?>

	<div class="row">

		<!-- Profile image -->
		<div class="col s12 m6 l4">
			<div class="row">
				<div class="col s8">
					<?php if( $user->user_site ): ?>
						<a href="<?php echo $user->user_site ?>" title="<?php _esc_attr( $user->getUserFullname() ) ?>" target="_blank">
					<?php endif ?>
						<img class="responsive-img hoverable z-depth-1" src="<?php
							echo $user->getUserImage()
						?>" alt="<?php
							_esc_attr( $user->getUserFullname() )
						?>" />
					<?php if( $user->user_site ): ?>
						</a>
					<?php endif ?>
				</div>
			</div>

			<!-- Start website -->
			<?php if( $user->user_site ): ?>
			<div class="row">
				<div class="col s12">
					<p><?php echo HTML::a(
						$user->user_site,
						_("Sito personale") . icon('contact_mail', 'right'),
						null,
						'btn waves-effect purple darken-2',
						'target="_blank"'
					) ?></p>
				</div>
			</div>
			<?php endif ?>
			<!-- End website -->
		</div>
		<!-- End profile image -->

		<!-- Start sidebar -->
		<div class="col s12 m6 l8">

			<!-- Start skills -->
			<?php $skills = $user->factoryUserSkills()
				->query();
			?>
			<?php if( $skills->num_rows ): ?>
			<div class="row">
				<div class="col s12">
					<p><?php _e("Le mie skill:") ?></p>
					<?php while( $skill = $skills->fetch_object('UserSkill') ): ?>
						<div class="chip tooltipped hoverable" data-tooltip="<?php _esc_attr( $skill->getSkillPhrase() ) ?>"><code><?php echo $skill->getSkillCode() ?></code></div>
					<?php endwhile ?>
				</div>
			</div>
			<?php endif ?>
			<!-- End skills -->

			<!-- Start license -->
			<?php if( $user->hasUserLovelicense() ): ?>
			<div class="row">
				<div class="col s12">
					<?php $license = $user->getUserLovelicense() ?>
					<p><?php printf(
						_("La mia licenza di software libero preferita è la <b>%s</b>."),
						$license->getLink()
					) ?></p>
				</div>
			</div>
			<?php endif ?>
			<!-- End license -->

		</div>
		<!-- End sidebar -->
	</div>

	<!-- Start user bio -->
	<?php if( $user->hasUserBio() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?php _e("Bio") ?></h3>
		<?php echo $user->getUserBioHTML( ['p' => 'flow-text'] ) ?>
	</div>
	<?php endif ?>
	<!-- End user bio -->

	<div class="divider"></div>

	<div class="section">
		<h3><?php _e("Talk condotti") ?></h3>

		<?php $events = $user->factoryUserEvents()
			->whereInt( 'event.conference_ID', $conference->getConferenceID() )
			->query();
		 ?>
		<?php if($events->num_rows): ?>
			<table>
			<thead>
			<tr>
				<th><?php _e("Nome") ?></th>
				<th><?php _e("Tipo") ?></th>
				<th><?php _e("Tema") ?></th>
				<th><?php _e("Dove") ?></th>
				<th><?php _e("When") ?></th>
			</tr>
			</thead>
			<tbody>
			<?php while( $event = $events->fetch_object('FullEvent') ): ?>
			<tr>
				<td><?php echo HTML::a(
					$event->getEventURL(),
					sprintf(
						"<strong>%s</strong>",
						esc_html( $title = $event->getEventTitle() )
					),
					sprintf(
						_("Vedi %s"),
						$title
					)
				) ?></td>
				<td><?php _esc_html( $event->getChapterName() ) ?></td>
				<td><?php _esc_html( $event->getTrackName() ) ?></td>
				<td>
					<span class="tooltipped" data-position="top" data-tooltip="<?php _esc_attr( $conference->getLocationAddress() ) ?>">
						<?php _esc_html( $conference->getLocationName() ) ?>
					</span><br />
					<?php _esc_html( $event->getRoomName() ) ?>
				</td>
				<td>
					<?php printf(
						_("Ore <b>%s</b> (il %s)"),
						$event->getEventStart("H:i"),
						$event->getEventStart("d/m/Y")
					) ?><br />
					<small><?php echo $event->getEventHumanStart() ?></small>
				</td>
			</tr>
			<?php endwhile ?>
			</tbody>
			</table>
		<?php else: ?>
			<p><?php _e("Questo utente non ha ancora tenuto nessun talk.") ?></p>
		<?php endif ?>
	</div>

	<!-- Start social -->
	<?php if( $user->isUserSocial() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?php _e("Social") ?></h3>
		<div class="row">
			<?php $box = function($user, $social, $profile, $path, $is_icon = false) { ?>
			<div class="col s4 m3 l2">
				<?php
				$title = sprintf( _("%s su %s"), $user->getUserFullname(), $social );
				$logo = $is_icon ? icon($path) : HTML::img(STATIC_PATH . "/social/$path", $social, $title, 'responsive-img');
				echo HTML::a($profile, $logo, $title, null, 'target="_blank"');
				?>
			</div>
			<?php }; ?>

			<?php
			$user->get('user_rss')    and $box($user, "RSS",      $user->get('user_rss'),     'home.png');
			$user->get('user_fb')     and $box($user, "Facebook", $user->getUserFacebruck(),  'facebook_logo.png');
			$user->get('user_googl')  and $box($user, "Google+",  $user->getUserGuggolpluz(), 'google.png'  );
			$user->get('user_twtr')   and $box($user, "Twitter",  $user->getUserTuitt(),      'twitter.png' );
			$user->get('user_lnkd')   and $box($user, "Linkedin", $user->getUserLinkeddon(),  'linkedin.png');
			$user->get('user_github') and $box($user, "Github",   $user->getUserGithubbo(),   'github.png'  );
			?>
		</div>
	</div>
	<?php endif ?>
	<!-- End social -->
<?php

Footer::spawn();
