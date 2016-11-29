<?php get_header(); ?>

<main class="b-main" role="main">

	<section class="b-subcat">
		<div class="b-container">

			<div class="b-sub-category--header">
				<h1 class="b-page-title"><?php single_tag_title(); ?></h1>
			</div>

			<div class="b-post-grid flex-grid">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

					<a href="<?php echo get_permalink($post->ID) ?>" class="b-post-grid--item col-1-3">
						<div class="b-post-grid--thumb">
							<?php
							$attachmentID = get_post_thumbnail_id($post->ID);
							$src = wp_get_attachment_image_src($attachmentID, 'related-post-thumb');
							$srcset = wp_get_attachment_image_srcset($attachmentID, 'related-post-thumb'); ?>
							<?php if($attachmentID): ?>
								<img src="<?=$src[0]?>" srcset="<?=$srcset?>" />
							<?php else: ?>
								<img src="<?php echo get_default_blog_image(); ?>" />
							<?php endif; ?>
							<?php if ( in_category('videos') ): ?>
								<span class="video-play"></span>
							<?php endif; ?>
						</div>
						<div class="b-post-grid--content">
							<p class="b-grid--category"><?php single_cat_title(); ?></p>
							<h3 class="b-grid--post-title"><?php the_title() ?></h3>
							<p class="b-post-grid--date"><?php the_time('n/j/y'); ?></p>
						</div>
					</a>

				<?php endwhile; ?>

				<?php post_navigation(); ?>

				<?php else : ?>
					<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
				<?php endif; ?>
			</div>

		</div>
	</section>

</main>

<?php get_footer(); ?>
