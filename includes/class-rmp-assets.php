<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handles enqueueing of CSS and JavaScript assets.
 */
class RMP_Assets {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
    }

    /**
     * Enqueue scripts and styles for the frontend.
     */
    public function enqueue_frontend_scripts() {
        // Enqueue main plugin CSS
        wp_enqueue_style(
            'rmp-frontend-style',
            RMP_PLUGIN_URL . 'assets/css/frontend-style.css',
            array(),
            RMP_VERSION
        );

        // Enqueue main plugin JavaScript (if needed for frontend interactions)
        // For a simple display, JS might not be strictly necessary, but good practice.
        wp_enqueue_script(
            'rmp-frontend-script',
            RMP_PLUGIN_URL . 'assets/js/frontend-script.js',
            array( 'jquery' ), // Dependency on jQuery
            RMP_VERSION,
            true // Load in footer
        );

        // Example: Localize script if you need to pass PHP variables to JS
        // wp_localize_script(
        //     'rmp-frontend-script',
        //     'rmp_vars',
        //     array(
        //         'ajax_url' => admin_url( 'admin-ajax.php' ),
        //         'nonce'    => wp_create_nonce( 'rmp_ajax_nonce' ),
        //     )
        // );
    }

    /**
     * Enqueue scripts and styles for the admin area.
     *
     * @param string $hook The current admin page hook.
     */
    public function enqueue_admin_scripts( $hook ) {
        // Only load on recipe edit/new screens
        if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
            return;
        }

        // Check if we are editing or creating a 'recipe' post type
        $screen = get_current_screen();
        if ( is_object( $screen ) && 'recipe' !== $screen->post_type ) {
            return;
        }

        // Enqueue admin CSS for custom metabox styling (optional)
        wp_enqueue_style(
            'rmp-admin-style',
            RMP_PLUGIN_URL . 'assets/css/admin-style.css',
            array(),
            RMP_VERSION
        );

        // Enqueue admin JavaScript (e.g., for custom meta box interactions)
        wp_enqueue_script(
            'rmp-admin-script',
            RMP_PLUGIN_URL . 'assets/js/admin-script.js',
            array( 'jquery' ), // Dependency on jQuery
            RMP_VERSION,
            true // Load in footer
        );
    }
}