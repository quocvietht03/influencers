<?php
/**
 * Import pack data package demo
 *
 */
$plugin_includes = array(
  array(
    'name'     => __( 'Elementor Website Builder', 'influencers' ),
    'slug'     => 'elementor',
  ),
  array(
    'name'     => __( 'Elementor Pro', 'influencers' ),
    'slug'     => 'elementor-pro',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'elementor-pro.zip',
  ),
  array(
    'name'     => __( 'Advanced Custom Fields PRO', 'influencers' ),
    'slug'     => 'advanced-custom-fields-pro',
    'source'   => IMPORT_REMOTE_SERVER_PLUGIN_DOWNLOAD . 'advanced-custom-fields-pro.zip',
  ),
  array(
    'name'     => __( 'Newsletter', 'influencers' ),
    'slug'     => 'newsletter',
  ),
  array(
    'name'     => __( 'WooCommerce', 'influencers' ),
    'slug'     => 'woocommerce',
  ),

);

return apply_filters( 'influencers/import_pack/package_demo', [
    [
        'package_name' => 'influencers-main',
        'preview' => get_template_directory_uri() . '/screenshot.jpg',
        'url_demo' => 'https://influencer.beplusthemes.com/',
        'title' => __( 'Influencers Demo', 'influencers' ),
        'description' => __( 'Influencers main demo.', 'influencers' ),
        'plugins' => $plugin_includes,
    ],
] );
