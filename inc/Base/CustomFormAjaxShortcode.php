<?php

/**
 * @package  MediaManagerPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;

/**
 *
 */
class CustomFormAjaxShortcode extends BaseController
{
    public function register()
    {
        add_shortcode('custom_form_ajax', [$this, 'add_form_ajax_template']);
        add_action('wp_ajax_custom_form_ajax', array($this, 'custom_form_ajax_callback'));
        add_action('wp_ajax_nopriv_custom_form_ajax', array($this, 'custom_form_ajax_callback'));
    }


    public function enqueue()
    {
        wp_enqueue_style('auth_style', $this->plugin_url . 'assets/form-ajax.css');
        wp_enqueue_script('auth_script', $this->plugin_url . 'assets/form-ajax.js');
    }

    

    public static function get_taxonomy_data()
    {
        ob_start();

        $taxonomies = get_taxonomies(
            array(
                'public' => true,
                '_builtin' => false,
            ),
            'objects'
        );


        $save_taxonomies = [];
        if (!empty($taxonomies)) : ?>
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
                        }
        endforeach;
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
