<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://viderlab.com
 * @since             1.0.0
 * @package           ViderLab_Customizations_for_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       ViderLab Customizations for Woocommerce
 * Plugin URI:        https://viderlab.com
 * Description:       Expands options for Woocommerce
 * Version:           1.0.0
 * Author:            ViderLab
 * Author URI:        https://viderlab.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       viderlab-customizations-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( defined( 'WPINC' ) === false ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'VIDERLAB_CUSTOMIZATIONS_FOR_WOOCOMMERCE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-viderlab-customizations-for-woocommerce-activator.php
 */
function activate_viderlab_customizations_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-viderlab-customizations-for-woocommerce-activator.php';
	ViderLab_Customizations_for_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-viderlab-customizations-for-woocommerce-deactivator.php
 */
function deactivate_viderlab_customizations_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-viderlab-customizations-for-woocommerce-deactivator.php';
	ViderLab_Customizations_for_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_viderlab_customizations_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_viderlab_customizations_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-viderlab-customizations-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_viderlab_customizations_for_woocommerce() {
	$plugin = new ViderLab_Customizations_for_Woocommerce();
	$plugin->run();
}

// Test to see if WooCommerce is active (including network activated).

$plugin_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';
function viderlab_customizations_for_woocommerce_admin_notice_warning() {
	$class = 'notice notice-warning';
	$title = __( 'ViderLab Customizations for Woocommerce', 'viderlab-customizations-for-woocommerce' );
	$message = __( 'Woocommerce plugin must be installed and activated to use this plugin.', 'viderlab-customizations-for-woocommerce' );

	printf( '<div class="%1$s"><p><strong>%2$s: </strong>%3$s</p></div>', esc_attr( $class ), esc_attr( $title ), esc_html( $message ) );
}

if (
    in_array( $plugin_path, wp_get_active_and_valid_plugins() )
) {
    add_action('woocommerce_init', 'run_viderlab_customizations_for_woocommerce');
} else {
	add_action( 'admin_notices', 'viderlab_customizations_for_woocommerce_admin_notice_warning' );
}

