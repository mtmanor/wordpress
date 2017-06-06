<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0" name="viewport">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/dist/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/dist/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/dist/images/favicon-16x16.png">
	<meta name="theme-color" content="#ffffff">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
	<?php get_template_part( 'partials/svg' ); ?>

	<div class="message-bar">
		<p>Alltid fri frakt, 1–3 dagars leveranstid!</p>
	</div>

	<header class="header">
		<div class="container">

			<nav class="main-nav">
				<a href="" class="hamburger"><span class="hamburger--bar"></span></a>
				<?php wp_nav_menu( array('menu'=>'10', 'container'=>'') ); ?>
			</nav>

			<a href="<?php echo site_url(); ?>" class="header-logo">
				<svg class="icon-logo-mark">
					<use xlink:href="#icon-logo-mark"></use>
				</svg>
				<svg class="icon-logo-type">
					<use xlink:href="#icon-logo-type"></use>
				</svg>
			</a>

			<div class="header-search">
				<a href="" class="header-search--trigger">
					<svg class="icon-search">
						<use xlink:href="#icon-search"></use>
					</svg>
				</a>
				<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="header-search--form">
					<input type="text" name="s" id="search" value="<?php echo get_search_query() ?>" class="header-search--input" />
					<input type="hidden" name="post_type" value="products" />
					<button type="submit" id="searchsubmit" class="header-search--btn">
						<svg class="icon-search">
							<use xlink:href="#icon-search"></use>
						</svg>
					</button>
				</form>
			</div>

			<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="mobile-search">
				<input type="text" name="s" id="search" value="<?php echo get_search_query() ?>" placeholder="Search" class="mobile-search--input" />
				<input type="hidden" name="post_type" value="products" />
				<button class="mobile-search--btn">
					<svg class="icon-search">
						<use xlink:href="#icon-search"></use>
					</svg>
				</button>
			</form>

			<a href="<?php echo wc_get_cart_url(); ?>" class="header-cart-link" title="<?php _e( 'View your shopping cart' ); ?>">
				<?php
				$count = WC()->cart->get_cart_contents_count();
				if ($count > 0): ?>
				<div class="header-cart-link--count"><?php echo $count; ?></div>
				<?php endif; ?>
				<svg class="icon-cart">
					<use xlink:href="#icon-cart"></use>
				</svg>
			</a>

		</div>
	</header>

	<main class="main" role="main">
