<?php
add_action( 'after_setup_theme', 'mtm_setup' );
function mtm_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menu( 'primary', __( 'Primary Menu', 'mtm' ) );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'wp_enqueue_scripts', 'mtm_load_scripts' );
function mtm_load_scripts() {

	define('ENQUEUE_VERSION', '1.0.0');

	//post id, so we can restrict unnecessary scripts
	global $post;
	$pid = is_singular() ? $post->ID : null;

	$deps = array('jquery');

	wp_enqueue_script( 'jquery' );

	// Modernizr
	wp_register_script('modernizr',
		get_bloginfo('template_url') . '/dist/js/modernizr-custom.js',
		array(),
		ENQUEUE_VERSION
	);
	wp_enqueue_script('modernizr');

	// clamp
	wp_register_script('clamp',
		get_bloginfo('template_url') . '/dist/js/clamp.min.js',
		array(),
		ENQUEUE_VERSION,
		true
	);
	wp_enqueue_script('clamp');

	// fitvids
	wp_register_script('fitvids',
		get_bloginfo('template_url') . '/dist/js/jquery.fitvids.js',
		array(),
		ENQUEUE_VERSION,
		true
	);
	wp_enqueue_script('fitvids');

	// main js
	wp_register_script('main-js',
		get_bloginfo('template_url') . '/dist/js/main.js',
		$deps,
		ENQUEUE_VERSION,
		true
	);
	wp_enqueue_script('main-js');

	// main css
	wp_register_style('main-css',
		get_stylesheet_uri(),
		array(),
		ENQUEUE_VERSION
	);
	wp_enqueue_style('main-css');
}

add_filter( 'wp_title', 'mtm_filter_wp_title' );
function mtm_filter_wp_title( $title ) {
	return $title . esc_attr( get_bloginfo( 'name' ) );
}

// Video Single Template
add_filter('single_template', 'check_for_category_single_template');
function check_for_category_single_template( $t ) {
  foreach( (array) get_the_category() as $cat )  {
    if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") ) return TEMPLATEPATH . "/single-{$cat->slug}.php";
    if($cat->parent) {
      $cat = get_the_category_by_ID( $cat->parent );
      if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") ) return TEMPLATEPATH . "/single-{$cat->slug}.php";
    }
  }
  return $t;
}

// Post Navigation
function post_navigation() {
	$prev_page = get_previous_posts_link('<svg class="b-post-grid--icon icon-arrow-left"><use xlink:href="#icon-arrow-left"></use></svg> Previous Posts');
	$next_page = get_next_posts_link('More Posts <svg class="b-post-grid--icon icon-arrow-right"><use xlink:href="#icon-arrow-right"></use></svg>');
	if($prev_page || $next_page) {
		echo '<div class="b-post-grid-nav">';
		if ($prev_page) {
			echo  '<div class="b-post-grid-nav--item">' . $prev_page . '</div>';
		} else {
			echo '<div class="b-post-grid-nav--item"><svg class="b-post-grid-nav--icon icon-arrow-left"><use xlink:href="#icon-arrow-left"></use></svg> Previous Posts</div>';
		}
		if ($next_page) {
			echo  '<div class="b-post-grid-nav--item">' . $next_page . '</div>';
		} else {
			echo '<div class="b-post-grid-nav--item">More Posts <svg class="b-post-grid-nav--icon icon-arrow-right"><use xlink:href="#icon-arrow-right"></use></svg></div>';
		}
		echo '</div>';
	}
}

// Image Sizes
add_image_size( 'post-grid-thumb', 410, 300, true );
add_image_size( 'post-grid-thumb-2x', 820, 600, true );

add_image_size( 'post-thumb', 403, 286, true );
add_image_size( 'post-thumb-2x', 806, 572, true );

add_image_size( 'post-hero', 960, 546, true );
add_image_size( 'post-hero-2x', 1920, 1092, true );

add_image_size( 'guide-thumb', 188, 188 );
add_image_size( 'guide-thumb-2x', 376, 376 );


// Default blog image
function get_default_blog_image($size=null){
	static $image_id;

	if(is_null($image_id))
		$image_id = (int) get_field('default_image', 'options');

	$image = wp_get_attachment_image_src($image_id, $size);
	return $image[0];
}


