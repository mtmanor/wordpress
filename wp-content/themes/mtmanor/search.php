<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="title__h1"><?php printf( __( 'Search Results for: %s', 'twentysixteen' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
	</header>

	<section class="search-results">
		<div class="container">
			<div class="product-grid flex-grid">

				<?php while ( have_posts() ) : the_post(); ?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php endwhile; ?>

			</div>
		</div>
	</section>

<?php else: ?>
	<section class="page-header">
		<div class="container">

			<h1 class="page-title title__h1">Whoops!</h1>

			<?php printf( __( 'No search results for: <span class="search-results--term">"%s"</span>. Search again or browse by category below.', 'twentysixteen' ), '<p>' . esc_html( get_search_query() ) . '</p>' ); ?>

			<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="error-search">
				<input type="text" name="s" id="search" value="" placeholder="<?php echo _x( 'Search', '') ?>" class="error-search--input" />
				<input type="hidden" name="post_type" value="products" />
				<button class="error-search--btn">
					<svg class="icon-search">
						<use xlink:href="#icon-search"></use>
					</svg>
				</button>
			</form>

		</div>
	</section>
	<?php $page = get_page_by_path('home'); ?>
	<?php $page_id = $page->ID; ?>

	<section class="categories">
		<div class="container">

			<?php
			if( have_rows('primary_featured_categories', $page_id) ): ?>
				<div class="featured-categories flex-grid">
					<?php
					while ( have_rows('primary_featured_categories', $page_id) ) : the_row(); ?>

						<div class="featured-categories--item col-1-2">
							<?php $term = get_sub_field('product_category', $page_id); ?>
							<?php $image = get_sub_field('background_image', $page_id); ?>

							<a href="<?php echo get_term_link( $term ); ?>" class="featured-categories--wrapper" style="background-image: url(<?php echo $image['url']; ?>);">
		            <div class="featured-categories--overlay">
		              <h3 class="featured-categories--title title__h2"><?php echo $term->name; ?></h3>
		              <span class="btn btn__salmon">Gå direkt</span>
		            </div>
		          </a>

						</div>

					<?php endwhile; ?>
				</div>
			<?php endif; ?>

			<?php
			if( have_rows('featured_categories', $page_id) ): ?>
				<div class="category-grid flex-grid">
					<?php
					while ( have_rows('featured_categories', $page_id) ) : the_row();
					$term = get_sub_field('category', $page_id);
					$thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
			    $image = wp_get_attachment_url( $thumbnail_id ); ?>
						<a href="<?php echo get_term_link( $term ); ?>" class="product-grid--item">
							<div class="category-grid--item-wrapper">
								<div class="category-grid--overlay">
									<h3 class="category-grid--overlay-title title__h2"><?php echo $term->name; ?></h3>
									<p class="category-grid--overlay-info"><?php echo $term->count; ?> produkter</p>
									<span class="btn btn__salmon">Gå direkt</span>
								</div>
								<div class="category-grid--thumb">
									<img src="<?php echo $image; ?>" />
								</div>
								<h3 class="category-grid--category-title title__h2"><?php echo $term->name; ?></h3>
							</div>
						</a>
					<?php endwhile; ?>

				</div>
			<?php endif; ?>

		</div>
	</section>

<?php endif; ?>

<?php get_footer(); ?>
