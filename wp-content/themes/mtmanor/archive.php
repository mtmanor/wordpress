<?php get_header(); ?>

<header class="page-header">
	<h1 class="title__h1"><?php single_cat_title(); ?></h1>
</header>

<section class="news">
	<div class="container">
		<div class="post-grid flex-grid">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php get_template_part('partials/news-grid-item'); ?>

			<?php endwhile; endif; ?>
		</div>
  </div>
</section>

<?php get_footer(); ?>
