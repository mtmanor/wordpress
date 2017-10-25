<?php /* Template Name: Checkout */ ?>
<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<header class="page-header">
			<h1 class="page-title title__h1"><?php the_title(); ?></h1>
		</header>

		<section class="cart">
			<div class="container">

				<div class="checkout flex-grid">
					<div class="checkout-form col-2-3">
						<?php the_content(); ?>
					</div>
					<div class="checkout-summary col-1-3">
						<?php echo do_shortcode( '[woocommerce_klarna_checkout_widget hide_columns="remove,price" order_note="hide"]' ); ?>
					</div>
				</div>

			</div>
		</section>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>
