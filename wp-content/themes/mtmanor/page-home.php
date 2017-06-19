<?php /* Template Name: Home */ ?>
<?php get_header(); ?>

<?php
if( have_rows('home_hero') ): ?>
<section class="home-hero">
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
			<div class="category-grid flex-grid">
				<?php
					while ( have_rows('featured_categories') ) : the_row();
					$term = get_sub_field('category');
					$thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
			    $image = wp_get_attachment_url( $thumbnail_id );
				?>
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

<section class="recommended-products">
	<h2 class="section-title title__h1">Rekommenderat</h2>
	<div class="recommended-products--wrapper">
		<div class="container">

			<?php if( have_rows('recommended_products') ): ?>
				<div class="product-grid recommended-grid flex-grid">
					<?php while( have_rows('recommended_products') ): the_row(); ?>

						<?php
							$post_object = get_sub_field('product');
							$post = $post_object;
							setup_postdata( $post );

								wc_get_template_part( 'content', 'product' );

							wp_reset_postdata();
						?>

					<?php endwhile; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>

<section class="recent-news">
	<div class="container">
		<h2 class="section-title title__h1">Nyheter</h2>

		<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3
		);
		$wp_query = new WP_Query( $args ); ?>

		<?php if ( $wp_query->have_posts() ) : ?>
			<div class="post-grid flex-grid">
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

					<article class="post-grid--item col-1-3">
	          <div class="post-grid--thumb">
							<?php
							$attachmentID = get_post_thumbnail_id();
							if ($attachmentID):
							$src = wp_get_attachment_image_src($attachmentID, 'post-grid-thumb');
							$srcset = wp_get_attachment_image_srcset($attachmentID, 'post-grid-thumb'); ?>
								<a href="<?php the_permalink(); ?>"><img src="<?=$src[0]?>" srcset="<?=$srcset?>" /></a>
							<?php else: ?>
								<img src="<?php echo get_template_directory_uri(); ?>/dist/images/post-thumb-mtm-mark.png" title="<?php echo the_title(); ?>" />
							<?php endif; ?>
	          </div>
	          <h3 class="post-grid--title title__h4"><a href=""><?php the_title(); ?></a></h3>
	          <!-- <p class="post-grid--sub-title title__h4"><a href="">Hållbart som bara blir bättre</a></p> -->
	        </article>

				<?php endwhile; ?>
			</div>

			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
