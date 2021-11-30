<?php

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

// enqueue script in admin




//add_action('admin_enqueue_scripts', 'media_manager_assets');
function media_manager_assets()
{
    wp_enqueue_script('media-manager-js', plugin_dir_url(__FILE__) . 'assets/js/dashboard.js', array(), '1.0.0', true);
    wp_enqueue_style('media-manager-css', plugin_dir_url(__FILE__) . 'assets/css/dashboard.css', array(), '1.0.0', 'all');
}
