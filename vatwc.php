<?php

/*
 * Plugin Name:       VatWC API plugin
 * Plugin URI:        https://github.com/obman/VatWC-Plugin
 * Description:       Integrate GeoWC application APIs into WooCommerce checkout address fields.
 * Author:            obman
 * Version:           1.2.2
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author             URI: https://github.com/obman/
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       vatapiwc
*/

use VatApiPluginSettings\VatApiPluginSettings;

if ( ! defined( 'ABSPATH' ) ) exit;

if (! function_exists('get_plugin_data')) {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

define('VATAPI_PLUGIN_DATA', get_plugin_data(__FILE__));
define('VATAPIWC_DIR', plugin_dir_url( __FILE__ ));

require __DIR__ . '/vendor/autoload.php';

const VATAPI_OPTIONS_NAME = 'vatapiwc_settings_options';
const VATAPI_MENU_SLUG = 'vatapiwc-plugin';

define('VATAPISERVICE_BASE_URL', 'https://geoapp.sample.si');

// Register plugin hooks
function vatapiwc__settings_page(): void {
    add_menu_page('VatApiWC', 'VatAPI WC Settings', 'manage_options', VATAPI_MENU_SLUG, 'vatapiwc__render_options_page_html', 'dashicons-rest-api');
}
add_action('admin_menu', 'vatapiwc__settings_page');

/**
 * Frontend assets
 *
 * @return void
 */
function vatapiwc__register_assets__frontend(): void {
    // Admin
	wp_register_style('vatapi-admin-form', VATAPIWC_DIR . 'assets/css/admin/vatapi-admin-form.css', false, PLUGIN_DATA['Version'], 'all');
    wp_register_script('vatapi-admin-bearer-token', VATAPIWC_DIR . 'assets/js/admin/vatapp-get-api-bearer-token.js', false, PLUGIN_DATA['Version'], array('strategy' => 'defer', 'in_footer' => 'true'));

    // Type 1
    wp_register_script('vatapitype1wc', VATAPIWC_DIR . 'assets/js/front/vatapitype1wc.js', false, PLUGIN_DATA['Version'], array('strategy' => 'defer', 'in_footer' => 'true'));
}
add_action('init', 'vatapiwc__register_assets__frontend');

function vatapiwc__register_assets__admin(): void {
	$options     = get_option(VATAPI_OPTIONS_NAME);
	$script_data = array(
        'base_url'              => VATAPISERVICE_BASE_URL,
		'client_id'             => $options['vatapi-api-client-id-field'],
		'client_secret'         => $options['vatapi-api-client-secret-field'],
        'bearer_token_field_id' => 'vatapi-api-bearer-token-field',
	);

	wp_enqueue_style('vatapi-admin-form');
	wp_enqueue_script('vatapi-admin-bearer-token');
	wp_localize_script('vatapi-admin-bearer-token', 'vatapiwc', $script_data);
}
add_action('admin_enqueue_scripts', 'vatapiwc__register_assets__admin');

function vatapiwc__load_assets__frontend(): void {
    $all_plugins = apply_filters('active_plugins', get_option('active_plugins'));

    if (stripos(implode($all_plugins), 'woocommerce.php')) {
        if (is_checkout()) {
            $options     = get_option(VATAPI_OPTIONS_NAME);
            $script_data = array(
                'base_url'          => VATAPISERVICE_BASE_URL,
                'bearer_token'      => $options['vatapi-api-bearer-token-field'],
                'license_key'       => $options['vatapi-license-key-field'],
                'domain'            => get_site_url(),
                'company_name_field_id'  => $options['vatapi-company-name-id-field'],
                'vatid_field_id'         => $options['vatapi-vatid-id-field'],
                'country_field_id'       => $options['vatapi-country-id-field'],
                'address_field_id'       => $options['vatapi-address-id-field'],
                'zip_field_id'           => $options['vatapi-zip-id-field'],
                'city_field_id'          => $options['vatapi-city-id-field'],
            );

            if (isset($options['vatapi-api-type'])) {
                switch ($options['vatapi-api-type']) {
                    case '1':
	                    wp_enqueue_script('vatapitype1wc');
	                    wp_localize_script('vatapitype1wc', 'vatapiwc', $script_data);
                        break;
                    case '2':
                        // when it be
                        break;
                    case '3':
                        // to be
                        break;
                }
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'vatapiwc__load_assets__frontend');

function vatapiwc__load_js_as_ES6($tag, $handle, $src) {
    if (
        $handle === 'vatapitype1wc'
    ) {
        return '<script src="' . esc_url( $src ) . '" type="module"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'vatapiwc__load_js_as_ES6', 10, 3);

## Helper functions
function vatapiwc_setup_plugin_settings(): void
{
    register_setting(VATAPI_OPTIONS_NAME, VATAPI_OPTIONS_NAME);

    $pluginSettings = new VatApiPluginSettings();

    $pluginSettings->renderSettingsSection('ApiCredentials');
    $pluginSettings->renderSettingsSection('LicenseKey');
    $pluginSettings->renderSettingsSection('ApiType');
    $pluginSettings->renderSettingsSection('EventHandlerFields');

	// API Credential
	$pluginSettings->renderSettingsFields('ApiClientIDField', VATAPI_OPTIONS_NAME, 'vatapi-api-client-id-field');
	$pluginSettings->renderSettingsFields('ApiClientSecretField', VATAPI_OPTIONS_NAME, 'vatapi-api-client-secret-field');
	$pluginSettings->renderSettingsFields('ApiBearerTokenField', VATAPI_OPTIONS_NAME, 'vatapi-api-bearer-token-field');
	$pluginSettings->renderSettingsFields('GetBearerTokenButton', VATAPI_OPTIONS_NAME, 'vatapi-get-bearer-token-button');

	// License
	$pluginSettings->renderSettingsFields('LicenseKeyField', VATAPI_OPTIONS_NAME, 'vatapi-license-key-field');
    $pluginSettings->renderSettingsFields('ApiTypeField', VATAPI_OPTIONS_NAME, 'vatapi-api-type');

    // Event Handler
    $pluginSettings->renderSettingsFields('CompanyNameField', VATAPI_OPTIONS_NAME, 'vatapi-company-name-id-field');
    $pluginSettings->renderSettingsFields('VatIdField', VATAPI_OPTIONS_NAME, 'vatapi-vatid-id-field');
	$pluginSettings->renderSettingsFields('CountryField', VATAPI_OPTIONS_NAME, 'vatapi-country-id-field');
	$pluginSettings->renderSettingsFields('AddressField', VATAPI_OPTIONS_NAME, 'vatapi-address-id-field');
	$pluginSettings->renderSettingsFields('ZipField', VATAPI_OPTIONS_NAME, 'vatapi-zip-id-field');
	$pluginSettings->renderSettingsFields('CityField', VATAPI_OPTIONS_NAME, 'vatapi-city-id-field');
}
add_action('admin_init', 'vatapiwc_setup_plugin_settings');

function vatapiwc__render_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) return; ?>
    <section>
        <h2>GeoWC VatId Settings</h2>
        <div class="settings-fields-wrapper">
            <form action="options.php" class="form-wrapper" method="post">
                <?php
                settings_fields(VATAPI_OPTIONS_NAME);
                do_settings_sections(VATAPI_MENU_SLUG);
                submit_button();
                ?>
            </form>
        </div>
    </section>
    <?php
}