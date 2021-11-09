<?php
/**
 * @package  MediaManagerPlugin
 */
namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

class Dashboard extends BaseController
{
    public $settings;

    public $callbacks;

    public $callbacks_mngr;

    public $pages = array();

    public function register()
    {
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->callbacks_mngr = new ManagerCallbacks();

        $this->setPages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->register();
    }

    public function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'MediaManager Plugin',
                'menu_title' => 'MediaManager',
                'capability' => 'manage_options',
                'menu_slug' => 'mzb_plugin',
                'callback' => array( $this->callbacks, 'adminDashboard' ),
                'icon_url' => 'dashicons-welcome-view-site',
                'position' => 110
            )
        );
    }

    public function setSettings()
    {
        $args = array(
            array(
                'option_group' => 'mzb_plugin_settings',
                'option_name' => 'mzb_plugin',
                'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
            )
        );

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'mzb_admin_index',
                'title' => 'Settings Manager',
                'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
                'page' => 'mzb_plugin'
            )
        );

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = [];

        foreach ($this->managers as $key => $value) {
            $args[] = array(
                'id' => $key,
                'title' => $value,
                'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
                'page' => 'mzb_plugin',
                'section' => 'mzb_admin_index',
                'args' => array(
                    'option_name' => 'mzb_plugin',
                    'label_for' => $key,
                    'class' => 'ui-toggle'
                )
            );
        }

        $this->settings->setFields($args);
    }
}
