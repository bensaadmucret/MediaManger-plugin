<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  MediaManagerPlugin
 */

if (! defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// Clear Database stored data
$produits = get_posts(array( 'post_type' => 'produit', 'numberposts' => -1 ));

foreach ($produits as $val) {
    wp_delete_post($val->ID, true);
}

// Access the database via SQL
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'produit'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");
