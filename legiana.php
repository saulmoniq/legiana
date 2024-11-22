<?php
/*
    * Plugin name: Legiana
    * Plugin URI: https://saulmoniquedev.com
    * Description: Cambia las categorías de tu tienda por una selección personal.
    * Versión: 1.0
    * Author: Saúl Monique
    * Author URI: https://saulmoniquedev.com
    * License: Todos los derechos reservados.
*/
// main-file.php
require_once('admin/taxonomy.php');
require_once( plugin_dir_path( __FILE__ ) . 'admin/admin-post.php' );
// Creating the top level menu
add_action( 'admin_menu', 'wporg_options_pages' );

function my_plugin_admin_css() {
    wp_enqueue_style( 'my-plugin-admin-style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
    wp_enqueue_style( 'my-plugin-admin-style', 'screen' ); // Specify 'screen' for admin area
  }
  
  add_action( 'admin_enqueue_scripts', 'my_plugin_admin_css' );
  

function wporg_options_pages() {
    add_menu_page(
        'Legiana',
        'Legiana Options', //name in the menu
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/view.php',
        null,
       'dashicons-admin-links', //icon
        20
    );
    
    add_submenu_page(
        plugin_dir_path(__FILE__) . 'admin/view.php',
        'Export categories',
        'Export',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/exportjson.php'
    );
}
function your_submenu_page_callback_function() {
    echo '<h1>Content for your Submenu Page</h1>';
    // Add your custom HTML content here using standard WordPress functions like echo or printf
  }
  

add_action( 'admin_post_your_update_function_hook', 'your_update_function' );

// Hook registrations

//Add and save the meta field for a taxonomy
add_action( 'product_cat_edit_form_fields', 'add_new_meta_tax', 10, 2 );
add_action( 'product_cat_edit_form_fields', 'add_new_meta_tax_v2', 10, 2 );
add_action( 'edited_product_cat', 'save_new_meta_tax', 10, 2 );