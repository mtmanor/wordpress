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

	<?php
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
	?>

<?php get_footer(); ?>
