<?php

/**
 * @package  MediaManagerPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;

class PostTypeController extends BaseController
{
    public $post_type = 'produit';

    public function register()
    {
        if (!$this->activated('post_type_manager')) {
            return;
        }
        add_action('init', [$this, 'register_post_type']);
    }


    public function register_post_type()
    {
        $labels = array(
            'name' => _x('Produits', 'Post Type General Name', 'MediaManagerPlugin'),
            'singular_name' => _x('Produit', 'Post Type Singular Name', 'MediaManagerPlugin'),
            'menu_name' => _x('Produits', 'Admin Menu text', 'MediaManagerPlugin'),
            'name_admin_bar' => _x('Produit', 'Add New on Toolbar', 'MediaManagerPlugin'),
            'archives' => __('Archives Produit', 'MediaManagerPlugin'),
            'attributes' => __('Attributs Produit', 'MediaManagerPlugin'),
            'parent_item_colon' => __('Parents Produit:', 'MediaManagerPlugin'),
            'all_items' => __('Tous les Produits', 'MediaManagerPlugin'),
            'add_new_item' => __('Ajouter nouvel Produit', 'MediaManagerPlugin'),
            'add_new' => __('Ajouter', 'MediaManagerPlugin'),
            'new_item' => __('Nouvel Produit', 'MediaManagerPlugin'),
            'edit_item' => __('Modifier Produit', 'MediaManagerPlugin'),
            'update_item' => __('Mettre à jour Produit', 'MediaManagerPlugin'),
            'view_item' => __('Voir Produit', 'MediaManagerPlugin'),
            'view_items' => __('Voir Produits', 'MediaManagerPlugin'),
            'search_items' => __('Rechercher dans les Produit', 'MediaManagerPlugin'),
            'not_found' => __('Aucun Produittrouvé.', 'MediaManagerPlugin'),
            'not_found_in_trash' => __('Aucun Produittrouvé dans la corbeille.', 'MediaManagerPlugin'),
            'featured_image' => __('Image mise en avant', 'MediaManagerPlugin'),
            'set_featured_image' => __('Définir l’image mise en avant', 'MediaManagerPlugin'),
            'remove_featured_image' => __('Supprimer l’image mise en avant', 'MediaManagerPlugin'),
            'use_featured_image' => __('Utiliser comme image mise en avant', 'MediaManagerPlugin'),
            'insert_into_item' => __('Insérer dans Produit', 'MediaManagerPlugin'),
            'uploaded_to_this_item' => __('Téléversé sur cet Produit', 'MediaManagerPlugin'),
            'items_list' => __('Liste Produits', 'MediaManagerPlugin'),
            'items_list_navigation' => __('Navigation de la liste Produits', 'MediaManagerPlugin'),
            'filter_items_list' => __('Filtrer la liste Produits', 'MediaManagerPlugin'),
        );
        $args = array(
            'label' => __('Produit', 'MediaManagerPlugin'),
            'description' => __('', 'MediaManagerPlugin'),
            'labels' => $labels,
            'menu_icon' => 'dashicons-buddicons-replies',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'author', 'comments', 'trackbacks', 'page-attributes', 'post-formats', 'custom-fields'),
            'taxonomies' => array('category', 'post_tag'),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'hierarchical' => true,
            'exclude_from_search' => false,
            'show_in_rest' => true,
            'publicly_queryable' => true,
            'capability_type' => 'post',
        );
        register_post_type($this->post_type, $args);
    }

    public function getPostTypeName()
    {
        return $this->post_type;
    }

    public function get_taxonomies()
    {
        $taxonomies = get_object_taxonomies($this->post_type, 'objects');
        return $taxonomies;
    }

    public function get_taxonomy_name($taxonomy)
    {
        $taxonomies = $this->get_taxonomies();
        dump($taxonomies);
        return $taxonomies[$taxonomy]->labels->name;
    }
}
