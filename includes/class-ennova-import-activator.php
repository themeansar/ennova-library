<?php

/**
 * Fired during plugin activation
 *
 * @link       https://themeansar.com/
 * @since      1.0.0
 *
 * @package    Ennova_Library
 * @subpackage Ennova_Library/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ennova_Library
 * @subpackage Ennova_Library/includes
 * @author     Themeansar <info@themeansar.com>
 */
class Ennova_Library_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        $tehme_data = wp_get_theme();
        if ($tehme_data->get('Author') != 'themeansar' && $tehme_data->get('Author') != 'Themeansar' ) {
            echo esc_html('<h3>' . __('Ennova Library - This plugin requires Official <a href="https://themeansar.com/">Theme Ansar</a> Theme to be activated to work.', 'ennova-library') . '</h3>');

            //Adding @ before will prevent XDebug output
            @trigger_error(__('Ennova Library - This plugin requires Official Theme Ansar Theme to be activated to work.', 'ennova-library'), E_USER_ERROR);
            wp_die();
        }
    }

}
