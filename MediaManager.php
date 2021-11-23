<?php
/**
 * @package  MediaManagerPlugin
 */
/*
Plugin Name: MediaManager Plugin
Plugin URI:
Description: MediaManager Plugin
Version: 1.0.0
Author:
Author URI:
License: GPLv2 or later
Text Domain: MediaManager-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// If this file is called firectly, abort!!!
defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}






/**
 * The code that runs during plugin activation
 */
function activate_mzb_plugin()
{
    Inc\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_mzb_plugin');

/**
 * The code that runs during plugin deactivation
 */
function deactivate_mzb_plugin()
{
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_mzb_plugin');





/**
 * Initialize all the core classes of the plugin
 */
if (class_exists('Inc\\Init')) {
    Inc\Init::registerServices();
}


/**
 * Initialize route API custom
 * example: http://gestion-produits.local/wp-json/wp/v2/media_manager
 */

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/media_manager/', array(
    'methods' => 'GET',
    'callback' => 'media_manager'
    ));
});

//callback function for rest api
// ref : https://therichpost.com/wordpress-rest-api-to-get-custom-post-type-posts/
/**
 * REST API TO GET CUSTOM POST TYPE POSTS
 *
 * @return void
 */
function media_manager()
{
    $cpt = get_option('mzb_plugin_cpt');
    $tax = get_option('mzb_plugin_tax');
    foreach ($cpt as $key => $value) {
        $cpt_name = $value;
    }

    foreach ($tax as $key => $value) {
        $tax_query[] = array(
                'taxonomy' => $key,
                'field' => 'slug',
                'terms' => $value,
            );
        foreach ($tax_query as $key => $value) {
            $tax_query_array[] = $value;
        }
    }
    $args = array(
            'post_type' =>  $cpt_name,
           // 'tax_query' => $tax_query,
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        );
        
    
    $posts = get_posts($args);
    $data = array();
    foreach ($posts as $post) {
        $data[] = array(
            'id' => $post->ID,
            'title' => $post->post_title,
            //'content' => $post->post_content,
            'thumbnail' => get_the_post_thumbnail_url($post->ID),
            'link' => get_permalink($post->ID),
            'date' => $post->post_date,
            'author' => get_the_author_meta('display_name', $post->post_author),
         );
    }
    
    wp_send_json($data);
}


function my_plugin_rest_route_for_term($route, $term)
{
    if ($term->taxonomy === 'genre') {
        $route = '/wp/v2/genre/' . $term->term_id;
    }
 
    return $route;
}
add_filter('rest_route_for_term', 'my_plugin_rest_route_for_term', 10, 2);
