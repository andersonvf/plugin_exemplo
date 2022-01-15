<?php
/**
 * Plugin Name:       Contact Management
 * Plugin URI:        http://andersonferreira.eu1.alfasoft.pt
 * Description:       A Contact Management Plugin.
 * Version:           1.0.0
 * Author:            Anderson Ferreira
 * Author URI:        http://andersonferreira.eu1.alfasoft.pt
 * License:           GPL v2 or later
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH') ) {
    die( 'Invalid request.' );
}

class ContactManagement {
    public function __construct() {
        add_action( 'init', Array($this,'create_custom_post_type_modulo') );
    }

    public function create_custom_post_type_modulo() {
        $labels = array(
            'name'                  => _x( 'Contact Management', 'contact_management', 'text_domain' ),
            'singular_name'         => _x( 'Contact Management', 'contact_management', 'text_domain' ),
            'menu_name'             => __( 'Contact Management', 'text_domain' ),
            'name_admin_bar'        => __( 'Contact Management', 'text_domain' ),
        );

        $args = array(
            'label'                 => __( 'Contact Management', 'text_domain' ),
            'description'           => __( 'Lista de Contatos', 'text_domain' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 3,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'menu_icon'             => 'dashicons-list-view',
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability'            => 'page',     
        );
        
        register_post_type( 'contact_management', $args );
    }
    public function activate() {
        $this->create_custom_post_type_modulo();
        flush_rewrite_rules();
    }

    public function deactivate() {
        flush_rewrite_rules();
    }

    public function uninstall() {
        flush_rewrite_rules();
        global $wpdb;
        $wpdb->get_results("delete from wp_post_type='contact_management';");
    }
}

if ( class_exists( 'ContactManagement' ) ){
    $didoxModulo = new ContactManagement();
    register_activation_hook( __FILE__,array( $didoxModulo, 'activate') );
    register_deactivation_hook( __FILE__,array( $didoxModulo, 'deactivate') );
    register_uninstall_hook( __FILE__,array( $didoxModulo, 'uninstall') );
}
?>