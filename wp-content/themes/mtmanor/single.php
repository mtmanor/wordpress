<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php $category = get_the_category(); ?>

  <main class="b-main" role="main">

  	<section class="b-post">

  		<article class="b-post-content">
  			<div class="b-post-content--container">

  				<h1 class="b-post-title"><?php the_title(); ?></h1>
  				<p class="b-post-meta"><a href="<?php echo get_term_link($category[1]); ?>"><?php echo $category[1]->name; ?></a> / Posted on <?php the_date('n-j-y'); ?></p>
  				<div class="b-post-hero">
  					<?php
  					$attachmentID = get_post_thumbnail_id();
  					$src = wp_get_attachment_image_src($attachmentID, 'full-post-image');
  					$srcset = wp_get_attachment_image_srcset($attachmentID, 'full-post-image'); ?>
  					<img src="<?=$src[0]?>" srcset="<?=$srcset?>" />
  				</div>
  				<p class="b-post-author">Posted by <?php the_author(); ?></p>
          <?php get_template_part( 'partials/post-share' ); ?>

  				<div class="b-post-body">
  					<?php the_content(); ?>
  				</div>

  				<div class="b-post-tags">
  					<h4 class="b-post-tags--title">Tags</h4>
  					<?php
  					$posttags = get_the_tags();
  					if ($posttags) {
  					  foreach($posttags as $tag) {
  					    echo '<a href="' . get_term_link($tag) . '" class="b-post-tags--item">' . $tag->name . '</a>';
  					  }
  					}
  					?>
  				</div>

          <?php
          $products = get_field('post_featured_products');
          if( $products ): ?>
  				<div class="js-featured-products b-featured-products" data-products="<?=str_replace(' ', '', $products)?>">
  					<h3 class="b-section-title">Featured Products</h3>
  					<div class="js-featured-products-grid b-featured-products-grid">

  					</div>
  				</div>
          <?php endif; ?>

  			</div>
  		</article>

  		<aside class="b-post-sidebar">
  			<h3 class="b-section-title">Related Articles</h3>
  			<div class="b-related-posts">
  				<?php
  				$related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 6, 'post__not_in' => array($post->ID) ) );
  					if( $related ) foreach( $related as $post ) { setup_postdata($post); ?>
  						<a href="<?php echo get_permalink(); ?>" class="b-related-posts--item">
  							<div class="b-related-posts--thumb">
  								<?php
  								$attachmentID = get_post_thumbnail_id($post->ID);
  								$src = wp_get_attachment_image_src($attachmentID, 'post-grid-thumb');
  								$srcset = wp_get_attachment_image_srcset($attachmentID, 'post-grid-thumb'); ?>
  								<?php if($attachmentID): ?>
  									<img src="<?=$src[0]?>" srcset="<?=$srcset?>" />
  								<?php else: ?>
  									<img src="<?php echo get_default_blog_image(); ?>" />
  								<?php endif; ?>
  							</div>
  							<div class="b-related-posts--content">
  								<?php $category = get_the_category(); ?>
  								<p class="b-related-posts--category"><?php echo esc_html( $category[1]->name ); ?></p>
  								<h3 class="b-related-posts--title"><?php echo get_the_title(); ?></h3>
  								<p class="b-related-posts--date"><?php echo get_the_date('n/j/y'); ?></p>
  								<p class="b-related-posts--meta">430 Views</p>
  							</div>
  						</a>
  					<?php } ?>
  				<?php wp_reset_postdata(); ?>

  				<a href="<?php echo get_term_link($category[0]); ?>" class="b-see-more-btn">
  					See More
  					<svg class="icon-arrow-right">
  						<use xlink:href="#icon-arrow-right"></use>
  					</svg>
  				</a>

  			</div>
  		</aside>

  		<div class="b-back-to-blog">
  			<p><a href="<?php echo site_url(); ?>" class="b-back-to-blog--link">
  				<svg class="icon-arrow-left">
  					<use xlink:href="#icon-arrow-left"></use>
  				</svg>
  			Go back to main blog</a></p>
  		</div>

  	</section>

  </main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
