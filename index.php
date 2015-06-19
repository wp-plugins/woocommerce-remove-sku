<?php
/*
Plugin Name: Woocommerce Remove SKU
Description: This simple plugin will remove wooCommerce SKUs completely from product description page.
Author: Prem Tiwari
Plugin URI: http://freewebmentor.com/2015/06/woocommerce-remove-sku.html
Author URI: https://freewebmentor.com
Version: 1.0.0
License: GPL2+
Requires at least: 3.8
Tested up to: 4.2.2
@category WooCommerce
@requires WooCommerce version 2.1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
    }

class WC_Settings_sku {

    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_sku', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_sku', __CLASS__ . '::update_settings' );
    }
    
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_sku'] = __( 'SKU Settings', 'woocommerce-sku-settings-tab' );
        return $settings_tabs;
    }

    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }

    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }

    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {

        $settings = array(
            'section_title' => array(
                'name'     => __( 'Sku Options', 'woocommerce-sku-settings-tab' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_sku'
            ),
            'title' => array(
                'name' => __( 'Hide product sku', 'woocommerce-sku-settings-tab' ),
                'type'    => 'select',

			    'options' => array(
			      '0'        => __( 'No', 'woocommerce' ),
			      '1'       => __( 'Yes', 'woocommerce' ),
			    ),
                'desc' => __( 'Hide product sku from products description page.', 'woocommerce-sku-settings-tab' ),
                'id'   => 'wc_settings_tab_sku'
            ),
            
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_sku_section_end'
            )
        );

        return apply_filters( 'wc_settings_tab_sku_settings', $settings );
    }
}

WC_Settings_sku::init();

/**
* Hide the sku from product description page.
*/
$sku_option=get_option('wc_settings_tab_sku');
if($sku_option==1)
{	
	add_filter( 'wc_product_sku_enabled', '__return_false' );
}

?>