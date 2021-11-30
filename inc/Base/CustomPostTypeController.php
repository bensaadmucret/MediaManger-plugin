<?php
/**
 * @package  MediaManagerPlugin
 */
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;

/**
*
*/
class CustomPostTypeController extends BaseController
{
    public $settings;

    public $callbacks;

    public $cpt_callbacks;

    public $subpages = array();

    public $custom_post_types;

    public function register()
    {
        if (! $this->activated('cpt_manager')) {
            return;
        }

        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->cpt_callbacks = new CptCallbacks();

        $this->setSubpages();

        $this->setSettings();

        $this->setSections();

        $this->setFields();

        $this->settings->addSubPages($this->subpages)->register();

        $this->storeCustomPostTypes();

        if (!empty($this->custom_post_types)) {
            add_action('init', array( $this, 'registerCustomPostTypes' ));
            flush_rewrite_rules();
        }
    }

    public function setSubpages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'mzb_plugin',
                'page_title' => 'Custom Post Types',
                'menu_title' => 'CPT Manager',
                'capability' => 'manage_options',
                'menu_slug' => 'mzb_cpt',
                'callback' => array( $this->callbacks, 'adminCpt' )
            )
        );
    }

    public function setSettings()
    {
        $args = array(
            array(
                'option_group' => 'mzb_plugin_cpt_settings',
                'option_name' => 'mzb_plugin_cpt',
                'callback' => array( $this->cpt_callbacks, 'cptSanitize' )
            )
        );

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'mzb_cpt_index',
                'title' => 'Custom Post Type Manager',
                'callback' => array( $this->cpt_callbacks, 'cptSectionManager' ),
                'page' => 'mzb_cpt'
            )
        );

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = array(
            array(
                'id' => 'post_type',
                'title' => 'Custom Post Type ID',
                'callback' => array( $this->cpt_callbacks, 'textField' ),
                'page' => 'mzb_cpt',
                'section' => 'mzb_cpt_index',
                'args' => array(
                    'option_name' => 'mzb_plugin_cpt',
                    'label_for' => 'post_type',
                    'placeholder' => 'eg. product',
                    'array' => 'post_type'
                )
            ),
            array(
                'id' => 'singular_name',
                'title' => 'Singular Name',
                'callback' => array( $this->cpt_callbacks, 'textField' ),
                'page' => 'mzb_cpt',
                'section' => 'mzb_cpt_index',
                'args' => array(
                    'option_name' => 'mzb_plugin_cpt',
                    'label_for' => 'singular_name',
                    'placeholder' => 'eg. Product',
                    'array' => 'post_type'
                )
            ),
            array(
                'id' => 'plural_name',
                'title' => 'Plural Name',
                'callback' => array( $this->cpt_callbacks, 'textField' ),
                'page' => 'mzb_cpt',
                'section' => 'mzb_cpt_index',
                'args' => array(
                    'option_name' => 'mzb_plugin_cpt',
                    'label_for' => 'plural_name',
                    'placeholder' => 'eg. Products',
                    'array' => 'post_type'
                )
            ),
            array(
                'id' => 'public',
                'title' => 'Public',
                'callback' => array( $this->cpt_callbacks, 'checkboxField' ),
                'page' => 'mzb_cpt',
                'section' => 'mzb_cpt_index',
                'args' => array(
                    'option_name' => 'mzb_plugin_cpt',
                    'label_for' => 'public',
                    'class' => 'ui-toggle',
                    'array' => 'post_type'
                )
            ),
            array(
                'id' => 'has_archive',
                'title' => 'Archive',
                'callback' => array( $this->cpt_callbacks, 'checkboxField' ),
                'page' => 'mzb_cpt',
                'section' => 'mzb_cpt_index',
                'args' => array(
                    'option_name' => 'mzb_plugin_cpt',
                    'label_for' => 'has_archive',
                    'class' => 'ui-toggle',
                    'array' => 'post_type'
                )
            )
        );

        $this->settings->setFields($args);
    }

    public function storeCustomPostTypes()
    {
        $datas = [ 0 => 'produit'];
       
        if (!empty($datas)):
           
        foreach ($datas as $key => $option):
        $this->custom_post_types[$key]['post_type'] = $option;
        $this->custom_post_types[$key]['singular_name'] = 'Produit';
        $this->custom_post_types[$key]['plural_name'] = 'Produits';
        $this->custom_post_types[$key]['public'] = true;
        $this->custom_post_types[$key]['has_archive'] = true;
        $this->custom_post_types[$key]['supports'] = array( 'title', 'editor', 'thumbnail' );
        $this->custom_post_types[$key]['taxonomies'] = array( 'category', 'post_tag' );
        $this->custom_post_types[$key]['rewrite'] = array( 'slug' => 'produit', 'with_front' => true );
        $this->custom_post_types[$key]['menu_icon'] = 'dashicons-buddicons-replies';
        $this->custom_post_types[$key]['capability_type'] = 'post';

        
        endforeach;
        endif;
    }

    public function registerCustomPostTypes()
    {
        foreach ($this->custom_post_types as $custom_post_type) {
            register_post_type($custom_post_type['post_type'], array(
                'labels' => array(
                    'name' => $custom_post_type['plural_name'],
                    'singular_name' => $custom_post_type['singular_name']
                ),
                'public' => $custom_post_type['public'],
                'has_archive' => $custom_post_type['has_archive']
            ));
        }
    }
}
