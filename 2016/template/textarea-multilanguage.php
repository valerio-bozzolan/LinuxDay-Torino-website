<?php
# Linux Day 2016 - single event page (an event lives in a conference)
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

/*
 * This is the template for the internationalized fields (textarea)
 *
 * Variable that should be available:
 *
 * @param string $label Textarea label
 * @param string $field Database field and input name
 * @param object $event
 */

// do not visit this page directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

// default language of the website
$DEFAULT_LANGUAGE = RegisterLanguage::instance()->getDefault();
?>

	<div class="card-panel">
		<h3><?= $label ?></h3>
		<div class="row">
			<?php foreach( all_languages() as $lang ): ?>

				<?php $local_field = $field . '_' . $lang->getISO() ?>

				<div class="col s12">
					<p><?= $lang->getHuman() ?></p>

					<textarea name="<?= $local_field ?>"<?php

						// mark source language as readonly for non-owners
						if( $lang === $DEFAULT_LANGUAGE && !$event->isEventEditable() ) {
							echo " readonly";
						}

					?>><?=
						// escape textarea content
						esc_html( $event->get( $local_field ) )
					?></textarea>
				</div>
			<?php endforeach ?>
		</div>
	</div>
