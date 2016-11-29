<ul class="b-post-share">
	<li class="b-post-share--label">Share this post:</li>
	<li>
		<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="js-social-share" target="_blank">
			<svg class="icon-facebook">
				<use xlink:href="#icon-facebook"></use>
			</svg>
		</a>
	</li>
	<li>
		<a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>&via=chewy" class="js-social-share" target="_blank">
			<svg class="icon-twitter">
				<use xlink:href="#icon-twitter"></use>
			</svg>
		</a>
	</li>
	<li>
		<a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php the_post_thumbnail_url(); ?>" class="js-social-share" target="_blank">
			<svg class="icon-pinterest">
				<use xlink:href="#icon-pinterest"></use>
			</svg>
		</a>
	</li>
</ul>
