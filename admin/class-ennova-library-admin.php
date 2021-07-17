<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeansar.com/
 * @since      1.0.0
 *
 * @package    Ennova_Library
 * @subpackage Ennova_Library/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ennova_Library
 * @subpackage Ennova_Library/admin
 * @author     Themeansar <info@themeansar.com>
 */
class Ennova_Library_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function import_data_ajax() {
        $ennova_libraryer = new Ennova_Library();
        $ennova_libraryer->install_demo(sanitize_key($_POST['theme_id']));
    }

    public function register_theme_page() {


        add_theme_page('Ennova Demos Library', 'Ennova Demos Library', 'read', 'ennova-demo-library', array($this, 'theme_option_page'));
    }

    /**
     * Render the options page for plugin
     *
     * @since  1.0.0
     */
    public function theme_option_page() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/ennova-library-admin-display.php';
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ennova_Library_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ennova_Library_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if (isset($_GET['page']) == 'ennova-demo-library') {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ennova-library-admin.css', array(), $this->version, 'all');
            wp_enqueue_style('uikit', plugin_dir_url(__FILE__) . 'css/uikit.min.css', array(), $this->version, 'all');
            wp_enqueue_style('theme');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ennova_Library_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ennova_Library_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        //$themes = wp_prepare_themes_for_js( array( wp_get_theme() ) );


        if (isset($_GET['page']) == 'ennova-demo-library') {
            // wp_enqueue_script('theme');

            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ennova-library-admin.js', array('jquery'), $this->version, false);
            wp_enqueue_script('uikit-js', plugin_dir_url(__FILE__) . 'js/uikit.min.js', array('jquery'), $this->version, false);
        }
        $theme_data = wp_get_theme();
        $theme_name = $theme_data->get('Name');
        $theme_slug = $theme_data->get('TextDomain');
        wp_localize_script($this->plugin_name, 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('check-sec'), 'theme_name' => $theme_name));

        $theme_data_api = wp_remote_get(esc_url_raw("https://wpennova.com/wp-json/wp/v2/demos/?search=%27" . urlencode($theme_name) . "%27"));
        $theme_data_api_body = wp_remote_retrieve_body($theme_data_api);
        $all_demos = json_decode($theme_data_api_body, TRUE);

        wp_localize_script($this->plugin_name, 'ansar_theme_object', $all_demos);
    }

}
