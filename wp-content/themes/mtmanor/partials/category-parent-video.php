<main class="b-main" role="main">

	<section class="b-page-header">
		<div class="b-container">

			<h1 class="b-page-title"><?php single_cat_title(); ?></h1>

			<div class="b-featured-posts b-featured-vidoes b-featured-slider">
				<?php
				$featured_posts = get_field('videos_featured_posts', 'option');
				if( $featured_posts ): ?>
					<?php foreach( $featured_posts as $p ): ?>
						<div class="b-featured-post">
							<div class="flex-row">

								<div class="b-featured-post--thumb">
									<a href="<?php echo get_permalink( $p->ID ); ?>">
										<?php
						        $attachmentID = get_post_thumbnail_id($p->ID);
						        $src = wp_get_attachment_image_src($attachmentID, 'featured-video-thumb');
						        $srcset = wp_get_attachment_image_srcset($attachmentID, 'featured-video-thumb'); ?>
						        <img src="<?=$src[0]?>" srcset="<?=$srcset?>" />
										<span class="video-play"></span>
									</a>
								</div>

								<div class="b-featured-post--content">
									<div class="b-featured-post--content-container">
										<p class="b-featured-post--category">Today’s Must-Reads</p>
										<h2 class="b-featured-post--title"><a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a></h2>
										<p class="b-featured-post--teaser"><?php echo wp_trim_words( get_post_field('post_content', $p->ID), 20, '...' ); ?></p>
										<p><a href="<?php echo get_permalink( $p->ID ); ?>" class="b-btn b-btn__blue">Watch Video
											<svg class="icon-arrow-right">
												<use xlink:href="#icon-arrow-right"></use>
											</svg>
										</a></p>
									</div>
								</div>

							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

		</div>
	</section>

	<?php
	foreach(get_the_category($post->ID) as $cat) {
		if(!$cat->parent): ?>
			<section class="b-category-row">
				<div class="b-container">
					<?php
					$sub_cats = get_categories('parent='.$cat->term_id);
					if($sub_cats) foreach($sub_cats as $sub_cat) { ?>
						<div class="b-category-row">
							<div class="b-category-row--header">
								<h2 class="b-category-title"><?php echo $sub_cat->name; ?></h2>

								<div class="b-filters">
									<div class="b-filters--label">Filter by Tags</div>
									<ul class="b-filters--tags">
										<?php
										$tags = get_field('tag_filters', 'options');

										foreach($tags as $tag) {

											$tag = get_term_by('id', $tag['tag'], 'post_tag');

											// we need to see if this tag has any posts in common with this category
											$intersect = get_posts(
												array(
													'post_type' => 'post',
													'category' => $sub_cat->term_id,
													'tag_id' => $tag->term_id,
													'numberposts' => -1
												)
											);

											if(count($intersect) > 0) { ?>
												<li><a href="<?=get_term_link($sub_cat->term_id, 'category')?>?filter=<?=$tag->term_id?>"><?=$tag->name?></a></li>
											<?php } // endif intersect
										} // endforeach tags ?>
									</ul>
								</div>
							</div><!-- header -->

							<div class="b-video-grid flex-grid">
								<?php
								foreach (array_slice(get_posts('cat='.$sub_cat->term_id), 0, 4) as $post) {
								setup_postdata( $post ); ?>
									<a href="<?php echo get_permalink($post->ID) ?>" class="b-video-grid--item col-1-2">
										<div class="b-video-grid--thumb">
											<?php
							        $attachmentID = get_post_thumbnail_id($post->ID);
							        $src = wp_get_attachment_image_src($attachmentID, 'video-grid-thumb');
							        $srcset = wp_get_attachment_image_srcset($attachmentID, 'video-grid-thumb'); ?>
											<?php if($attachmentID): ?>
								        <img src="<?=$src[0]?>" srcset="<?=$srcset?>" />
											<?php else: ?>
												<img src="<?php echo get_default_blog_image('video-grid-thumb'); ?>" />
											<?php endif; ?>
											<span class="video-play"></span>
			              </div>
										<div class="b-video-grid--content">
											<p class="b-grid--category"><?php echo $sub_cat->name; ?></p>
											<h3 class="b-grid--post-title"><?php echo get_the_title() ?></h3>
										</div>
									</a>
						    <?php } ?>
							</div>
							<?php
							$args = array('category' => $sub_cat->term_id);
							$posts = get_posts($args);
							$count = count($posts);
							if ($count > 2) { ?>
								<a href="<?php echo $sub_cat->slug; ?>" class="b-see-more-btn">
									See More
			  					<svg class="icon-arrow-right">
			  						<use xlink:href="#icon-arrow-right"></use>
			  					</svg>
								</a>
							<?php } ?>
						</div><!-- category row -->

					<?php } ?>
				</div>
			</section><!-- category row -->
		<?php endif; ?>
	<?php } ?>

</main>
