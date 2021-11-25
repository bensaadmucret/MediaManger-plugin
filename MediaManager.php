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
        $tax_name = $key;
    }
    $args = array(
            'post_type' => $cpt_name,
            'posts_per_page' => -1,
           /* 'tax_query' => array(
                array(
                    'taxonomy' => $value,
                    'field' => 'slug',
                    'terms' => $key
                )
            )*/
        );
    $query = new WP_Query($args);
    $posts = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $posts[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'content' => get_the_content(),
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                    'medium' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                    'large' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                    'full' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                    'excerpt' => get_the_excerpt(),
                    'permalink' => get_the_permalink(),
                    'author' => get_the_author(),
                    'author_url' => get_author_posts_url(get_the_author_meta('ID')),
                    'post_date' => get_the_date(),
                    'post_date_gmt' => get_the_date('Y-m-d H:i:s', '', '', true),
                    'post_modified' => get_the_modified_date(),
                    'post_modified_gmt' => get_the_modified_date('Y-m-d H:i:s', '', '', true),
                    'post_status' => get_post_status(),
                    'taxonomy' => get_the_terms(get_the_ID(), $tax_name),
                   
              
                    'post_name' => get_post_field('post_name', get_the_ID()),
                
                    'post_content_filtered' => get_post_field('post_content_filtered', get_the_ID()),
                );
        }

    
        /*$posts = get_posts($args);
        $data = array();
        foreach ($posts as $post) {
            $data[] = array(
                'id' => $post->ID,
                'title' => $post->post_title,
                'content' => $post->post_content,
                'thumbnail' => get_the_post_thumbnail_url($post->ID),
                'link' => get_permalink($post->ID),
                'date' => $post->post_date,
                'author' => get_the_author_meta('display_name', $post->post_author),
                'author_link' => get_author_posts_url($post->post_author),
                'categories' => get_the_category($post->ID),
                'tags' => get_the_tags($post->ID),
                'comments' => get_comments_number($post->ID),
                'taxonomy' => get_the_terms( int|WP_Post $post, string $taxonomy )

             );
        }*/
    
        // wp_send_json($data);
        wp_send_json($posts);
    }
}






/**
 * https://github.com/BraadMartin/better-rest-api-featured-images/blob/master/better-rest-api-featured-images.php
 *   Adds a top-level field with featured image data including available sizes and URLs to the post object returned by the REST API.
 */

add_action('plugins_loaded', 'better_rest_api_featured_images_load_translations');
/**
 * Load translation files.
 *
 * @since  1.2.0
 */
function better_rest_api_featured_images_load_translations()
{
    load_plugin_textdomain('better-rest-api-featured-images', false, basename(dirname(__FILE__)) . '/languages/');
}

add_action('init', 'better_rest_api_featured_images_init', 12);
/**
 * Register our enhanced better_featured_image field to all public post types
 * that support post thumbnails.
 *
 * @since  1.0.0
 */
function better_rest_api_featured_images_init()
{
    $post_types = get_post_types(array( 'public' => true ), 'objects');

    foreach ($post_types as $post_type) {
        $post_type_name     = $post_type->name;
        $show_in_rest       = (isset($post_type->show_in_rest) && $post_type->show_in_rest) ? true : false;
        $supports_thumbnail = post_type_supports($post_type_name, 'thumbnail');

        // Only proceed if the post type is set to be accessible over the REST API
        // and supports featured images.
        if ($show_in_rest && $supports_thumbnail) {

            // Compatibility with the REST API v2 beta 9+
            if (function_exists('register_rest_field')) {
                register_rest_field(
                    $post_type_name,
                    'better_featured_image',
                    array(
                        'get_callback' => 'better_rest_api_featured_images_get_field',
                        'schema'       => null,
                    )
                );
            } elseif (function_exists('register_api_field')) {
                register_api_field(
                    $post_type_name,
                    'better_featured_image',
                    array(
                        'get_callback' => 'better_rest_api_featured_images_get_field',
                        'schema'       => null,
                    )
                );
            }
        }
    }
}

/**
 * Return the better_featured_image field.
 *
 * @since   1.0.0
 *
 * @param   object  $object      The response object.
 * @param   string  $field_name  The name of the field to add.
 * @param   object  $request     The WP_REST_Request object.
 *
 * @return  object|null
 */
function better_rest_api_featured_images_get_field($object, $field_name, $request)
{

    // Only proceed if the post has a featured image.
    if (! empty($object['featured_media'])) {
        $image_id = (int)$object['featured_media'];
    } elseif (! empty($object['featured_image'])) {
        // This was added for backwards compatibility with < WP REST API v2 Beta 11.
        $image_id = (int)$object['featured_image'];
    } else {
        return null;
    }

    $image = get_post($image_id);

    if (! $image) {
        return null;
    }

    // This is taken from WP_REST_Attachments_Controller::prepare_item_for_response().
    $featured_image['id']            = $image_id;
    $featured_image['alt_text']      = get_post_meta($image_id, '_wp_attachment_image_alt', true);
    $featured_image['caption']       = $image->post_excerpt;
    $featured_image['description']   = $image->post_content;
    $featured_image['media_type']    = wp_attachment_is_image($image_id) ? 'image' : 'file';
    $featured_image['media_details'] = wp_get_attachment_metadata($image_id);
    $featured_image['post']          = ! empty($image->post_parent) ? (int) $image->post_parent : null;
    $featured_image['source_url']    = wp_get_attachment_url($image_id);

    if (empty($featured_image['media_details'])) {
        $featured_image['media_details'] = new stdClass;
    } elseif (! empty($featured_image['media_details']['sizes'])) {
        $img_url_basename = wp_basename($featured_image['source_url']);
        foreach ($featured_image['media_details']['sizes'] as $size => &$size_data) {
            $image_src = wp_get_attachment_image_src($image_id, $size);
            if (! $image_src) {
                continue;
            }
            $size_data['source_url'] = $image_src[0];
        }
    } elseif (is_string($featured_image['media_details'])) {
        // This was added to work around conflicts with plugins that cause
        // wp_get_attachment_metadata() to return a string.
        $featured_image['media_details'] = new stdClass();
        $featured_image['media_details']->sizes = new stdClass();
    } else {
        $featured_image['media_details']['sizes'] = new stdClass;
    }

    return apply_filters('better_rest_api_featured_image', $featured_image, $image_id);
}
