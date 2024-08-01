<?php
/* Register Sidebar */
if (!function_exists('influencers_register_sidebar')) {
	function influencers_register_sidebar(){
		register_sidebar(array(
			'name' => esc_html__('Main Sidebar', 'influencers'),
			'id' => 'main-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
		));
	}
	add_action( 'widgets_init', 'influencers_register_sidebar' );
}

/* Add Support Upload Image Type SVG */
function influencers_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'influencers_mime_types');

/* Register Default Fonts */
if (!function_exists('influencers_fonts_url')) {
	function influencers_fonts_url() {
		global $influencers_options;
		$base_font = 'Muli';
		$head_font = 'Montserrat';

		$font_url = '';
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'influencers' ) ) {
			$font_url = add_query_arg( 'family', urlencode( $base_font.':400,400i,600,700|'.$head_font.':400,400i,500,600,700' ), "//fonts.googleapis.com/css" );
		}
		return $font_url;
	}
}
/* Enqueue Script */
if (!function_exists('influencers_enqueue_scripts')) {
	function influencers_enqueue_scripts() {
		global $influencers_options;

		if(is_singular('product')) {
			/* Slick Slider */
			wp_enqueue_script('slick-slider', get_template_directory_uri().'/assets/libs/slick/slick.min.js', array('jquery'), '', true);
			wp_enqueue_style('slick-slider', get_template_directory_uri(). '/assets/libs/slick/slick.css',array(), false);

			/* Slick Slider */
			wp_enqueue_script('zoom-master', get_template_directory_uri().'/assets/libs/zoom-master/jquery.zoom.min.js', array('jquery'), '', true);
		}

		/* Fonts */
		wp_enqueue_style('influencers-fonts', influencers_fonts_url(), false );
		wp_enqueue_style( 'influencers-main', get_template_directory_uri().'/assets/css/main.css',  array(), false );
		wp_enqueue_style( 'influencers-style', get_template_directory_uri().'/style.css',  array(), false );
		wp_enqueue_script( 'influencers-main', get_template_directory_uri().'/assets/js/main.js', array('jquery'), '', true);

		/* Load custom style */
		$custom_style = '';
		$custom_style .= '.test{color: red;}';

		if($custom_style){
			wp_add_inline_style( 'influencers-style', $custom_style );
		}

		/* Custom script */
		$custom_script = '';
		if (isset($influencers_options['custom_js_code']) && $influencers_options['custom_js_code']) {
			$custom_script .= $influencers_options['custom_js_code'];
		}
		if ($custom_script) {
			wp_add_inline_script( 'influencers-main', $custom_script );
		}

		/* Options to script */
		$mobile_width = 991;

		$js_options = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'enable_mobile' => $mobile_width
		);
		wp_localize_script( 'influencers-main', 'option_ob', $js_options );
		wp_enqueue_script( 'influencers-main' );

	}
	add_action( 'wp_enqueue_scripts', 'influencers_enqueue_scripts' );
}

/* Add Stylesheet And Script Backend */
if (!function_exists('influencers_enqueue_admin_scripts')) {
	function influencers_enqueue_admin_scripts(){
		wp_enqueue_script( 'influencers-admin-main', get_template_directory_uri().'/assets/js/admin-main.js', array('jquery'), '', true);
		wp_enqueue_style( 'influencers-admin-main', get_template_directory_uri().'/assets/css/admin-main.css', array(), false );
	}
	add_action( 'admin_enqueue_scripts', 'influencers_enqueue_admin_scripts');
}

/**
 * Theme install
 */
require_once get_template_directory() . '/install/plugin-required.php';
require_once get_template_directory() . '/install/import-pack/import-functions.php';

/* CPT Load */
require_once get_template_directory().'/framework/cpt-service.php';
require_once get_template_directory().'/framework/cpt-team.php';
require_once get_template_directory().'/framework/cpt-testimonial.php';
require_once get_template_directory().'/framework/cpt-podcast.php';
require_once get_template_directory().'/framework/cpt-client.php';
require_once get_template_directory().'/framework/cpt-pricing.php';

/* ACF Options */
require_once get_template_directory() . '/framework/acf-options.php';

/* Shortcodes */
require_once get_template_directory().'/framework/shortcodes.php';

/* Add Comment Rating */
require_once get_template_directory().'/framework/comment-rating.php';

/* Template functions */
require_once get_template_directory().'/framework/template-helper.php';

/* Post Functions */
require_once get_template_directory().'/framework/templates/post-helper.php';

/* Block Load */
require_once get_template_directory().'/framework/block-load.php';

/* Widgets Load */
require_once get_template_directory().'/framework/widget-load.php';

/* Woocommerce functions */
if (class_exists('Woocommerce')) {
    require_once get_template_directory().'/woocommerce/shop-helper.php';
}

if(function_exists('get_field')){
	/* Orbit circle effect */
	function influencers_body_class($classes) {
		$orbit_circle = get_field('effect_orbit_circle', 'options');
		$bg_pattern = get_field('effect_bg_pattern', 'options');
		$bg_buble = get_field('effect_bg_buble', 'options');
		$bg_scroll = get_field('effect_bg_scroll', 'options');
		$img_zoom = get_field('effect_img_zoom', 'options');

		if($orbit_circle) {
			$classes[] = 'bt-orbit-enable';
		}

		if($bg_pattern) {
			$classes[] = 'bt-bg-pattern-enable';
		}

		if($bg_buble) {
			$classes[] = 'bt-bg-buble-enable';
		}

		if($bg_scroll) {
			$classes[] = 'bt-bg-scroll-enable';
		}

		if($img_zoom) {
			$classes[] = 'bt-img-zoom-enable';
		}

		return $classes;
	}
	add_filter('body_class', 'influencers_body_class');

	/* Search filter results */
	function influencers_search_filter_results($query) {
		if ( !is_admin() && $query->is_main_query() ) {
			if ($query->is_search) {
				$query->set('post_type', array('team'));
				$query->set('posts_per_page', 8);
			}
			if (is_tax('team_categories')) {
			 $query->set( 'posts_per_page', 8 );
			}
		}
	}

	$team_sft = get_field('team_search_filter_results', 'options');
	if($team_sft || is_tax('team_categories')) {
		add_action('pre_get_posts','influencers_search_filter_results');
	}
}
