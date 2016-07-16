<?php
# Linux Day 2016 - Documentation generator
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

class APIDocumentation {
	function __construct( $p, $description, $params = [], $request = 'GET' ) {
		force_array($params) ?>

		<div class="col s12 m6">
			<div class="card-panel">
				<h3><?php printf(
					_("API (%s) %s"),
					$request,
					HTML::a(URL . "/api/$p", $p)
				) ?></h3>
				<p><?php printf(
					_("<strong>Scopo:</strong> %s"),
					$description
				) ?></p>

				<?php if( $params ): ?>

					<table border="1">
						<tr>
							<th><?php _e("Argomento") ?></th>
							<th><?php _e("Tipo") ?></th>
							<th><?php _e("Commento") ?></th>
						</tr>
						<?php foreach($params as $param): ?>

						<tr>
							<?php
								$arg = $param->getArg();
								if( $param->isOptional() ) {
									$arg = "<code>[</code> $arg <code>]</code>";
								}
							?>

							<td><?php echo $arg ?></td>
							<td><em>&lt;<?php echo $param->getType() ?>&gt;</em></td>
							<td><?php echo $param->getComment() ?></td>
						</tr>
						<?php endforeach ?>

					</table>
				<?php endif ?>

			</div>
		</div>

		<?php
	}
}
