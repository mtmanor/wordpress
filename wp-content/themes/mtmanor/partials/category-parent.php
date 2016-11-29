<main class="b-main" role="main">

	<section class="b-page-header">
		<div class="b-container">

			<h1 class="b-page-title"><?php single_cat_title(); ?></h1>

			<div class="b-featured-posts b-featured-slider">
				<?php
				if ($cat == '2'):
					$featured_posts = get_field('food_nutrition_featured_posts', 'option');
				elseif ($cat == '3'):
					$featured_posts = get_field('health_wellness_featured_posts', 'option');
				elseif ($cat == '4'):
					$featured_posts = get_field('training_behavior_featured_posts', 'option');
				elseif ($cat == '5'):
					$featured_posts = get_field('fun_exercise_featured_posts', 'option');
				endif;
				if( $featured_posts ): ?>
					<?php foreach( $featured_posts as $p ): ?>
						<div class="b-featured-post">
							<div class="flex-row">

								<div class="b-featured-post--thumb">
									<a href="<?php echo get_permalink( $p->ID ); ?>">
										<?php
						        $attachmentID = get_post_thumbnail_id($p->ID);
						        $src = wp_get_attachment_image_src($attachmentID, 'featured-post-thumb');
						        $srcset = wp_get_attachment_image_srcset($attachmentID, 'featured-post-thumb'); ?>
						        <img src="<?=$src[0]?>" srcset="<?=$srcset?>" />

									</a>
								</div>

								<div class="b-featured-post--content">
									<div class="b-featured-post--content-container">
										<p class="b-featured-post--category">Today’s Must-Reads</p>
										<h2 class="b-featured-post--title"><a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a></h2>
										<p class="b-featured-post--teaser"><?php echo wp_trim_words( get_post_field('post_content', $p->ID), 20, '...' ); ?></p>
										<p><a href="<?php echo get_permalink( $p->ID ); ?>" class="b-btn b-btn__blue">Continue Reading
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


			<section class="b-sub-categories">
				<div class="b-container">
					<?php
					$sub_cats = get_terms(
						array(
							'parent' => $cat,
							'taxonomy'=>'category'
						)
					);
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

							<div class="b-post-grid flex-grid">
								<?php
								foreach (array_slice(get_posts('cat='.$sub_cat->term_id), 0, 3) as $post) {
								setup_postdata( $post ); ?>
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
											<p class="b-grid--category"><?php echo $sub_cat->name; ?></p>
											<h3 class="b-grid--post-title"><?php echo get_the_title() ?></h3>
											<p class="b-post-grid--date"><?php echo get_the_time('n/j/y'); ?></p>
										</div>
									</a>
						    <?php } ?>
							</div>
							<?php
							$args = array('category' => $sub_cat->term_id);
							$posts = get_posts($args);
							$count = count($posts);
							if ($count > 3) { ?>
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
			</section>

</main>
