<?php
# Linux Day 2016 - User profile page
# Copyright (C) 2016 Valerio Bozzolan, Ludovico Pavesi
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

$user = null;

if( isset( $_GET['uid'] ) ) {
	$user = User::queryUser( $_GET['uid'] );
}

if( $user ) {
	the_header('user', [
		'title' => $user->getUserFullname(),
		'url'   => $user->getUserProfileURL()
	] );
} else {
	the_header('404', [
		'not-found' => true
	] );
	error("nott foond a.k.a. erroro quattrociantoquatto. (Eseguire coi permessi di root NON risolve la situazione)");
	the_footer();
	exit;
}
?>
	<div class="row">

		<!-- Profile image -->
		<div class="col s12 l4">
			<div class="valign-wrapper">
				<img class="responsive-img hoverable z-depth-1" src="<?php
					echo $user->getUserImageURL() . '?s=256'
				?>" alt="<?php
					_esc_attr( $user->getUserFullname() )
				?>" title="<?php
					_esc_attr( $user->getUserFullname() )
				?> "/>
			</div>

			<!-- Start website -->
			<?php if( $user->user_site ): ?>
			<div class="row">
				<div class="col s12">
					<p><?php echo HTML::a(
						$user->user_site,
						_("Sito personale") . icon('contact_mail', 'right'),
						null,
						'btn waves-effect waves-light'
					) ?></p>
				</div>
			</div>
			<?php endif ?>
			<!-- End website -->
		</div>
		<!-- End profile image -->

		<!-- Start sidebar -->
		<div class="col s12 l8">

			<!-- Start skills -->
			<?php $skills = $user->queryUserSkills(); ?>
			<?php if( $skills->num_rows ): ?>
			<div class="row">
				<div class="col s12">
					<p><?php _e("Le mie skill:") ?></p>
					<?php while( $skill = $skills->fetch_object('Skill') ): ?>
						<div class="chip tooltipped hoverable" data-tooltip="<?php _esc_attr( $skill->getSkillPhrase() ) ?>"><code><?php echo $skill->getSkillCode() ?></code></div>
					<?php endwhile ?>
				</div>
			</div>
			<?php endif ?>
			<!-- End skills -->

			<!-- Start license -->
			<?php if( $user->user_lovelicense ): ?>
			<div class="row">
				<div class="col s12">
					<p><?php printf(
						_("La mia licenza di software libero preferita è la <b>%s</b>."),
						HTML::a(
							$user->user_lovelicense->getURL(),
							$user->user_lovelicense->getShort(),
							$user->user_lovelicense->getName()
						)
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
		<p class="flow-text"><?php _esc_html( $user->getUserBio() ) ?></p>
	</div>
	<?php endif ?>
	<!-- End user bio -->

	<div class="divider"></div>

	<div class="section">
		<h3><?php _e("Talk condotti") ?></h3>

		<?php $events = $user->getUserEvents() ?>

		<?php if($events): ?>
			<table>
			<thead>
			<tr>
				<th><?php _e("Nome talk") ?></th>
				<th><?php _e("Orario") ?></th>
			<tr>
			</thead>
			<?php foreach($events as $event): ?>
			<tr>
				<td><?php printf(
					"<strong>%s</strong>",
					esc_html( $event->event_title )
				) ?></td>
				<td><?php printf(
					_("Ore <b>%s</b> (il %s)"),
					$event->getEventStart("H:i"),
					$event->getEventStart("d/m/Y")
				) ?></td>
			</tr>
			<?php endforeach ?>
			</table>
		<?php else: ?>
			<p><?php _e("Al momento non ho tenuto alcun talk.") ?></p>
		<?php endif ?>
	</div>

	<!-- Start social -->
	<?php if( $user->isUserSocial() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?php _e("Social") ?></h3>
		<div class="row">
			<?php $box = function($user, $social, $title, $icon, $profile, $colors) { ?>
			<div class="col s4 m3">
				<?php echo HTML::a(
					$profile,
					($icon) ? icon($title) : $title,
					sprintf(
						_("%s su %s"),
						$user->getUserFullname(),
						$social
					),
					"btn-floating btn-large waves-effect waves-light $colors"
				) ?>
			</div>
			<?php }; ?>

			<?php
			$user->user_rss   && $box($user, _("RSS"),      'rss_feed', 1, $user->user_rss,            'orange');
			$user->user_fb    && $box($user, _("Facebook"), 'FB',       0, $user->getUserFacebruck(),  'indigo');
			$user->user_googl && $box($user, _("Google+"),  'G+',       0, $user->getUserGuggolpluz(), 'red');
			$user->user_twtr  && $box($user, _("Twitter"),  'Tw',       0, $user->getUserTuitt(),      'blue');
			?>
		</div>
	</div>
	<?php endif ?>
	<!-- End social -->
<?php
the_footer();

        function getUserFacebruck() {
                return 'https://facebook.com/' . $this->user_fb;
        }

        function getUserGuggolpluz() {
                return 'https://plus.google.com/' . $this->user_googl;
        }

        function getUserTuitt() {
                return 'https://twitter.com/' . $this->user_twtr;
        }
