<?php
/**
 * @package  MediaManagerPlugin
 */
namespace Inc\Base;

use Inc\Base\BaseController;

/**
*
*/
class Enqueue extends BaseController
{
    public function register()
    {
        add_action('admin_enqueue_scripts', [ $this, 'enqueue' ]);
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    }
    
    public function enqueue()
    {
        wp_enqueue_style('form-ajax', $this->plugin_url . 'assets/form-ajax.css');
        wp_enqueue_script('form-ajax', $this->plugin_url . 'assets/form-ajax.js');
        wp_enqueue_script('hello-script', $this->plugin_url . 'assets/hello.js');
    }
}
