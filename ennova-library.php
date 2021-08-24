<?php

/**
 * Plugin Name:       Ennova Library
 * Plugin URI:        https://themeansar.com/
 * Description:       Ennova Library for Importing demo data Themeansar Theme.
 * Version:           0.3
 * Author:            Themeansar
 * Author URI:        https://themeansar.com/
 * Text Domain:       ennova-library
 * Domain Path:       /languages
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('Ennova_Library_VERSION', '0.3');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ennova-import-activator.php
 */
function activate_ennova_import() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-ennova-import-activator.php';
    Ansar_Import_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ennova-import-deactivator.php
 */
function deactivate_ennova_import() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-ennova-import-deactivator.php';
    Ennova_Import_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_ennova_import');
register_deactivation_hook(__FILE__, 'deactivate_ennova_import');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-ennova-import.php';
require plugin_dir_path(__FILE__) . 'includes/parsers.php';

if (!class_exists('WP_Importer')) {
    $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
    if (file_exists($class_wp_importer)) {
        require_once( $class_wp_importer );
    } else {
        $importer_error = true;
    }
}
require plugin_dir_path(__FILE__) . 'includes/class-wp-import.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ennova_import() {

    $plugin = new Ennova_library();
    $plugin->run();
}

run_ennova_import();