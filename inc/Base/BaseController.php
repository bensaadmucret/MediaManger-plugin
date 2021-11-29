<?php
/**
 * @package  MediaManagerPlugin
 */
namespace Inc\Base;

class BaseController
{
    public $plugin_path;

    public $plugin_url;

    public $plugin;

    public $managers = array();

    public function __construct()
    {
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->plugin = plugin_basename(dirname(__FILE__, 3)) . '/MediaManager-plugin.php';

        $this->managers = array(
           // 'cpt_manager' => 'Activate CPT Manager',
            'taxonomy_manager' => 'Activate Taxonomy Manager',
            'custom_metabox_manager' => 'Activate Custom Metabox',
            'custom_produits_manager' => 'Activate Shortcode Produits',
            'post_type_manager' => 'Activate Post Type Produits',

        );
    }

    public function activated(string $key)
    {
        $option = get_option('mzb_plugin');

        return isset($option[ $key ]) ? $option[ $key ] : false;
    }
}
