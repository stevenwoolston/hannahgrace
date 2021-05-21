<?php
/*
 * Plugin Name: Woocommerce Add-to-Cart Custom Redirect
 * Plugin URI: https://wc-redirects.com/
 * Description: Redirect customers to a defined URL after a WooCommerce product is added to the cart.
 * Author: Ren Ventura
 * Author URI: https://renventura.com/
 * Version: 1.2.9
 * Text Domain: woocommerce-add-to-cart-redirect
 * WC tested up to: 5.1
 *
 * License: GPL 2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

 /*
	Copyright 2017  Ren Ventura

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	Permission is hereby granted, free of charge, to any person obtaining a copy of this
	software and associated documentation files (the "Software"), to deal in the Software
	without restriction, including without limitation the rights to use, copy, modify, merge,
	publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons
	to whom the Software is furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all copies or
	substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

//* Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RV_Custom_WooCommerce_Redirects' ) ) :

class RV_Custom_WooCommerce_Redirects {

	private static $instance;

	private $meta_key = '_rv_woo_product_custom_redirect_url';

	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof RV_Custom_WooCommerce_Redirects ) ) {
			
			self::$instance = new RV_Custom_WooCommerce_Redirects;

			self::$instance->constants();
			self::$instance->includes();
			self::$instance->hooks();
		}

		return self::$instance;
	}

	/**
	 *	Constants
	 */
	public function constants() {

		// Plugin version
		if ( ! defined( 'RV_CUSTOM_WC_REDIRECTS_VERSION' ) ) {
			define( 'RV_CUSTOM_WC_REDIRECTS_VERSION', '1.2.7' );
		}

		// Database version
		if ( ! defined( 'RV_CUSTOM_WC_REDIRECTS_DATABASE_VERSION' ) ) {
			define( 'RV_CUSTOM_WC_REDIRECTS_DATABASE_VERSION', '1.0' );
		}

		// Plugin file
		if ( ! defined( 'RV_CUSTOM_WC_REDIRECTS_PLUGIN_FILE' ) ) {
			define( 'RV_CUSTOM_WC_REDIRECTS_PLUGIN_FILE', __FILE__ );
		}

		// Plugin basename
		if ( ! defined( 'RV_CUSTOM_WC_REDIRECTS_PLUGIN_BASENAME' ) ) {
			define( 'RV_CUSTOM_WC_REDIRECTS_PLUGIN_BASENAME', plugin_basename( RV_CUSTOM_WC_REDIRECTS_PLUGIN_FILE ) );
		}

		// Plugin directory path
		if ( ! defined( 'RV_CUSTOM_WC_REDIRECTS_PLUGIN_DIR_PATH' ) ) {
			define( 'RV_CUSTOM_WC_REDIRECTS_PLUGIN_DIR_PATH', trailingslashit( plugin_dir_path( RV_CUSTOM_WC_REDIRECTS_PLUGIN_FILE )  ) );
		}

		// Plugin directory URL
		if ( ! defined( 'RV_CUSTOM_WC_REDIRECTS_PLUGIN_DIR_URL' ) ) {
			define( 'RV_CUSTOM_WC_REDIRECTS_PLUGIN_DIR_URL', trailingslashit( plugin_dir_url( RV_CUSTOM_WC_REDIRECTS_PLUGIN_FILE )  ) );
		}
	}

	/**
	 *	Include PHP files
	 */
	public function includes() {
		include_once 'includes/class-product-data-tabs.php';
		include_once 'includes/class-save-product-meta.php';
		include_once 'includes/class-redirects.php';
	}

	/**
	 *	Action/filter hooks
	 */
	public function hooks() {

		register_activation_hook( RV_CUSTOM_WC_REDIRECTS_PLUGIN_FILE, array( $this, 'activate' ) );

		add_action( 'plugins_loaded', array( $this, 'loaded' ) );

		// add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action( 'admin_footer', array( $this, 'dismiss_admin_notices' ) );
		add_action( 'wp_ajax_wcr_dismiss_admin_notice', array( $this, 'wcr_dismiss_admin_notice' ) );

		add_filter( 'plugin_action_links_' . RV_CUSTOM_WC_REDIRECTS_PLUGIN_BASENAME, array( $this, 'action_links' ) );

		add_action( 'woocommerce_custom_redirects_product_data_tab_end', array( $this, 'upgrade_notice' ) );
	}

	/**
	 *	Check to see if WooCommerce is active, and initialize the options in database
	 */
	public function activate() {

		// Deactivate and die if WooCommerce is not active
		if ( ! class_exists( 'WooCommerce' ) ) {
			deactivate_plugins( RV_CUSTOM_WC_REDIRECTS_PLUGIN_BASENAME );
			wp_die( __( 'The Custom WooCommerce Redirects plugin requires you to install and activate WooCommerce first.', 'woocommerce-add-to-cart-redirect' ) );
		}

		// Add option with initial data for fresh installs
		if ( ! get_option( 'rv_custom_woocommerce_redirects_db_version' ) ) {
			update_option( 'rv_custom_woocommerce_redirects_db_version', RV_CUSTOM_WC_REDIRECTS_DATABASE_VERSION );
		}
	}

	/**
	 *	Load plugin text domain
	 */
	public function loaded() {

		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'woocommerce-add-to-cart-redirect' );
		
		unload_textdomain( 'woocommerce-add-to-cart-redirect' );
		
		load_textdomain( 'woocommerce-add-to-cart-redirect', WP_LANG_DIR . '/woocommerce-add-to-cart-custom-redirect/woocommerce-add-to-cart-custom-redirect-' . $locale . '.mo' );
		load_plugin_textdomain( 'woocommerce-add-to-cart-redirect', false, dirname( RV_CUSTOM_WC_REDIRECTS_PLUGIN_BASENAME ) . '/languages' );
	}

	/**
	 *	Plugin action links
	 */
	public function action_links( $links ) {

		$action_links = array(
			'settings' => sprintf( '<a href="https://wc-redirects.com/?utm_source=wp_admin&utm_medium=plugin_action_links&utm_campaign=custom_redirects_for_woocommerce" aria-label="%s" target="_blank">%s</a>', __( 'Custom Redirects for WooCommerce Premium', 'woocommerce-add-to-cart-redirect' ), __( 'Redirects PREMIUM', 'woocommerce-add-to-cart-redirect' ) )
		);

		return array_merge( $action_links, $links );
	}

	/**
	 *	Display upgrade text in Redirect product data tab
	 */
	public function upgrade_notice() {
		include_once RV_CUSTOM_WC_REDIRECTS_PLUGIN_DIR_PATH . 'templates/product-data-tab-upgrade-notice.php';
	}

	/**
	 * Admin notices
	 *
	 * @return void
	 */
	public function admin_notices() {
		if ( 'dismissed' !== get_option( 'wcr_admin_notice_230_update' ) ) :
			?>
				<div id="wcr_admin_notice_230_update" class="wcr-admin-notice notice is-dismissible" style="border-left: 4px solid #1CAAFC; display: flex; align-items: center;">
					<img style="margin-right: 10px;" src="<?php echo RV_CUSTOM_WC_REDIRECTS_PLUGIN_DIR_URL . 'assets/images/wcr-link.png'; ?>" alt="WooCommerce Redirects logo" width="20">
					<p></p>
				</div>
			<?php
		endif;
	}

	/**
	 * JS for dismissing admin notices
	 *
	 * @return void
	 */
	public function dismiss_admin_notices() {
		?>
			<script>
				jQuery(document).ready(function($) {
					$('body').on('click', '.wcr-admin-notice .notice-dismiss', function(e){
						e.preventDefault();
						$.post(
							ajaxurl, 
							{
								nonce: "<?php echo wp_create_nonce( 'wcr_dismiss_admin_notice' ); ?>",
								action: 'wcr_dismiss_admin_notice',
								id: e.target.closest('.wcr-admin-notice').id
							}, 
							function(data) {
								/*optional stuff to do after success */
							}
						);
					});
				});
			</script>
		<?php
	}

	/**
	 * AJAX for dismissing admin notices
	 *
	 * @return void
	 */
	public function wcr_dismiss_admin_notice() {
		
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wcr_dismiss_admin_notice' ) ) {
			return;
		}

		update_option( sanitize_text_field( $_POST['id'] ), 'dismissed' );
		wp_send_json_success( array(
			'notice_dismissed' => sanitize_text_field( $_POST['id'] )
		) );
	}

	/**
	 *	Meta key
	 */
	public function get_meta_key() {
		return $this->meta_key;
	}

	/**
	 *	Gets the appropriate redirect URL
	 *
	 *	@param (int) $product_id - Product ID
	 *	@return (string) - Redirect URL if one is set, else empty string
	 */
	public function get_redirect_url( $product_id ) {

		// Determine a post redirect
		$post_redirect = get_post_meta( $product_id, $this->get_meta_key(), true );

		$redirect_url = apply_filters( 'woocommerce_custom_redirects_redirect_url', $post_redirect, $product_id );

		// Return final redirect URL
		return ! empty( $redirect_url ) ? esc_url_raw( $redirect_url ) : '';
	}
}

endif;

/**
 *	Main function
 *	@return object RV_Custom_WooCommerce_Redirects instance
 */
function RV_Custom_WooCommerce_Redirects() {
	return RV_Custom_WooCommerce_Redirects::instance();
}

RV_Custom_WooCommerce_Redirects();
