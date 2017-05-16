<?php /* Template Name: Thank You */ ?>
<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<header class="page-header">
			<h1 class="page-title title__h1"><?php the_title(); ?></h1>
		</header>

		<div class="post-content body-content">
			<?php the_content(); ?>
		</div>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>
