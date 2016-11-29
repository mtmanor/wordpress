<?php
// let's grab the current cat,
// we're going to use this a lot
$category = get_category(get_query_var('cat'));

// let's grab the terms that we can use as filters
$tags = get_field('tag_filters', 'options');

// lets make an array to hold some valid ids
$valid_filters = array();

// shove the ids from all our filters in our array
// so we can easily validate our query parameters
foreach($tags as $t) {
  $valid_filters[] = $t['tag'];
}

// do we have a filter
$filter = (array_key_exists('filter', $_GET) && strlen($_GET['filter']));

// save the value of our filter
$term = $_GET['filter'];

// if we have a filter and the filter is valid
// we're going to modify the query
if($filter && in_array($term, $valid_filters)) {
	$filtered = true;

	// let's make our new query
	global $wp_query;
	$args = array_merge(
		$wp_query->query_vars,
		array(
			'category' => $category->term_id,
			'tag_id' => $term
		)
	);

	query_posts( $args );
}
?>

<main class="b-main" role="main">

	<section class="b-subcat-header">
		<div class="b-container">

			<?php
			$parent_category = $category->category_parent;
			$parent_category_name = get_cat_name($parent_category); ?>
			<h1 class="b-page-title">
				<a href="../"><?php echo $parent_category_name; ?></a>
				<svg class="icon-arrow-right">
					<use xlink:href="#icon-arrow-right"></use>
				</svg>
				<span class="b-page-title--subcat"><?php single_cat_title(); ?></span>
			</h1>

		</div>
	</section>

	<section class="b-subcat">
		<div class="b-container">

			<div class="b-sub-category--header">
				<div class="b-filters">
					<div class="b-filters--label">Filter by Tags</div>
					<ul class="b-filters--tags">
						<li><a href="<?=get_term_link($category->term_id, 'category')?>" class="<?=(!$filtered ? 'is-active' : '')?>">All</a></li>
						<?php
						foreach($tags as $tag) {

							$tag = get_term_by('id', $tag['tag'], 'post_tag');

							// we need to see if this tag has any posts in common with this category
							$intersect = get_posts(
								array(
									'post_type' => 'post',
									'category' => $category->term_id,
									'tag_id' => $tag->term_id,
									'numberposts' => -1
								)
							);

							if(count($intersect) > 0) { ?>
								<li><a href="<?=get_term_link($category->term_id, 'category')?>?filter=<?=$tag->term_id?>" class="<?=((int) $term === (int) $tag->term_id ? 'is-active' : '')?>"><?=$tag->name?></a></li>
							<?php } // endif intersect
						} // endforeach tags ?>
					</ul>
				</div>
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
					<div class="col-1-2"><?php _e( 'Sorry, no posts matched your criteria.' ); ?></div>
				<?php endif; ?>
			</div>

		</div>
	</section>

</main>
