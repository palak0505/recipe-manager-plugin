<?php
/**
 * Plugin Name: Recipe Manager Plugin
 * Plugin URI:  https://github.com/YourGitHubUsername/recipe-manager-plugin
 * Description: A simple plugin to manage and display recipes.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://yourwebsite.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: recipe-manager-plugin
 * Domain Path: /languages
 */

// Exit if accessed directly (security measure)
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'RMP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RMP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'RMP_VERSION', '1.0.0' );

/**
 * The main plugin class.
 */
class Recipe_Manager_Plugin {

    /**
     * Constructor.
     */
    public function __construct() {
        // Register activation and deactivation hooks
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        // Add actions and filters
        add_action( 'plugins_loaded', array( $this, 'load_textdomain_and_components' ) );
        add_action( 'init', array( $this, 'register_recipe_post_type' ) );
    }

    /**
     * Plugin activation hook.
     */
    public function activate() {
        // During activation, ensure the CPT is registered before flushing rules.
        // The 'init' action won't have fired yet, so we need to call it directly.
        $this->register_recipe_post_type();
        flush_rewrite_rules();
    }

    /**
     * Plugin deactivation hook.
     */
    public function deactivate() {
        // Flush rewrite rules on deactivation to clean up.
        flush_rewrite_rules();
    }

    /**
     * Initialize plugin components that don't need 'init' hook.
     * Renamed from init_plugin for better semantic meaning.
     */
    public function load_textdomain_and_components() {
        // Load text domain for internationalization. This is good to do on 'plugins_loaded'.
        load_plugin_textdomain( 'recipe-manager-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

        // Load other plugin components (classes)
        // These classes should handle their own action/filter hooks within their constructors
        require_once RMP_PLUGIN_DIR . 'includes/class-rmp-recipe-cpt.php';
        require_once RMP_PLUGIN_DIR . 'includes/class-rmp-recipe-metaboxes.php';
        require_once RMP_PLUGIN_DIR . 'includes/class-rmp-shortcode.php';
        require_once RMP_PLUGIN_DIR . 'includes/class-rmp-assets.php';
        require_once RMP_PLUGIN_DIR . 'includes/class-rmp-frontend-submission.php'; // <-- ADD THIS LINE

        // Instantiate components
        // Ensure these classes handle their actions/filters correctly within their own __construct methods
        new RMP_Recipe_CPT();
        new RMP_Recipe_Metaboxes();
        new RMP_Shortcode();
        new RMP_Assets();
        new RMP_Frontend_Submission(); // <-- ADD THIS LINE
    }

    /**
     * Register the Recipe Custom Post Type.
     * This method is now hooked to the 'init' action.
     */
    public function register_recipe_post_type() { // Changed to public as it's directly hooked
        $labels = array(
            'name'               => _x( 'Recipes', 'post type general name', 'recipe-manager-plugin' ),
            'singular_name'      => _x( 'Recipe', 'post type singular name', 'recipe-manager-plugin' ),
            'menu_name'          => _x( 'Recipes', 'admin menu', 'recipe-manager-plugin' ),
            'name_admin_bar'     => _x( 'Recipe', 'add new on admin bar', 'recipe-manager-plugin' ),
            'add_new'            => _x( 'Add New', 'recipe', 'recipe-manager-plugin' ),
            'add_new_item'       => __( 'Add New Recipe', 'recipe-manager-plugin' ),
            'new_item'           => __( 'New Recipe', 'recipe-manager-plugin' ),
            'edit_item'          => __( 'Edit Recipe', 'recipe-manager-plugin' ),
            'view_item'          => __( 'View Recipe', 'recipe-manager-plugin' ),
            'all_items'          => __( 'All Recipes', 'recipe-manager-plugin' ),
            'search_items'       => __( 'Search Recipes', 'recipe-manager-plugin' ),
            'parent_item_colon'  => __( 'Parent Recipes:', 'recipe-manager-plugin' ),
            'not_found'          => __( 'No recipes found.', 'recipe-manager-plugin' ),
            'not_found_in_trash' => __( 'No recipes found in Trash.', 'recipe-manager-plugin' ),
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'recipes' ),
            'capability_type'     => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 5,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'author', 'comments' ),
            'taxonomies'          => array( 'category', 'post_tag' ), // Use default categories/tags
            'show_in_rest'        => true, // Enable for Gutenberg editor and REST API
        );

        register_post_type( 'recipe', $args );
    }
}

// Instantiate the main plugin class
new Recipe_Manager_Plugin();