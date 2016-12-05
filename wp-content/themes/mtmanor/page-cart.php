<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<header class="page-header">
			<h1 class="page-title title__h1"><?php the_title(); ?></h1>
		</header>

		<section class="cart">
			<div class="container">
				<?php the_content(); ?>
			</div>
		</section>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>
