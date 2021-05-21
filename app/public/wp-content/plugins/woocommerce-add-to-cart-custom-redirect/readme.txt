=== WooCommerce Add to Cart Custom Redirect ===
Contributors: renventura
Tags: WooCommerce, Redirect
Tested up to: 5.7
Stable tag: 1.2.9
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Set your WooCommerce products to redirect to a custom URL when added to the cart.

== Description ==

This plugin adds a field to the Edit Product page (under the General product info) that accepts a URL from the administrator or shop manager. When this field is set, the front-end user (customer) will be redirected to the URL when that product is added to the cart. This can be useful if you want to automatically prompt your customers to purchase other products.

### Upgrade to Custom Redirects for WooCommerce

__With the premium version of Custom Redirects for WooCommerce, you get access to:__

* Add-to-cart redirects when your customers add products to their cart
* After-purchase redirects when your customers complete checkout
* Open redirects in new tabs
* Redirects for product variations
* Product-specific Redirect URLs
* Product Category/Tag Redirects
* Redirect on AJAX Add-to-Cart
* Support for Product CSV Import/Export (import and export redirects)
* Convenient admin page to see all your redirects
* Seamless upgrade from the Free version to Premium
* One Year of Updates &amp; Premium Support

Learn more about [Custom Redirects for WooCommerce](https://wc-redirects.com/?utm_source=wordpress&utm_medium=plugin_repo&utm_campaign=custom_redirects_for_woocommerce)

== Installation ==

This section describes how to install the plugin and get it working.

### Automatically

1. Search for WooCommerce Add to Cart Custom Redirect in the Add New Plugin section of the WordPress admin
2. Install & Activate

### Manually

1. Download the zip file and upload `woocommerce-custom-redirect` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How do I use this plugin? =

Install and activate the plugin. Then paste your URL into the Add-to-Cart Redirect URL field under the Redirect product data tab. If you want to utilize the redirect feature on product archive pages, make sure to uncheck the "Enable AJAX add to cart buttons on archives" checkbox under the WooCommerce settings Products tab (read below for AJAX support).

= Do you offer support for this plugin? =

If you have any questions, feel free to post a thread on the [support forum](https://wordpress.org/support/plugin/woocommerce-add-to-cart-custom-redirect). If you need immediate help, you can also [purchase a license](https://wc-redirects.com/?utm_source=wordpress&utm_medium=plugin_repo&utm_campaign=custom_redirects_for_woocommerce) for priority support.

= How can I use this plugin with AJAX support? =

Currently, AJAX support is part of the [premium upgrade](https://wc-redirects.com/?utm_source=wordpress&utm_medium=plugin_repo&utm_campaign=custom_redirects_for_woocommerce).

= How can I open the redirect in a new browser tab? =

The [premium version](https://wc-redirects.com/?utm_source=wordpress&utm_medium=plugin_repo&utm_campaign=custom_redirects_for_woocommerce) offers support for opening redirects in new tabs.

= What about redirecting variations of products? =

You can add variation redirects with the [premium version](https://wc-redirects.com/?utm_source=wordpress&utm_medium=plugin_repo&utm_campaign=custom_redirects_for_woocommerce) of this plugin.

== Screenshots ==

1. This example redirect configuration would redirect a customer to a custom URL after they've added this product to their cart, and after purchasing (Premium feature).
2. A sample overview showing a quick glance of where redirects are set (Premium feature).
3. You can add redirects for product categories and tags (taxonomies) by editing the taxonomy. You can also add a redirect when adding new categories/tags (Premium feature).

== Changelog ==

= 1.2.9 =
* Bump version to show compatibility with WooCommerce 5.0 and WordPress 5.7

= 1.2.8 =
* Bump version to show WooCommerce 4.0 compatibility

= 1.2.7 =
* Clean up RV_Custom_WooCommerce_Redirects->get_redirect_url() method

= 1.2.6 =
* Removed outdated admin notice

= 1.2.5 =
* WooCommerce 3.9 compatibility

= 1.2.4 =
* Added notice of new features
* Changed use of constants for text domain

= 1.2.3 =
* Fixed error in path to `load_plugin_textdomain()`

= 1.2.2 =
* Some refactoring

= 1.2.1 =
* Fixed a bug that caused redirects to persist after they've been removed

= 1.2 =
* Replaced deprecated add_to_cart_redirect filter with woocommerce_add_to_cart_redirect

= 1.1 =
* Added support for redirects on product archive pages

= 1.0 =
* Initial version