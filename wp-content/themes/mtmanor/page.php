<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<h1 class="page-title title__h1"><?php the_title(); ?></h1>

		<div class="">
			<?php the_content(); ?>
		</div>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>
