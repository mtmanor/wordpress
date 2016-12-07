<?php /* Template Name: Home */ ?>
<?php get_header(); ?>

<?php
if( have_rows('home_hero') ): ?>
<section class="home-hero">
	<div class="container">
	<?php
	while ( have_rows('home_hero') ) : the_row(); ?>
		<?php $image = get_sub_field('hero_image'); ?>
		<a href="<?php the_sub_field('hero_button_link'); ?>" class="home-hero--link" style="background-image: url(<?php echo $image['url']; ?>);">
			<div class="home-hero--block">
				<h1 class="home-hero--title title__h1"><?php the_sub_field('hero_title'); ?></h1>
				<p><span class="btn btn__salmon"><?php the_sub_field('hero_button_label'); ?></span></p>
			</div>
		</a>

	<?php endwhile; ?>
	</div>
</section>
<?php endif; ?>

<section class="categories">
	<div class="container">

		<?php
		if( have_rows('primary_featured_categories') ): ?>
			<div class="featured-categories flex-grid">
				<?php
				while ( have_rows('primary_featured_categories') ) : the_row(); ?>

					<div class="featured-categories--item col-1-2">
						<?php $term = get_sub_field('product_category'); ?>
						<?php $image = get_sub_field('background_image'); ?>

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
		if( have_rows('featured_categories') ): ?>
			<div class="product-grid flex-grid">

				<?php
				while ( have_rows('featured_categories') ) : the_row();
				$term = get_sub_field('category');
				$thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
		    $image = wp_get_attachment_url( $thumbnail_id );
				?>
					<a href="<?php echo get_term_link( $term ); ?>" class="product-grid--item col-1-3">
						<div class="product-grid--item-wrapper">
							<div class="product-grid--overlay">
								<h3 class="product-grid--overlay-title title__h2"><?php echo $term->name; ?></h3>
								<!-- <p class="product-grid--overlay-info">6 produkter från Sandqvist och Herschel</p> -->
								<span class="btn btn__salmon">Gå direkt</span>
							</div>
							<div class="product-grid--thumb">
								<img src="<?php echo $image; ?>" />
							</div>
							<h3 class="product-grid--category-title title__h2"><?php echo $term->name; ?></h3>
						</div>
					</a>
				<?php endwhile; ?>

			</div>
		<?php endif; ?>


	</div>
</section>

<section class="recommended-products">
	<h2 class="section-title title__h1">Rekommenderat</h2>
	<div class="recommended-products--wrapper">
		<div class="container">

			<div class="product-grid flex-grid">
				<?php
					$args = array(
						'post_type' => 'product',
						'posts_per_page' => 12
						);
					$loop = new WP_Query( $args );
					if ( $loop->have_posts() ) {
						while ( $loop->have_posts() ) : $loop->the_post();
							wc_get_template_part( 'content', 'product' );
						endwhile;
					} else {
						echo __( 'No products found' );
					}
					wp_reset_postdata();
				?>
			</div>

		</div>
	</div>
</section>


<?php get_footer(); ?>
