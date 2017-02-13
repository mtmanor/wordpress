<?php /* Template Name: News */ ?>
<?php get_header(); ?>

<header class="page-header">
	<h1 class="page-title title__h1"><?php the_title(); ?></h1>
</header>

<section class="news">
	<div class="container">

			<?php
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 12,
				'paged' => $paged
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

				<?php // numeric_posts_nav(); ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
