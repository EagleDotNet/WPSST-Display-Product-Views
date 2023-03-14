<?php

/*
Plugin Name:  WPSST Display Product Views
Plugin URI:   https://www.syriasmart.net
Description:  Add more columns on admin oreder page. 
Version:      1.0
Author:       Syria Smart Technology 
Author URI:   https://www.syriasmart.net
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wpsst-order-columns-plus
Domain Path:  /languages
*/

// انشاء حقل حقل مخصص في WooCommerce لتخزين عدد مرات مشاهدة المنتج
function custom_product_views_field()
{
    woocommerce_wp_text_input(
        array(
            'id' => 'custom_product_views',
            'class' => 'wc_input_short',
            'label' => __('Product Views', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min' => '0'
            )
        )
    );
}
add_action('woocommerce_product_options_general_product_data', 'custom_product_views_field');

// زيادة عدد مرات مشاهدة المنتج في WooCommerce Product Custom Fields كلما تمت مشاهدة المنتج
function increase_product_views()
{
    if (is_singular('product')) {
        $product_id = get_queried_object_id();
        $views = get_post_meta($product_id, 'custom_product_views', true);
        if (empty($views)) {
            $views = 0;
        }
        $views++;
        update_post_meta($product_id, 'custom_product_views', $views);
    }
}
add_action('wp', 'increase_product_views');

// عرض عدد مرات مشاهدة المنتج داخل صفحة المنتج في WooCommerce
function display_product_views()
{
    global $product;
    $views = get_post_meta($product->get_id(), 'custom_product_views', true);
    echo '<div class="product-views">';
    echo __('Product Views:', 'woocommerce') . ' ' . $views;
    echo '</div>';
}
add_action('woocommerce_single_product_summary', 'display_product_views', 11);

?>