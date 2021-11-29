<?php
/**
 * @package  MediaManagerPlugin
 */
namespace Inc\Base;

use Inc\Base\BaseController;

class CustomProduitsController extends BaseController
{
    public function register()
    {
        if (! $this->activated('custom_produits_manager')) {
            return;
        }

        
        add_shortcode('list_produits_ajax', [ $this, 'add_produits_template' ]);
        add_action('wp_ajax_custom_produits_ajax', array($this, 'custom_produits_ajax_callback'));
        add_action('wp_ajax_nopriv_custom_produits_ajax', array($this, 'custom_produits_ajax_callback'));
    }


    public static function get_produits()
    {
        //$customPostType = get_option('mzb_plugin_cpt') ?: array();
        $customPostType = ['produit'];
        
        foreach ($customPostType as $key => $value) {
            $args = [
               'post_type' => $key,
               'post_status' => 'publish',
               'posts_per_page' => -1,
               'orderby' => 'title',
               'order' => 'ASC'
               
            ];
            $produits = get_posts($args);
            $customPostType[$key] = $produits;
        }
        
        return $customPostType;
    }


    public function query_ajax()
    {
        $args = [
            'post_type' => 'produit',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            's'=> $_POST['search'],
            'cat' => $_POST['cat'],
            'tag' => $_POST['tag'],
            'paged' => $_POST['paged']
        ];
        $produits = get_posts($args);
        $customPostType = $this->get_produits();
        $data = [
            'produits' => $produits,
            'customPostType' => $customPostType
        ];
        wp_send_json_success($data);
        exit();
    }

        

  

    public function add_produits_template()
    {
        ob_start();
        $file = $this->plugin_path . 'templates/produits.php';

        if (file_exists($file)) {
            load_template($file, true);
        }
        $content = ob_get_clean();
        return $content;
    }
}
