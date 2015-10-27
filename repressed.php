<?php
/**
 * Plugin Name: Repressed
 * Plugin URI: http://www.austinplunkett.com/software/repressed
 * Description: Add links to blog posts from your friends and colleagues to any post or page in your blog. Content syndication.
 * Version: 0.0.4
 * Author: Austin Plunkett
 * Author URI: http://www.austinplunkett.com/software
 * License: GPL2
 */

/*  Copyright 2014  Austin Plunkett

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once(dirname(dirname(__FILE__)) . '/repressed/simplepie/autoloader.php');
// require_once(dirname(dirname(__FILE__)) . '/repressed/simplepie/library/SimplePie/Cache/Extras.php');

register_activation_hook(__FILE__,'repressed_activate');
register_uninstall_hook(__FILE__,'repressed_remove');

add_action('repressed_repress','repressed_repress');
add_action('admin_init','register_my_settings');
