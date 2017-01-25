<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;
$product_brand = $product->get_attribute( 'brand' );
$product_name = $product->get_attribute( 'name' );
$product_type = $product->get_attribute( 'type' );
$product_color = $product->get_attribute( 'color' );

if ($product_brand && $product_name) {
	echo '<h1 itemprop="name" class="product-title title__h1">';
	echo '<span class="product-title__name">' . $product_brand . ' ' . $product_name . '</span>';
	echo '<span class="product-title__type">' . $product_type . ' - ' . $product_color . '</span>';
	echo '</h1>';
} else {
	the_title( '<h1 itemprop="name" class="product-title title__h1">', '</h1>' );
}

// var_dump($product);
