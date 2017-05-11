<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <?php $category = get_the_category(); ?>

  <header class="post-header">
    <h1 class="post-title title__h1"><?php the_title(); ?></h1>
    <p class="post-meta">Publicerat som <a href="<?php echo get_term_link($category[0]); ?>"><?php echo $category[0]->name; ?></a></p>
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

    <?php $steps_title = get_field('steps_title'); ?>
    <?php if ($steps_title): ?>
      <section class="guide-steps">
        <div class="container">
          <h2 class="guide-steps--title title__h1"><?php echo $steps_title; ?></h2>

          <?php if( have_rows('steps') ): ?>
            <div class="steps-list">
            	<?php while( have_rows('steps') ): the_row(); ?>
                <div class="steps-list--item">
                  <div class="steps-list--thumb">
                    <?php
                    $imageID = get_sub_field('step_image');
                    $src = wp_get_attachment_image_src($imageID, 'guide-thumb');
                    $srcset = wp_get_attachment_image_srcset($imageID, 'guide-thumb'); ?>
                    <img src="<?=$src[0]?>" srcset="<?=$srcset?>" />
                  </div>
                  <div class="steps-list--description">
                    <?php the_sub_field('step_description'); ?>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          <?php endif; ?>

        </div>
      </section>
    <?php endif; ?>

<?php endwhile; endif; ?>

<section class="recent-news">
	<div class="container">
		<h2 class="section-title title__h1">Nyheter</h2>

		<?php
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3
		);
		$wp_query = new WP_Query( $args ); ?>

		<?php if ( $wp_query->have_posts() ) : ?>
			<div class="post-grid flex-grid">
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

          <?php get_template_part('partials/news-grid-item'); ?>

				<?php endwhile; ?>
			</div>

			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
