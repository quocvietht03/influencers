<?php
/**
 * Import pack hooks
 *
 * @package Import Pack
 */

add_action( 'admin_init', 'influencers_import_pack_defineds' );
add_action( 'admin_menu', 'influencers_register_import_menu' );
