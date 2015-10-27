<?php
/**
 * Plugin Name: Repressed
 * Plugin URI: http://example.com
 * Description: Add links to blog posts from your friends and colleagues to any post or page in your blog. Content syndication.
 * Version: 0.0.4
 * Author: Austin Plunkett
 * Author URI: http://example.com/author
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

function repressed_repress($title, $pre, $post, $footnote) {
    if( is_single() ) {
        echo '<div class="repressed_block">' . "\n";
        echo $pre . $title . $post . "\n";
        echo '<ul class="repressed_list">' . "\n";
        if (get_option('repressed_data')) {
            $options = get_option('repressed_data');
            foreach ($options as $op) {
                $p = repress_blog($op);
                if ($p) {
                    echo '<li class="repressed_title">';
                    echo '<a class="repressed_link" rel="nofollow" href="' . $p['link'] . '">' . $p['title'] . '</a>';
                    echo '<ul class="repressed_snippet_list">';
                    echo '<li class="repressed_snippet_item">' . $p['snippet'] . '</li>';
                    echo '</ul>';
                    echo '</li>' . "\n";
                }
            }
        }
        echo '</ul>' . "\n";
        echo '<div class="repressed_footnote">' . $footnote . '</div>' . "\n";
        echo '</div>' . "\n";
    }
    return TRUE;
}

function repressed_cache_dirname() {
    $d = dirname(dirname(__FILE__)) . '/repressed/cache';
    return $d;
}

function repressed_cache_filename($f) {
    $f = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $f));
    $f = preg_replace("/[^a-zA-Z0-9]+$/","",$f);
    return $f;
}

function repress_blog($feed_url) {
    $output = array();
    $output[snippet] = '';
    $output[title] = '';
    $output[link] = '';

    if (filter_var($feed_url, FILTER_VALIDATE_URL)) {
        /* Check in cache if we've collected the latest post from this blog within past 24 hours */
        $cache_file = repressed_cache_dirname() . '/' . repressed_cache_filename($feed_url);

        /* Cache the whole RSS to a file if the file isn't there, or if it's older than 24 hours */
        $expire_seconds = 86400;
        $expire_date = time() + $expire_seconds;

        $max = 3; /* Number of posts to collect from each feed */

        $feed = new SimplePie();

        $feed->set_feed_url($feed_url);
        $feed->set_cache_name_function('repressed_cache_filename');
        $feed->enable_order_by_date(true);
        $feed->set_cache_duration($expire_seconds);
        $feed->set_cache_location(repressed_cache_dirname());
        $feed->enable_cache(true);
        $feed->set_timeout(3);
        $feed->set_item_limit($max);
        $feed->init();

        $post_title = array();
        $post_link = array();
        $post_snip = array();
        $post_date = array();

        $snip_words = 15; /* Length of snippet in words */

        foreach ($feed->get_items() as $item) {
            array_push($post_title, $item->get_title());
            array_push($post_link, $item->get_link());
            $snip = substr(strip_tags($item->get_content()), 0, 500);
            $snip = implode(" ", array_slice( explode(" ", $snip), 0, $snip_words) );
            $snip = preg_replace('/\s*$/','...',$snip);
            array_push($post_snip, $snip);
        }

        $output[title] = $post_title[0];
        $output[link] = $post_link[0];
        $output[snippet] = $post_snip[0];

        return $output;

    } else {
        return FALSE;
    }
}

function register_my_settings() {
    register_setting('repressed_options','repressed_data');
}

function repressed_activate() {
    if (false == get_option('repressed_data')) { add_option('repressed_data'); }
}
function repressed_remove() { delete_option('repressed_data'); }

if ( is_admin() ){
    /* Call the html code */
    add_action('admin_menu', 'repressed_admin_menu');

    function repressed_admin_menu() {
        add_options_page('Repressed', 'Repressed', 'manage_options', 'repressed_options', 'repressed_html_page');
    }
}

function repressed_html_page() {
?>
<div>
<h2>Repressed Options</h2>

Paste here the URLs of up to 5 RSS or Atom feeds. Most RSS or Atom formats should work, see <a href="http://simplepie.org/">SimplePie</a> for details. Absolutely NO ERROR CHECKING is done here, although failed feeds shouldn't generate errors (as far as I'm aware!)

<br /><br />

<form method="post" action="options.php">
<?php
    settings_fields( 'repressed_options' );
    do_settings_sections( 'repressed_options' );
    $options = get_option('repressed_data');
?>

<table>
    <tr><td><input name="repressed_data[option1]" type="text" value="<?php echo $options['option1'] ?>"></td></tr>
    <tr><td><input name="repressed_data[option2]" type="text" value="<?php echo $options['option2'] ?>"></td></tr>
    <tr><td><input name="repressed_data[option3]" type="text" value="<?php echo $options['option3'] ?>"></td></tr>
    <tr><td><input name="repressed_data[option4]" type="text" value="<?php echo $options['option4'] ?>"></td></tr>
    <tr><td><input name="repressed_data[option5]" type="text" value="<?php echo $options['option5'] ?>"></td></tr>
</table>

<?php submit_button(); ?>

</form>
</div>
<?php
}
?>
