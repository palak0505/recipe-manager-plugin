<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handles frontend recipe submission functionality.
 */
class RMP_Frontend_Submission {

    /**
     * Constructor.
     */
    public function __construct() {
        // Register the shortcode to display the form
        add_shortcode( 'recipe_submit_form', array( $this, 'render_submission_form' ) );

        // Hook for processing the form submission
        // We use 'template_redirect' because it runs early enough before output,
        // but after WordPress has determined which template to load.
        add_action( 'template_redirect', array( $this, 'process_recipe_submission' ) );

        // Add admin notice if submission fails or succeeds
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    /**
     * Enqueue necessary scripts/styles if needed (for later, e.g., form validation)
     */
    public function enqueue_assets() {
        // You might add specific CSS or JS for your form here if needed.
        // For now, it's just a placeholder.
        // wp_enqueue_style( 'rmp-frontend-form-style', RMP_PLUGIN_URL . 'assets/css/frontend-form.css' );
        // wp_enqueue_script( 'rmp-frontend-form-script', RMP_PLUGIN_URL . 'assets/js/frontend-form.js', array( 'jquery' ), RMP_VERSION, true );
    }


    /**
     * Renders the frontend recipe submission form.
     *
     * @param array $atts Shortcode attributes (not used in this basic example)
     * @return string The HTML content of the form.
     */
    public function render_submission_form( $atts ) {
        // Check if the user is logged in
        if ( ! is_user_logged_in() ) {
            return '<p>' . __( 'You must be logged in to submit a recipe.', 'recipe-manager-plugin' ) . '</p>';
        }

        ob_start(); // Start output buffering

        // Display messages if any (e.g., from redirect after submission)
        if ( isset( $_GET['submission_status'] ) ) {
            if ( 'success' === $_GET['submission_status'] ) {
                echo '<div class="rmp-success-message" style="background-color: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6; padding: 10px; margin-bottom: 15px;">' . __( 'Recipe submitted successfully! It is awaiting review.', 'recipe-manager-plugin' ) . '</div>';
            } elseif ( 'error' === $_GET['submission_status'] && isset( $_GET['message'] ) ) {
                echo '<div class="rmp-error-message" style="background-color: #f2dede; color: #a94442; border: 1px solid #ebccd1; padding: 10px; margin-bottom: 15px;">' . esc_html( $_GET['message'] ) . '</div>';
            }
        }

        ?>
        <div class="rmp-frontend-form-wrapper">
            <h2><?php _e( 'Submit Your Recipe', 'recipe-manager-plugin' ); ?></h2>
            <form action="" method="post" enctype="multipart/form-data" class="rmp-recipe-form">
                <?php wp_nonce_field( 'rmp_submit_recipe_nonce', 'rmp_submit_nonce' ); ?>

                <p>
                    <label for="recipe_title"><?php _e( 'Recipe Title *', 'recipe-manager-plugin' ); ?></label><br>
                    <input type="text" id="recipe_title" name="recipe_title" required class="large-text" value="<?php echo isset( $_POST['recipe_title'] ) ? esc_attr( $_POST['recipe_title'] ) : ''; ?>">
                </p>

                <p>
                    <label for="recipe_content"><?php _e( 'Recipe Instructions / Description *', 'recipe-manager-plugin' ); ?></label><br>
                    <textarea id="recipe_content" name="recipe_content" rows="10" required class="large-text"><?php echo isset( $_POST['recipe_content'] ) ? esc_textarea( $_POST['recipe_content'] ) : ''; ?></textarea>
                </p>

                <p>
                    <label for="rmp_ingredients"><?php _e( 'Ingredients (one per line) *', 'recipe-manager-plugin' ); ?></label><br>
                    <textarea id="rmp_ingredients" name="rmp_ingredients" rows="5" required class="large-text"><?php echo isset( $_POST['rmp_ingredients'] ) ? esc_textarea( $_POST['rmp_ingredients'] ) : ''; ?></textarea>
                </p>

                <p>
                    <label for="rmp_prep_time"><?php _e( 'Preparation Time', 'recipe-manager-plugin' ); ?></label><br>
                    <input type="text" id="rmp_prep_time" name="rmp_prep_time" class="regular-text" value="<?php echo isset( $_POST['rmp_prep_time'] ) ? esc_attr( $_POST['rmp_prep_time'] ) : ''; ?>">
                </p>

                <p>
                    <label for="rmp_cook_time"><?php _e( 'Cook Time', 'recipe-manager-plugin' ); ?></label><br>
                    <input type="text" id="rmp_cook_time" name="rmp_cook_time" class="regular-text" value="<?php echo isset( $_POST['rmp_cook_time'] ) ? esc_attr( $_POST['rmp_cook_time'] ) : ''; ?>">
                </p>

                <p>
                    <label for="rmp_serving_size"><?php _e( 'Serving Size', 'recipe-manager-plugin' ); ?></label><br>
                    <input type="text" id="rmp_serving_size" name="rmp_serving_size" class="regular-text" value="<?php echo isset( $_POST['rmp_serving_size'] ) ? esc_attr( $_POST['rmp_serving_size'] ) : ''; ?>">
                </p>

                <p>
                    <label for="rmp_difficulty"><?php _e( 'Difficulty', 'recipe-manager-plugin' ); ?></label><br>
                    <select id="rmp_difficulty" name="rmp_difficulty" class="postbox">
                        <option value=""><?php _e( 'Select Difficulty', 'recipe-manager-plugin' ); ?></option>
                        <option value="easy" <?php selected( isset( $_POST['rmp_difficulty'] ) ? $_POST['rmp_difficulty'] : '', 'easy' ); ?>><?php _e( 'Easy', 'recipe-manager-plugin' ); ?></option>
                        <option value="medium" <?php selected( isset( $_POST['rmp_difficulty'] ) ? $_POST['rmp_difficulty'] : '', 'medium' ); ?>><?php _e( 'Medium', 'recipe-manager-plugin' ); ?></option>
                        <option value="hard" <?php selected( isset( $_POST['rmp_difficulty'] ) ? $_POST['rmp_difficulty'] : '', 'hard' ); ?>><?php _e( 'Hard', 'recipe-manager-plugin' ); ?></option>
                    </select>
                </p>

                <p>
                    <label for="rmp_video_url"><?php _e( 'Recipe Video URL', 'recipe-manager-plugin' ); ?></label><br>
                    <input type="url" id="rmp_video_url" name="rmp_video_url" class="large-text" placeholder="e.g., https://www.youtube.com/watch?v=dQw4w9WgXcQ" value="<?php echo isset( $_POST['rmp_video_url'] ) ? esc_url( $_POST['rmp_video_url'] ) : ''; ?>">
                    <p class="description"><?php _e( 'Enter a YouTube or Vimeo URL for a recipe video.', 'recipe-manager-plugin' ); ?></p>
                </p>

                <p>
                    <label for="featured_image"><?php _e( 'Featured Image', 'recipe-manager-plugin' ); ?></label><br>
                    <input type="file" id="featured_image" name="featured_image" accept="image/*">
                    <p class="description"><?php _e( 'Upload a featured image for your recipe.', 'recipe-manager-plugin' ); ?></p>
                </p>

                <p>
                    <input type="submit" name="rmp_submit_recipe" value="<?php _e( 'Submit Recipe', 'recipe-manager-plugin' ); ?>" class="button button-primary">
                </p>
            </form>
        </div>
        <?php
        return ob_get_clean(); // Return the buffered content
    }

    /**
     * Processes the frontend recipe submission form data.
     */
    public function process_recipe_submission() {
        // Only process if our form has been submitted and nonce is valid
        if ( ! isset( $_POST['rmp_submit_recipe'] ) || ! isset( $_POST['rmp_submit_nonce'] ) || ! wp_verify_nonce( $_POST['rmp_submit_nonce'], 'rmp_submit_recipe_nonce' ) ) {
            return; // Not our form, or invalid nonce
        }

        // Check if the user is logged in
        if ( ! is_user_logged_in() ) {
            $this->redirect_with_message( 'error', __( 'You must be logged in to submit a recipe.', 'recipe-manager-plugin' ) );
            return;
        }

        // Sanitize and validate basic post data
        $recipe_title   = sanitize_text_field( $_POST['recipe_title'] ?? '' );
        $recipe_content = sanitize_textarea_field( $_POST['recipe_content'] ?? '' );

        // Validation for required fields
        if ( empty( $recipe_title ) ) {
            $this->redirect_with_message( 'error', __( 'Recipe Title is required.', 'recipe-manager-plugin' ) );
            return;
        }
        if ( empty( $recipe_content ) ) {
            $this->redirect_with_message( 'error', __( 'Recipe Instructions / Description is required.', 'recipe-manager-plugin' ) );
            return;
        }

        // Prepare post array for wp_insert_post
        $new_recipe_post = array(
            'post_title'    => $recipe_title,
            'post_content'  => $recipe_content,
            'post_type'     => 'recipe', // Your custom post type
            'post_status'   => 'pending', // Set to 'pending' for admin review
            'post_author'   => get_current_user_id(),
        );

        // Insert the post
        $post_id = wp_insert_post( $new_recipe_post );

        if ( is_wp_error( $post_id ) ) {
            $this->redirect_with_message( 'error', __( 'Error submitting recipe: ', 'recipe-manager-plugin' ) . $post_id->get_error_message() );
            return;
        }

        // --- Save Custom Meta Fields ---
        // Sanitize and save data for each custom field
        $custom_fields = array(
            '_rmp_ingredients'   => sanitize_textarea_field( $_POST['rmp_ingredients'] ?? '' ),
            '_rmp_prep_time'     => sanitize_text_field( $_POST['rmp_prep_time'] ?? '' ),
            '_rmp_cook_time'     => sanitize_text_field( $_POST['rmp_cook_time'] ?? '' ),
            '_rmp_serving_size'  => sanitize_text_field( $_POST['rmp_serving_size'] ?? '' ),
            '_rmp_difficulty'    => sanitize_text_field( $_POST['rmp_difficulty'] ?? '' ), // Will be validated further
            '_rmp_video_url'     => esc_url_raw( $_POST['rmp_video_url'] ?? '' ),
        );

        // Validate difficulty specifically
        $allowed_difficulties = array( 'easy', 'medium', 'hard' );
        if ( ! in_array( $custom_fields['_rmp_difficulty'], $allowed_difficulties, true ) ) {
            $custom_fields['_rmp_difficulty'] = ''; // Clear if invalid
        }

        foreach ( $custom_fields as $meta_key => $meta_value ) {
            if ( ! empty( $meta_value ) ) {
                update_post_meta( $post_id, $meta_key, $meta_value );
            } else {
                delete_post_meta( $post_id, $meta_key );
            }
        }

        // --- Handle Featured Image Upload ---
        if ( ! empty( $_FILES['featured_image']['name'] ) ) {
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );

            $attachment_id = media_handle_upload( 'featured_image', $post_id );

            if ( is_wp_error( $attachment_id ) ) {
                // Handle image upload error, but don't stop the recipe submission
                error_log( 'RMP: Featured image upload failed for post ' . $post_id . ': ' . $attachment_id->get_error_message() );
            } else {
                set_post_thumbnail( $post_id, $attachment_id );
            }
        }

        // Redirect on success
        $this->redirect_with_message( 'success' );
    }

    /**
     * Helper function to redirect with a message.
     *
     * @param string $status 'success' or 'error'.
     * @param string $message The message to display.
     */
    private function redirect_with_message( $status, $message = '' ) {
        $redirect_url = remove_query_arg( array( 'submission_status', 'message' ) ); // Clean previous params
        $redirect_url = add_query_arg( 'submission_status', $status, $redirect_url );
        if ( ! empty( $message ) ) {
            $redirect_url = add_query_arg( 'message', urlencode( $message ), $redirect_url );
        }
        wp_safe_redirect( $redirect_url );
        exit;
    }

} // End of class RMP_Frontend_Submission