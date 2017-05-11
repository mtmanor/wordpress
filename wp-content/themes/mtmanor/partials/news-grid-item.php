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
