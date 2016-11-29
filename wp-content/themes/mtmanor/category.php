<?php

get_header();

$category = get_category($cat);
$category_parent = $category->parent;
$category_ID = $category->cat_ID;

if($category_ID === 40)
	get_template_part( 'partials/category-parent-video' );
elseif($category_parent === 40)
	get_template_part( 'partials/category-child-video' );
elseif($category_parent === 0)
	get_template_part( 'partials/category-parent' );
else
	get_template_part( 'partials/category-child' );

get_footer();

?>