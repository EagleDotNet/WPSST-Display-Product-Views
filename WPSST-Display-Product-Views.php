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

defined('ABSPATH') || exit;

if (!class_exists('WPSST_Display_Product_Views')) {
    class WPSST_Display_Product_Views
    {

        /**
         * Initialize the plugin.
         */
        public function __construct()
        {
            add_filter('woocommerce_get_stock_html', array($this, 'display_product_views'), 10, 2);
            add_action('wp', array($this, 'increase_product_views'));
        }

        /**
         * Get product views count.
         */
        private function get_product_views($product_id)
        {
            $product_views = get_post_meta($product_id, '_product_views', true);
            if (empty($product_views)) {
                $product_views = 0;
            }
            return $product_views;
        }

        /**
         * Update product views count.
         */
        private function update_product_views($product_id)
        {
            $product_views = $this->get_product_views($product_id);
            $product_views++;
            update_post_meta($product_id, '_product_views', $product_views);
        }

        /**
         * Display product views count.
         */
        public function display_product_views($html, $product)
        {
            $product_views = $this->get_product_views($product->get_id());
            return '<div class="product-views">' . __('عدد مشاهدات المنتج:', 'wpsst') . ' ' . $product_views . '</div>' . $html;
        }

        /**
         * Increase product views count.
         */
        public function increase_product_views()
        {
            if (is_singular('product')) {
                global $post;
                $this->update_product_views($post->ID);
            }
        }

    }
}

new WPSST_Display_Product_Views();