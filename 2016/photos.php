<?php
# Linux Day 2016 - Credits
# Copyright (C) 2016, 2017 Valerio Bozzolan, Rosario Antoci, Linux Day Torino
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

define('PHOTOS', '/photos');

$alt = esc_attr( sprintf(
	_("foto %s"),
	SITE_NAME
) );

Header::spawn('photos');
?>
	<div class="section">
		<p class="flow-text"><?php _e("Alcuni scatti dal Linux Day 2016 a Torino.") ?></p>
		<div class="row">
			<?php if( $handle = opendir(ABSPATH . CONFERENCE_DIR . STATIC_DIR . PHOTOS ) ): ?>
				<?php while (false !== ($entry = readdir($handle) ) ): ?>
					<?php if( $entry === '.' || $entry === '..' ) continue ?>

					<div class="col s12 m3">
						<img class="responsive-img ld-photo materialboxed" src="<?php echo XXX . PHOTOS . _ . $entry ?>" alt="<?php echo $alt ?>" />
					</div>

				<?php endwhile ?>

				<?php closedir($handle) ?>
			<?php endif ?>
		</div>
	</div>

<?php

Footer::spawn( [ 'home' => false ] );
