<?php
/**
 * @package  MediaManagerPlugin
 */
namespace Inc\Base;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();

		$default = array();

		if ( ! get_option( 'mzb_plugin' ) ) {
			update_option( 'mzb_plugin', $default );
		}

		if ( ! get_option( 'mzb_plugin_cpt' ) ) {
			update_option( 'mzb_plugin_cpt', $default );
		}

		if ( ! get_option( 'mzb_plugin_tax' ) ) {
			update_option( 'mzb_plugin_tax', $default );
		}
	}
}