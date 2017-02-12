<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <?php $category = get_the_category(); ?>

  <header class="post-header">
    <h1 class="post-title title__h1"><?php the_title(); ?></h1>
    <p class="post-meta">Publicerat som <a href="<?php echo get_term_link($category[0]); ?>"><?php echo $category[0]->name; ?></a></p>
    <?php // get_template_part( 'partials/post-share' ); ?>
  </header>

    <?php if ( has_post_thumbnail() ): ?>
			<div class="post-hero">
        <?php
        $attachmentID = get_post_thumbnail_id();
        $src = wp_get_attachment_image_src($attachmentID, 'full-post-image');
        $srcset = wp_get_attachment_image_srcset($attachmentID, 'full-post-image'); ?>
        <img src="<?=$src[0]?>" srcset="<?=$srcset?>" />
			</div>
		<?php endif; ?>

		<div class="post-content body-content">
			<?php the_content(); ?>
		</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
