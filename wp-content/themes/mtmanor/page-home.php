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

<!-- <section class="home-hero">
	<div class="container">
		<a href="" class="home-hero--block">
			<h1 class="home-hero--title title__h1">Herschel Supply Retreat Black Canvas Bag</h1>
			<p ><span class="btn btn__salmon">2195 SEK</span></p>
		</a>
	</div>
</section> -->

<section class="featured-products">
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
</section>


<?php get_footer(); ?>
