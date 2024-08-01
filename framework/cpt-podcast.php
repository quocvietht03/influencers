<?php
/*
 * Podcast CPT
 */

function influencers_podcast_register() {

	$cpt_slug = get_theme_mod('influencers_podcast_slug');

	if(isset($cpt_slug) && $cpt_slug != ''){
		$cpt_slug = $cpt_slug;
	} else {
		$cpt_slug = 'podcast';
	}

	$labels = array(
		'name'               => esc_html__( 'Podcasts', 'influencers' ),
		'singular_name'      => esc_html__( 'Podcast', 'influencers' ),
		'add_new'            => esc_html__( 'Add New', 'influencers' ),
		'add_new_item'       => esc_html__( 'Add New Podcast', 'influencers' ),
		'all_items'          => esc_html__( 'All Podcasts', 'influencers' ),
		'edit_item'          => esc_html__( 'Edit Podcast', 'influencers' ),
		'new_item'           => esc_html__( 'Add New Podcast', 'influencers' ),
		'view_item'          => esc_html__( 'View Item', 'influencers' ),
		'search_items'       => esc_html__( 'Search Podcasts', 'influencers' ),
		'not_found'          => esc_html__( 'No podcast(s) found', 'influencers' ),
		'not_found_in_trash' => esc_html__( 'No podcast(s) found in trash', 'influencers' )
	);

  $args = array(
		'labels'          => $labels,
		'public'          => true,
		'show_ui'         => true,
		'capability_type' => 'post',
		'hierarchical'    => false,
		'menu_icon'       => 'dashicons-admin-post',
		'rewrite'         => array('slug' => $cpt_slug), // Permalinks format
		'supports'        => array('title', 'editor', 'excerpt', 'thumbnail')
  );

  add_filter( 'enter_title_here',  'influencers_podcast_change_default_title');

  register_post_type( 'podcast' , $args );
}
add_action('init', 'influencers_podcast_register', 1);


function influencers_podcast_taxonomy() {

	register_taxonomy(
		"podcast_categories",
		array("podcast"),
		array(
			"hierarchical"   => true,
			"label"          => "Categories",
			"singular_label" => "Category",
			"rewrite"        => true
		)
	);

	register_taxonomy(
        'podcast_tag',
        'podcast',
        array(
            'hierarchical'  => false,
            'label'         => __( 'Tags', 'influencers' ),
            'singular_name' => __( 'Tag', 'influencers' ),
            'rewrite'       => true,
            'query_var'     => true
        )
    );

}
add_action('init', 'influencers_podcast_taxonomy', 1);


function influencers_podcast_change_default_title( $title ) {
	$screen = get_current_screen();

	if ( 'podcast' == $screen->post_type )
		$title = esc_html__( "Enter the podcast's name here", 'influencers' );

	return $title;
}


function influencers_podcast_edit_columns( $podcast_columns ) {
	$podcast_columns = array(
		"cb"                     => "<input type=\"checkbox\" />",
		"title"                  => esc_html__('Title', 'influencers'),
		"thumbnail"              => esc_html__('Thumbnail', 'influencers'),
		"podcast_categories" 			 => esc_html__('Categories', 'influencers'),
		"date"                   => esc_html__('Date', 'influencers'),
	);
	return $podcast_columns;
}
add_filter( 'manage_edit-podcast_columns', 'influencers_podcast_edit_columns' );

function influencers_podcast_column_display( $podcast_columns, $post_id ) {

	switch ( $podcast_columns ) {

		// Display the thumbnail in the column view
		case "thumbnail":
			$width = (int) 64;
			$height = (int) 64;
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

			// Display the featured image in the column view if possible
			if ( $thumbnail_id ) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			}
			if ( isset( $thumb ) ) {
				echo $thumb; // No need to escape
			} else {
				echo esc_html__('None', 'influencers');
			}
			break;

		// Display the podcast tags in the column view
		case "podcast_categories":

		if ( $category_list = get_the_term_list( $post_id, 'podcast_categories', '', ', ', '' ) ) {
			echo $category_list; // No need to escape
		} else {
			echo esc_html__('None', 'influencers');
		}
		break;
	}
}
add_action( 'manage_podcast_posts_custom_column', 'influencers_podcast_column_display', 10, 2 );
