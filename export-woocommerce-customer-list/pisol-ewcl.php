<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              piwebsolution.com
 * @since             2.1.64
 * @package           Pisol_Ewcl
 *
 * @wordpress-plugin
 * Plugin Name:       Export customers list csv for WooCommerce, WordPress users csv, export Guest customer list
 * Plugin URI:        piwebsolution.com/get-a-quotation/
 * Description:       Export customer list from WooCommerce with one click
 * Version:           2.1.64
 * Author:            PI Websolution
 * Author URI:        piwebsolution.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pisol-ewcl
 * Domain Path:       /languages
 * WC tested up to: 9.5.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


if(is_plugin_active( 'export-woocommerce-customer-list-pro/pisol-ewcl.php')){
    function pi_ewcl_free_error_notice() {
        ?>
        <div class="error notice">
            <p><?php echo esc_html__( 'You have the PRO version of this plugin','pisol-ewcl'); ?></p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'pi_ewcl_free_error_notice' );
    deactivate_plugins(plugin_basename(__FILE__));
    return;
}else{

if(!is_plugin_active( 'woocommerce/woocommerce.php')){
	function pi_ewcl_free_woo_error_notice() {
		?>
		<div class="error notice">
			<p><?php _e( 'Please Install and Activate WooCommerce plugin, without that this plugin cant work', 'pisol-ewcl' ); ?></p>
		</div>
		<?php
	}
	add_action( 'admin_notices', 'pi_ewcl_free_woo_error_notice' );
	return;
}

/**
 * Currently plugin version.
 * Start at version 2.1.64 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PISOL_EWCL_VERSION', '2.1.64' );
define( 'PI_EWCL_DELETE_SETTING', false );
define( 'PI_EWCL_PRICE', '$25' );
define( 'PI_EWCL_BUY_URL', 'https://www.piwebsolution.com/checkout/?add-to-cart=1596&variation_id=1597&utm_campaign=export_customer&utm_source=website&utm_medium=direct-buy' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pisol-ewcl-activator.php
 */
function activate_pisol_ewcl() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pisol-ewcl-activator.php';
	Pisol_Ewcl_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pisol-ewcl-deactivator.php
 */
function deactivate_pisol_ewcl() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pisol-ewcl-deactivator.php';
	Pisol_Ewcl_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pisol_ewcl' );
register_deactivation_hook( __FILE__, 'deactivate_pisol_ewcl' );

/**
 * Declare compatible with HPOS new order table 
 */
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pisol-ewcl.php';

function pisol_ewcl_plugin_link( $links ) {
	$links = array_merge( array(
        '<a href="' . esc_url( admin_url( '/admin.php?page=pisol-ewcl-notification' ) ) . '">' . __( 'Settings' ,'pisol-ewcl') . '</a>',
        '<a style="color:#0a9a3e; font-weight:bold;" target="_blank" href="' . esc_url(PI_EWCL_BUY_URL) . '">' . __( 'Buy PRO Version','pisol-ewcl' ) . '</a>'
	), $links );
	return $links;
}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'pisol_ewcl_plugin_link' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pisol_ewcl() {

	$plugin = new Pisol_Ewcl();
	$plugin->run();

}
run_pisol_ewcl();

}