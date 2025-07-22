<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handles the registration of the Recipe Custom Post Type.
 */
class RMP_Recipe_CPT {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_cpt' ) );
    }

    /**
     * Register the 'recipe' custom post type.
     */
    public function register_cpt() {
        $labels = array(
            'name'                  => _x( 'Recipes', 'Post Type General Name', 'recipe-manager-plugin' ),
            'singular_name'         => _x( 'Recipe', 'Post Type Singular Name', 'recipe-manager-plugin' ),
            'menu_name'             => __( 'Recipes', 'recipe-manager-plugin' ),
            'name_admin_bar'        => __( 'Recipe', 'recipe-manager-plugin' ),
            'archives'              => __( 'Recipe Archives', 'recipe-manager-plugin' ),
            'attributes'            => __( 'Recipe Attributes', 'recipe-manager-plugin' ),
            'parent_item_colon'     => __( 'Parent Recipe:', 'recipe-manager-plugin' ),
            'all_items'             => __( 'All Recipes', 'recipe-manager-plugin' ),
            'add_new_item'          => __( 'Add New Recipe', 'recipe-manager-plugin' ),
            'add_new'               => __( 'Add New', 'recipe-manager-plugin' ),
            'new_item'              => __( 'New Recipe', 'recipe-manager-plugin' ),
            'edit_item'             => __( 'Edit Recipe', 'recipe-manager-plugin' ),
            'update_item'           => __( 'Update Recipe', 'recipe-manager-plugin' ),
            'view_item'             => __( 'View Recipe', 'recipe-manager-plugin' ),
            'view_items'            => __( 'View Recipes', 'recipe-manager-plugin' ),
            'search_items'          => __( 'Search Recipe', 'recipe-manager-plugin' ),
            'not_found'             => __( 'No recipes found', 'recipe-manager-plugin' ),
            'not_found_in_trash'    => __( 'No recipes found in Trash', 'recipe-manager-plugin' ),
            'featured_image'        => __( 'Recipe Image', 'recipe-manager-plugin' ),
            'set_featured_image'    => __( 'Set recipe image', 'recipe-manager-plugin' ),
            'remove_featured_image' => __( 'Remove recipe image', 'recipe-manager-plugin' ),
            'use_featured_image'    => __( 'Use as recipe image', 'recipe-manager-plugin' ),
            'insert_into_item'      => __( 'Insert into recipe', 'recipe-manager-plugin' ),
            'uploaded_to_this_item' => __( 'Uploaded to this recipe', 'recipe-manager-plugin' ),
            'items_list'            => __( 'Recipes list', 'recipe-manager-plugin' ),
            'items_list_navigation' => __( 'Recipes list navigation', 'recipe-manager-plugin' ),
            'filter_items_list'     => __( 'Filter recipes list', 'recipe-manager-plugin' ),
        );
        $args = array(
            'label'                 => __( 'Recipe', 'recipe-manager-plugin' ),
            'description'           => __( 'Manage your recipes for your website.', 'recipe-manager-plugin' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'author', 'comments' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5, // Position in the admin menu
            'menu_icon'             => 'dashicons-food', // A nice food icon
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => array( 'slug' => 'recipes', 'with_front' => false ), // Custom URL slug
            'capability_type'       => 'post',
            'show_in_rest'          => true, // Enable for Gutenberg editor and REST API
        );
        register_post_type( 'recipe', $args );
    }
}