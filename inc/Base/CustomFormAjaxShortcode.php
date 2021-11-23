<?php

/**
 * @package  MediaManagerPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;
use Symfony\Component\VarDumper\Server\DumpServer;

/**
 *
 */
class CustomFormAjaxShortcode extends BaseController
{
    public function register()
    {
        add_shortcode('custom_form_ajax', [$this, 'add_form_ajax_template']);
        add_shortcode('produits_lists', [$this, 'produits_lists_shortcode']);

        add_action('wp_ajax_custom_form_ajax_call', array($this, 'custom_form_ajax_call'));
        add_action('wp_ajax_nopriv_custom_form_ajax_call', array($this, 'custom_form_ajax_call'));
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }


    public function enqueue_scripts()
    {
        wp_enqueue_style('form-ajax', $this->plugin_url . 'assets/form-ajax.css');
        wp_enqueue_script('form-ajax', $this->plugin_url . 'assets/form-ajax.js');
    }


       

    public function produits_lists_shortcode($atts)
    {
        if (isset($_POST['data'])):

            $truc = $_POST['data'];
        echo $truc;


        endif;

        $base_url= home_url();


        $cpt = get_option('mzb_plugin_cpt');
        foreach ($cpt as $key => $value) {
            $cpt_name = $value;
        }
        $tax = get_option('mzb_plugin_tax');
        foreach ($tax as $key => $value) {
            $tax_name = $value;
            foreach ($value as $key => $value) {
                $tax_query[] = array(
                    'taxonomy' => $key,
                    'field' => 'slug',
                    'terms' => $value,
                );
            }
        }

        extract(shortcode_atts(array('expand' => '',), $atts));
    
        global $paged;
        $posts_per_page = 5;
        $settings = array(
            'showposts' => $posts_per_page,
            'post_type' =>  $cpt_name,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'paged' => $paged,
           
            );
      
            
        $post_query = new \WP_Query($settings);
    
        $total_found_posts = $post_query->found_posts;
        $total_page = ceil($total_found_posts / $posts_per_page);
        
        $list = '<div class="portfolio-item-list">';
        while ($post_query->have_posts()) : $post_query->the_post();
        $list .= '
		<div class="single-portfolio-item">
            <div class="portfolio-item-thumb">
                <a href="' . get_the_permalink() . '">
                    <img src="' . get_the_post_thumbnail_url() . '" alt="">
                </a>
            </div>
            <div class="portfolio-item-content">
                <h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>
               
                <a href="' . get_the_permalink() . '" class="btn btn-primary">Voir plus</a>               
            </div>
		</div>
		';
        endwhile;
        $list.= '</div>';
    
        if (function_exists('wp_pagenavi')) {
            $list .='<div class="page-navigation">'.wp_pagenavi(array('query' => $post_query, 'echo' => false)).'</div>';
        } else {
            $list.='
        <span class="next-posts-links">'.get_next_posts_link('Next page', $total_page).'</span>
        <span class="prev-posts-links">'.get_previous_posts_link('Previous page').'</span>
        ';
            return $list;
        }
    }



       
    


    public function custom_form_ajax_call()
    {
        $base_url= home_url();
        $apiUrl = $base_url .'/wp-json/wp/v2/produit';
        $response = wp_remote_get($apiUrl);
        $responseBody = wp_remote_retrieve_body($response);
        $result = json_decode($responseBody);
        if (is_array($result) && ! is_wp_error($result)) {
            foreach ($result as $key => $value) {
                $produits[] = $value;
                print_r($produits);
            }
        } else {
            // Work with the error
            echo 'error';
        }

        wp_die();
    }
    
    public function get($resource)
    {
        $apiUrl = 'http://gestion-produits.local/wp-admin/admin-ajax.php';
        $json = file_get_contents($apiUrl.$resource);
        $result = json_decode($json);
        return $result;
    }




    
    

    public static function get_taxonomy_data()
    {
        $taxonomies = get_taxonomies(
            array(
                'public' => true,
                '_builtin' => false,
            ),
            'objects'
        );


        $save_taxonomies = [];
        if (!empty($taxonomies)) : ?>
       
         <?php ob_start(); ?>
              <form id="form-ajax" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
            <?php foreach ($taxonomies as $taxonomy) : ?>
                <h3><b> <?php echo $taxonomy->labels->name; ?>
                        <?php $save_taxonomies = get_terms([
                            'taxonomy' => $taxonomy->name,
                            'hide_empty' => false,
                        ]); ?>


                        <small>
                            <?php if (is_user_logged_in()) : ?>
                                <a href="<?php echo admin_url('edit-tags.php?taxonomy=' . $taxonomy->name . '&post_type=post'); ?>">
                                    <?php _e('Éditer', 'wp-simple-pjax'); ?>
                                </a>
                            <?php endif; ?>

                        </small>
                    </b>
                </h3>
               
                <?php if ($save_taxonomies) {
                            foreach ($save_taxonomies  as $tax) {
                                $sous_tax = get_terms($tax);
                                if (!empty($sous_tax)) {
                                    foreach ($sous_tax as $sous_taxo) {
                                        $myterms = get_terms(array('taxonomy' => $sous_taxo->taxonomy, 'parent' => 0));
                                        $myterms_children = get_terms(array('taxonomy' => $sous_taxo->taxonomy, 'parent' => $sous_taxo->term_id));

                                        if (!empty($myterms)) :
                                    if ($sous_taxo->parent == 0) {
                                        echo  '<div>';
                                        echo  '<input type="checkbox" id="' . $sous_taxo->slug . '" name="' .  $sous_taxo->slug . '">';
                                        echo  '<label for="' . $sous_taxo->name . '">' .  $sous_taxo->name . '</label>';
                                        echo  '</div>';
                                    }

                                        endif;
                                        if (!empty($myterms_children)) :
                                    echo '<ul>';
                                        foreach ($myterms_children as $key => $value_child) : ?>
                                        <div>
                                            <input class="form-check-input" type="checkbox" value="<?php echo $sous_taxo->slug; ?>" id="<?php echo $sous_taxo->slug; ?>">
                                            <label class="form-check-label" for="<?php echo $sous_taxo->slug; ?>">
                                                <?php echo $value_child->name; ?>
                                            </label>
                                        </div>
                            <?php endforeach;
                                        echo '</ul>';
                                        endif;
                                    }
                                }
                            }
                        } ?>
                        
                  
                    <?php
        endforeach; ?>  </form>  <?php
        endif;
     
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }




    public function add_form_ajax_template()
    {
        $file = $this->plugin_path . 'templates/form-ajax3.php';

     
        


        if (file_exists($file)) {
            ob_start();
            load_template($file, true, false);
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
    }
}
