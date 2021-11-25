<?php

namespace Inc\Base;

use Inc\Base\BaseController;

class GestionProduitsAjax extends BaseController
{
    public function __construct()
    {
        add_action('wp_ajax_gestion_produits_ajax_action', [$this, 'gestion_produits_ajax_action']);
        add_action('wp_ajax_nopriv_gestion_produits_ajax_action', [$this, 'gestion_produits_ajax_action']);
        add_shortcode('shortcode_form_search', [$this,  'shortcode_form_search']);
        add_shortcode('produits_list', [$this,  'shortcode_produits_list']);
    }



    public function gestion_produits_ajax_action()
    {
        if (!wp_verify_nonce($_POST['gestionproduits'], '_gestion_produits')) {
            console . log('nonce error');
        } else {
            $term = $_POST['term'];
            $term = sanitize_text_field($_POST['term']);
            $args = array(
                'post_type' => 'produit',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                's' => $term
            );

            $query = new WP_Query($args);
            $results = array();
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $results[] = array(
                        'id' => get_the_ID(),
                        'text' => get_the_title(),
                        'link' => get_the_permalink(),
                        'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),

                    );
                }
            }
            wp_send_json($results);
        }
    }






    public function shortcode_form_search()
    {
        /* $html = '';
         $html  .= '<div id="content" class="content" ></div>';
         $html .= '<form name="RegForm" action="' . admin_url('admin-ajax.php') . '" method="post" id="gestion_produits_ajax_form">';
         $html .= wp_nonce_field('_gestion_produits', 'gestionproduits', true, true);
         $html .= '<input type="text" name="term" value="" id="term" placeholder="Rechercher un produit">';
         $html .= '<input type="hidden" name="action" value="gestion_produits_ajax_action">';
         $html .= '<input type="submit" value="Rechercher">';
         $html .= '</form>';
         return $html;*/

        $html = '<div class="container">
            <h1>Media Manager </h1>
            <div id="searchWrapper">
                <input
                    type="text"
                    name="searchBar"
                    id="searchBar"
                    placeholder="search for a character"
                />
            </div>
            <ul id="produitList"></ul>
        </div>';
        
         



        return $html;
    }

    public function traitement_ajax_call()
    {
        $term = $_POST['term'];
        $term = sanitize_text_field($_POST['term']);
        $args = array(
            'post_type' => 'produit',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            's' => $term
        );

        $query = new \WP_Query($args);
        $results = array();
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $results[] = array(
                    'id' => get_the_ID(),
                    'text' => get_the_title(),
                    'link' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),

                );
            }
        }
        wp_send_json($results);
        wp_die();
    }

    public function shortcode_produits_list()
    {
        $args = array(
            'post_type' => 'produit',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
        $query = new \WP_Query($args);
        $html = '';
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                //$html .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
                // include_once plugin_dir_path(__FILE__) . 'template/card.php';
                ob_start();

                $html .= '<main role="main">
                <div class="product">
                    <figure>
                    <img src="' . get_the_post_thumbnail_url(get_the_ID(), 'medium') . '" alt="Product Image" class="product-image">
                        </figure>

                    <div class="product-description">

                        <div class="info">
                        <h1><a href="' . get_the_permalink() . '">' . get_the_title() . ' </a></h1>
                        <p>
                            Lorem Ipsum is simply dummy
                            printing and typesetting industry
                        </p>
                        </div>      
                    </div>

                    <div class="product-sidebar">
                        <button class="buy">
                        <span><a href="' . get_the_permalink() . '">DEVIS </a></span>
                        </button>

                        <button class="info">
                        <span>INFO</span>
                        </button>
                    </div>
                    </div>
                    </main>';
            }
        }

        return $html;
    }
}

new GestionProduitsAjax();
