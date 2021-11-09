<?php

    namespace Inc\Base;

    use Inc\Base\BaseController;
  
    /**
    *
    */
    class CustomMetaboxController extends BaseController
    {
        public function register()
        {
            if (! $this->activated('custom_metabox_manager')) {
                return;
            }
            add_action('cmb2_init', [$this,'cmb2_sample_metaboxes']);
        }

        
        /**
         * Define the metabox and field configurations.
         */
        public function cmb2_sample_metaboxes()
        {
            $output = get_option('mzb_plugin_cpt');
           
            foreach ($output as $key => $value) {
                $prefix = 'mzb_plugin_cpt_';
                $cmb_demo = new_cmb2_box([
                    'id'            => $prefix . $key,
                    'title'         => __('Test Metabox', 'cmb2'),
                    'object_types'  => [$key], // Post type
                    'context'       => 'normal',
                    'priority'      => 'high',
                    'show_names'    => true, // Show field names on the left
                    // 'cmb_styles' => false, // false to disable the CMB stylesheet
                    // 'closed'     => true, // Keep the metabox closed by default
                ]);
                $cmb_demo->add_field([
                    'name'       => __('Test Text', 'cmb2'),
                    'desc'       => __('field description (optional)', 'cmb2'),
                    'id'         => $prefix . 'text',
                    'type'       => 'text',
                    'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
                    // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
                    // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
                    // 'on_front'        => false, // Optionally designate a field to wp-admin only
                    //'repeatable'      => true,
                    'column'          => true, // Display field value in the admin post-listing columns
                ]);

                $cmb_demo->add_field([
                    'name'       => __('Test Text Area', 'cmb2'),
                    'desc'       => __('field description (optional)', 'cmb2'),
                    'id'         => $prefix . 'textarea',
                    'type'       => 'textarea',
                    'repeatable' => true,
                    'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
                    // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
                    // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
                    // 'on_front'        => false, // Optionally designate a field to wp-admin only
                    // 'repeatable'      => true,
                    'column'          => true, // Display field value in the admin post-listing columns
                ]);

                $cmb_demo->add_field([
                    'name'       => __('Test Date Picker', 'cmb2'),
                    'desc'       => __('field description (optional)', 'cmb2'),
                    'id'         => $prefix . 'textdate',
                    'type'       => 'text_date',
                    // 'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
                    // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
                    // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
                    // 'on_front'        => false, // Optionally designate a field to wp-admin only
                    // 'repeatable'      => true,
                    'column'          => true, // Display field value in the admin post-listing columns
                ]);

                $cmb_demo->add_field([
                    'name'       => __('Test Title Weeeee', 'cmb2'),
                    'desc'       => __('field description (optional)', 'cmb2'),
                    'id'         => $prefix . 'title',
                    'type'       => 'title',
                    // 'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
                    // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
                    // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
                    // 'on_front'        => false, // Optionally designate a field to wp-admin only
                    // 'repeatable'      => true,
                    'column'          => true, // Display field value in the admin post-listing columns
                ]);
            }
        }
    }

    new CustomMetaboxController();
