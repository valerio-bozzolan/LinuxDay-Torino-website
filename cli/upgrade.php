#!/usr/bin/php
<?php
# Linux Day - command line interface to upgrade the database
# Copyright (C) 2018 Valerio Bozzolan
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

// allowed only from command line interface
isset( $argv[ 0 ] ) or exit( 1 );

// autoload the framework
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'load.php';

// check if the aristocratic title is created
safe_alter_table_add_column_after( User::T, User::ARISTOCRATIC_TITLE, 'VARCHAR(16)', User::UID );

/**
 * Check if a table field does not exist
 *
 * @param $table string Table name
 * @param $wanted_field string
 */
function is_table_field_missing( $table, $wanted_field ) {
	$fields = query_results( sprintf(
		'DESCRIBE %s',
		T( $table )
	) );
	foreach( $fields as $field ) {
		if( $field->Field === $wanted_field ) {
			return false;
		}
	}
	return true;
}

/**
 * Alter table and add a column
 *
 * @param $title string Table name
 * @param $what string Column name
 * @param $definition string Column definition
 * @param $after string Column name
 */
function safe_alter_table_add_column_after( $table, $what, $definition, $after ) {
	if( is_table_field_missing( $table, $what ) ) {
		query( sprintf(
			'ALTER TABLE %s ADD COLUMN %s %s AFTER %s',
			T( $table ),
			$what,
			$definition,
			$after
		) );
	}
}
