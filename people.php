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
		<div class="col s12 l4">
			<div class="valign-wrapper">
				<img class="responsive-img hoverable z-depth-1" src="<?php
					echo $user->getUserImageURL() . '?s=128'
				?>" alt="<?php
					_esc_attr( $user->getUserFullname() )
				?>" title="<?php
					_esc_attr( $user->getUserFullname() )
				?> "/>
			</div>
		</div>

		<?php if( $user->user_site ): ?>
		<div class="col s12 l8">
			<p><?php echo HTML::a(
				$user->user_site,
				_("Sito personale") . icon('send', 'right'),
				null,
				'btn'
			) ?></p>
		</div>
		<?php endif ?>

		<?php $skills = $user->queryUserSkills(); ?>
		<?php if( $skills->num_rows ): ?>
		<div class="col s12 l8">
			<p><?php _e("Le mie skill:") ?></p>
			<?php while( $skill = $skills->fetch_object('Skill') ): ?>
				<div class="chip tooltipped" data-tooltip="<?php _esc_attr( $skill->getSkillPhrase() ) ?>"><code><?php echo $skill->getSkillCode() ?></code></div>
			<?php endwhile ?>
		</div>
		<?php endif ?>

	</div>

	<div class="divider"></div>

	<div class="section">
		<h3><?php _e("Talk condotti") ?></h3>

		<?php $events = $user->getUserEvents() ?>

		<?php if($events): ?>
			<table>
			<thead>
				<th><?php _e("Nome talk") ?></th>
				<th><?php _e("Orario") ?></th>
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
			<p><?php _e("Al momento non tengo nessun talk.") ?></p>
		<?php endif ?>
	</div>
<?php
the_footer();
