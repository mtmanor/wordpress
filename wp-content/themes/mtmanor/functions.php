<?php
add_action( 'after_setup_theme', 'mtm_setup' );
function mtm_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menu( 'primary', __( 'Primary Menu', 'mtm' ) );
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

// Default blog image
function get_default_blog_image($size=null){
	static $image_id;

	if(is_null($image_id))
		$image_id = (int) get_field('default_image', 'options');

	$image = wp_get_attachment_image_src($image_id, $size);
	return $image[0];
}

// ACF Options Page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
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
	echo '<a href="' . $link . '" class="product-grid--item col-1-4">';
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


// Loop Product Thumb Wrapper
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
function woocommerce_template_loop_product_thumbnail() {
	echo '<div class="product-grid--thumb">' . woocommerce_get_product_thumbnail() . '</div>';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);


// Update Loop Product Title
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
function mtm_template_loop_product_title() {
	$title = get_the_title();
	echo '<h2 class="product-grid--product-title">' . $title . '</h2>';
}
add_action( 'woocommerce_shop_loop_item_title', 'mtm_template_loop_product_title', 10 );


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
