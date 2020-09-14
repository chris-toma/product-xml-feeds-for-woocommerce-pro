<?php
/**
 * Product XML Feeds for WooCommerce - Pro Class
 *
 * @version 1.7.0
 * @since   1.6.0
 * @author  WPWhale
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Product_XML_Feeds_Pro' ) ) :

class Alg_WC_Product_XML_Feeds_Pro {

	/**
	 * Constructor.
	 *
	 * @version 1.7.0
	 * @since   1.6.0
	 */
	function __construct() {
		add_filter( 'alg_wc_product_xml_feeds_settings', array( $this, 'settings' ), 10, 2 );
		add_filter( 'alg_wc_product_xml_feeds_values',   array( $this, 'values' ), 10, 3 );
	}

	/**
	 * values.
	 *
	 * @version 1.7.0
	 * @since   1.7.0
	 */
	function values( $value, $type, $file_num = 0 ) {
		switch ( $type ) {
			case 'total_number':
				return get_option( 'alg_products_xml_total_files', 1 );
			case 'update_interval':
				return get_option( 'alg_create_products_xml_period_' . $file_num, 'weekly' );
			case 'stock_status':
				return get_option( 'alg_products_xml_stock_status_' . $file_num, array() );
			case 'min_price':
				return get_option( 'alg_products_xml_min_price_' . $file_num, '' );
			case 'max_price':
				return get_option( 'alg_products_xml_max_price_' . $file_num, '' );
			case 'catalog_visibility':
				return get_option( 'alg_products_xml_catalog_visibility_' . $file_num, array() );
			case 'custom_taxonomy_in':
				return get_option( 'alg_products_xml_custom_taxonomy_incl_' . $file_num, '' );
			case 'custom_taxonomy_in_slugs':
				return get_option( 'alg_products_xml_custom_taxonomy_incl_slugs_' . $file_num, '' );
			case 'attribute_in':
				return get_option( 'alg_products_xml_attribute_incl_' . $file_num, '' );
			case 'attribute_in_values':
				return ( '' != ( $attribute_in_values = get_option( 'alg_products_xml_attribute_incl_values_' . $file_num, '' ) ) ?
					array_map( 'trim', explode( ',', $attribute_in_values ) ) : '' );
		}
		return $value;
	}

	/**
	 * settings.
	 *
	 * @version 1.7.0
	 * @since   1.7.0
	 */
	function settings( $value, $type = '' ) {
		switch ( $type ) {
			case 'price':
				return array( 'step' => ( 1 / pow( 10, absint( get_option( 'woocommerce_price_num_decimals', 2 ) ) ) ) );
			case 'custom_attributes':
				unset( $value['max'] );
				return $value;
			case 'save_button':
				return '<button name="save" class="button-primary woocommerce-save-button" type="submit" value="' . esc_attr( __( 'Save changes', 'woocommerce' ) ) . '">' .
					esc_html( __( 'Save changes', 'woocommerce' ) ) . '</button>';
			default:
				return '';
		}
	}

}

endif;

return new Alg_WC_Product_XML_Feeds_Pro();