// Short Title
function shortTitle($text) {
  $chars_limit = 80;
  $chars_text = strlen($text);
  $text = $text." ";
  $text = substr($text,0,$chars_limit);
  $text = substr($text,0,strrpos($text,' '));

  if ($chars_text > $chars_limit) {
		$text = $text."...";
	}
	return $text;
}


// Remove ninja form stylesheets
function wpgood_nf_display_enqueue_scripts(){
	wp_dequeue_style( 'nf-display' );
}
add_action( 'nf_display_enqueue_scripts', 'wpgood_nf_display_enqueue_scripts');


// Enable Woocommerce Support
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
  add_theme_support( 'woocommerce' );
}


// Disable Woocommerce Styles
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


// Disable Woocommerce Product Tabs
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
  unset( $tabs['description'] ); // Remove the description tab
  unset( $tabs['reviews'] ); // Remove the reviews tab
  unset( $tabs['additional_information'] ); // Remove the additional information tab
  return $tabs;
}


// Display Woocommerce Product Description in place of Summary
function woocommerce_template_product_description() {
	wc_get_template( 'single-product/tabs/description.php' );
	// wc_get_template( 'single-product/tabs/additional-information.php' );
}
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_product_description', 20 );


// Move Product Cart above Product Description
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 15 );


// Remove Product Meta (categories, tags)
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );


// Remove Product Price Zeros
add_filter( 'woocommerce_price_trim_zeros', '__return_true' );


// Remove Main Wrapper
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );


// Move Messages above Product Breadcrumbs
remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );
add_action( 'woocommerce_before_main_content', 'wc_print_notices', 15 );


// Remove Loop Add to Cart
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );


// Update Loop Link Open
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
function mtm_template_loop_product_link_open() {
	$link = get_permalink();
	echo '<a href="' . $link . '" class="product-grid--item">';
	echo '<div class="product-grid--item-wrapper">';
}
add_action( 'woocommerce_before_shop_loop_item', 'mtm_template_loop_product_link_open', 10 );


// Update Loop Link Close
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
function mtm_template_loop_product_link_close() {
	echo '</div>';
	echo '</a>';
}
add_action( 'woocommerce_after_shop_loop_item', 'mtm_template_loop_product_link_close', 5 );


// Update Category Loop Link Open
remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
function mtm_template_template_loop_category_link_open( $category ) {
	$link = get_term_link( $category->term_id, 'product_cat' );
	echo '<a href="' . $link . '" class="product-grid--item">';
	echo '<div class="product-grid--item-wrapper">';
}
add_action( 'woocommerce_before_subcategory', 'mtm_template_template_loop_category_link_open', 10 );


// Update Category Loop Link Close
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 5 );
function mtm_template_loop_category_link_close( $category ) {
	echo '</div>';
	echo '</a>';
}
add_action( 'woocommerce_after_subcategory', 'mtm_template_loop_category_link_close', 5 );


// Loop Product Thumb Wrapper
add_action( 'woocommerce_before_shop_loop_item_title', function() {
  echo '<div class="product-grid--thumb">';
}, 9 );

add_action( 'woocommerce_before_shop_loop_item_title', function() {
  echo '</div>';
}, 11 );

add_action( 'woocommerce_before_subcategory_title', function() {
  echo '<div class="product-grid--thumb">';
}, 9 );

add_action( 'woocommerce_before_subcategory_title', function() {
  echo '</div>';
}, 11 );


// Update Loop Product Title
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
function mtm_template_loop_product_title() {
	global $product;
	$product_brand = $product->get_attribute( 'brand' );
	$product_name = $product->get_attribute( 'name' );
	$product_type = $product->get_attribute( 'type' );
	$product_color = $product->get_attribute( 'color' );

	if ($product_brand && $product_name) {
		echo '<h2 class="product-grid--product-title">';
		echo '<span class="product-title__name">' . $product_brand . ' ' . $product_name . '</span>';
		echo '<span class="product-title__type">' . $product_type . ' - ' . $product_color . '</span>';
		echo '</h2>';
	} else {
		the_title( '<h2 class="product-grid--product-title">', '</h2>' );
	}
}
add_action( 'woocommerce_shop_loop_item_title', 'mtm_template_loop_product_title', 10 );


