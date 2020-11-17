<?php
/**
Plugin Name: Plugin Notes
Plugin URI: https://github.com/nickthegeek/plugin-notes
Description: Adds a setting screen where notes about plugins can be added.
Author: Nick the Geek
Version: 1.0
Requires at least: 5.4
Author URI: https://designsbynickthegeek.com

Text Domain: plugin-notes
Domain Path: /languages

@package plugin-notes
 */

/*
	Copyright 2020 Nick Croft

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; version 2 of the License (GPL v2) only.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

namespace Plugin\Notes;

define( 'PLUGIN_NOTES_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_NOTES_URL', plugin_dir_url( __FILE__ ) );

/**
 * Loads the text domain.
 *
 * @return void
 */
function plugins_loaded() {
	load_plugin_textdomain( 'plugin_notes', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\plugins_loaded' );

/**
 * Initializer.
 */
require_once PLUGIN_NOTES_DIR . 'inc/classes/class-init.php';

$plugin_notes_init = new Init();
