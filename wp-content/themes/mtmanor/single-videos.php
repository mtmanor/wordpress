<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<main class="b-main" role="main">

  <article class="b-video-post">
    <div class="b-container">

      <?php $category = get_the_category(); ?>
      <h1 class="b-post-title"><?php the_title(); ?></h1>
      <p class="b-post-meta"><?php echo $category[0]->name; ?> / Posted on <?php the_date('n-j-y'); ?></p>
      <div class="b-post-hero">
        <div class="b-video-post-embed">
          <?php the_field('video_embed_code'); ?>
        </div>
        <div class="b-video-post-nav">
          <div class="b-video-post-nav--prev">
            <?php $prev_link = previous_post_link( '%link', '<svg class="icon-slider-arrow-left b-video-post-nav--icon"><use xlink:href="#icon-slider-arrow-left"></use></svg>', TRUE, $category[0]->term_id );
            echo $prev_link; ?>
          </div>
          <div class="b-video-post-nav--next">
            <?php
            $next_link = next_post_link( '%link', '<svg class="icon-slider-arrow-right b-video-post-nav--icon"><use xlink:href="#icon-slider-arrow-right"></use></svg>', TRUE, $category->cat_id );
            echo $next_link; ?>
          </div>
        </div>
      </div>

      <?php
      $related_videos = get_field('related_videos');
      if( $related_videos ): ?>
      <div class="b-related-videos">
        <h2 class="b-related-videos--section-title">Related Videos</h2>
        <div class="b-related-videos-grid">
          <?php foreach( $related_videos as $p ): ?>
            <a href="<?php the_permalink($p->ID); ?>" class="b-related-videos--item col-1-3">
              <div class="b-related-videos--thumb">
                <?php
                $attachmentID = get_post_thumbnail_id($p->ID);
                $src = wp_get_attachment_image_src($attachmentID, 'featured-product-thumb');
                $srcset = wp_get_attachment_image_srcset($attachmentID, 'featured-product-thumb'); ?>
                <img src="<?=$src[0]?>" srcset="<?=$srcset?>" />
                <span class="video-play"></span>
              </div>
              <div class="b-related-videos--info">
                <?php $category = get_the_category( $p->ID ); ?>
                <p class="b-related-videos--category"><?php echo $category[0]->name; ?></p>
                <h3 class="b-related-videos--title"><?php echo get_the_title( $p->ID ); ?></h3>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

		</div>
	</article>

  <div class="b-back-to-blog">
    <p><a href="<?php echo site_url(); ?>" class="b-back-to-blog--link">
      <svg class="icon-arrow-left">
        <use xlink:href="#icon-arrow-left"></use>
      </svg>
    Go back to main blog</a></p>
  </div>

</main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