// Update Category Loop Product Title
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
function mtm_template_loop_category_title( $category ) {
	echo '<h2 class="product-grid--category-title title__h2">' . $category->name . '</h2>';
}
add_action( 'woocommerce_shop_loop_subcategory_title', 'mtm_template_loop_category_title', 10 );


// Remove Category Loop Title Count
add_filter( 'woocommerce_subcategory_count_html', 'mtm_hide_category_count' );
function mtm_hide_category_count() {
}


// Move Category Breadcrumbs
function mtm_remove_category_breadcrumb() {
	if ( is_product_category() ) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		add_action( 'woocommerce_before_shop_loop', 'woocommerce_breadcrumb', 5 );
	}
}
add_action( 'template_redirect', 'mtm_remove_category_breadcrumb' );


// Add Container Wrapper to Breadcrumbs
add_filter( 'woocommerce_breadcrumb_defaults', 'mtm_change_breadcrumb_wrapper' );
function mtm_change_breadcrumb_wrapper( $defaults ) {
	$defaults['wrap_before'] = '<nav class="breadcrumb" itemprop="breadcrumb"><div class="container">';
	$defaults['wrap_after'] = '</div></nav>';
	return $defaults;
}


// Remove Woo Breadcrumbs from Single Product
add_action('template_redirect', 'remove_shop_breadcrumbs' );
function remove_shop_breadcrumbs(){
	if (is_single()) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	}
}


// Remove "Products" from Yoast SEO Breadcrumbs
function mtm_wpseo_breadcrumb_output( $output ){
  if( is_product() ){
    $from = '<a href="'.site_url().'/shop/" rel="v:url" property="v:title">Products</a> /';
    $to     = '';
    $output = str_replace( $from, $to, $output );
  }
  return $output;
}
add_filter( 'wpseo_breadcrumb_output', 'mtm_wpseo_breadcrumb_output' );


// Change "Default Sorting" to "Sort By"
function mtm_change_default_sorting_name( $catalog_orderby ) {
  $catalog_orderby = str_replace("Default sorting", "Sort by", $catalog_orderby);
  return $catalog_orderby;
}
add_filter( 'woocommerce_catalog_orderby', 'mtm_change_default_sorting_name' );
add_filter( 'woocommerce_default_catalog_orderby_options', 'mtm_change_default_sorting_name' );


// Update Sale Label
add_filter( 'woocommerce_sale_flash', 'mtm_custom_replace_sale_text' );
function mtm_custom_replace_sale_text( $html ) {
  return str_replace( __( 'Sale!', 'woocommerce' ), __( 'Sale', 'woocommerce' ), $html );
}


// Product Stock Message
add_filter( 'woocommerce_get_availability', 'mtm_custom_get_availability', 1, 2);
function mtm_custom_get_availability( $availability, $_product ) {
	global $product;

	// Change In Stock Text
	if ( $_product->is_in_stock() ) {
    $availability['availability'] = __('', 'woocommerce');
	}

	// Change One Left Text
	if ( $_product->is_in_stock() && $product->get_stock_quantity() == 1 ) {
		$availability['availability'] = sprintf( __('Last one in stock', 'woocommerce'), $product->get_stock_quantity());
	}

	// Change Backorder Text
	if ( $_product->is_in_stock() && $product->get_stock_quantity() == 0 ) {
		$availability['availability'] = sprintf( __('Delivered in 7 - 10 days', 'woocommerce'), $product->get_stock_quantity());
	}

	// Change Out of Stock Text
	if ( ! $_product->is_in_stock() ) {
		$availability['availability'] = __('Sold Out', 'woocommerce');
	}

	return $availability;
}


// Empty Cart: Return to Shop URL Update
function wc_empty_cart_redirect_url() {
	return '/';
	// return $_SERVER['HTTP_REFERER'];
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );


// Order ID increased number
function mtm_woocommerce_order_number( $this_get_id, $instance ) {
    return '100' . $this_get_id;
};
add_filter( 'woocommerce_order_number', 'mtm_woocommerce_order_number', 10, 2 );
