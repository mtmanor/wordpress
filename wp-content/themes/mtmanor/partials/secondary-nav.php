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
		echo '<nav class="secondary-nav">';
		echo '<div class="container">';

		foreach ( $terms as $term ) {
			echo '<a href="' .  esc_url( get_term_link( $term ) ) . '">';
			echo $term->name;
			echo '</a>';
		}

		echo '</div>';
		echo '</nav>';
	}
?>
