<?php if( is_product_category() ): ?>
<nav class="sidebar-nav">
	<h4 class="title__h5 sidebar-nav--title">Kategori</h4>
	<?php
		$current_cat_id = get_queried_object_id();
		$current_cat = get_term($current_cat_id);
		$parent = $current_cat->parent;

		if($parent == 0) {
			$args = array(
				'parent' => $current_cat_id
			);
		} else {
			$args = array(
				'parent' => $parent
			);
		}

		$terms = get_terms( 'product_cat', $args );

		if ( $terms ) {
			echo '<div class="sidebar-nav--categories">';
			foreach ( $terms as $term ) {
				echo '<a href="'.  esc_url( get_term_link( $term ) ) .'"';
				if ($term == $current_cat) {
					echo 'class="current-menu-item"';
				}
				echo '>';
				echo $term->name;
				echo '</a>';
			}
			echo '</div>';
		}
	?>
</nav>
<?php else: ?>
	<nav class="sidebar-nav">
		<h4 class="title__h5 sidebar-nav--title">Kategori</h4>
		<?php
			$args = array(
				'parent' => 0
			);

			$terms = get_terms( 'product_cat', $args );

			if ( $terms ) {
				echo '<div class="sidebar-nav--categories">';
				foreach ( $terms as $term ) {
					echo '<a href="'.  esc_url( get_term_link( $term ) ) .'"';
					echo '>';
					echo $term->name;
					echo '</a>';
				}
				echo '</div>';
			}
		?>
	</nav>
<?php endif; ?>


<?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
<aside id="sidebar" role="complementary">
	<div id="primary" class="widget-area">
		<ul class="xoxo">
			<?php dynamic_sidebar( 'primary-widget-area' ); ?>
		</ul>
	</div>
</aside>
<?php endif; ?>
