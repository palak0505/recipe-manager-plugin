<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handles custom meta boxes for the Recipe Custom Post Type.
 */
class RMP_Recipe_Metaboxes {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_recipe_metaboxes' ) );
        add_action( 'save_post', array( $this, 'save_recipe_metabox_data' ) );
    }

    /**
     * Add custom meta boxes for the 'recipe' post type.
     */
    public function add_recipe_metaboxes() {
        add_meta_box(
            'rmp_recipe_details',             // Unique ID
            __( 'Recipe Details', 'recipe-manager-plugin' ), // Box title
            array( $this, 'render_recipe_details_metabox' ), // Callback function to render the box
            'recipe',                         // Post type
            'normal',                         // Context (where on the screen)
            'high'                            // Priority
        );
    }

    /**
     * Render the HTML for the Recipe Details meta box.
     *
     * @param WP_Post $post The current post object.
     */
    public function render_recipe_details_metabox( $post ) {
        // Add a nonce field so we can check for it later.
        wp_nonce_field( 'rmp_save_recipe_details_data', 'rmp_recipe_meta_nonce' );

        // Get existing meta values (if any)
        $ingredients      = get_post_meta( $post->ID, '_rmp_ingredients', true );
        $prep_time        = get_post_meta( $post->ID, '_rmp_prep_time', true );
        $cook_time        = get_post_meta( $post->ID, '_rmp_cook_time', true );
        $serving_size     = get_post_meta( $post->ID, '_rmp_serving_size', true );
        $difficulty       = get_post_meta( $post->ID, '_rmp_difficulty', true );
        $video_url        = get_post_meta( $post->ID, '_rmp_video_url', true );

        ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="rmp_ingredients"><?php _e( 'Ingredients', 'recipe-manager-plugin' ); ?></label></th>
                    <td>
                        <textarea id="rmp_ingredients" name="rmp_ingredients" rows="5" class="large-text code" placeholder="<?php _e( 'List each ingredient on a new line (e.g., 2 cups flour)', 'recipe-manager-plugin' ); ?>"><?php echo esc_textarea( $ingredients ); ?></textarea>
                        <p class="description"><?php _e( 'Enter ingredients, one per line.', 'recipe-manager-plugin' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="rmp_prep_time"><?php _e( 'Preparation Time', 'recipe-manager-plugin' ); ?></label></th>
                    <td>
                        <input type="text" id="rmp_prep_time" name="rmp_prep_time" value="<?php echo esc_attr( $prep_time ); ?>" class="regular-text" placeholder="<?php _e( 'e.g., 30 minutes', 'recipe-manager-plugin' ); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="rmp_cook_time"><?php _e( 'Cook Time', 'recipe-manager-plugin' ); ?></label></th>
                    <td>
                        <input type="text" id="rmp_cook_time" name="rmp_cook_time" value="<?php echo esc_attr( $cook_time ); ?>" class="regular-text" placeholder="<?php _e( 'e.g., 1 hour 15 minutes', 'recipe-manager-plugin' ); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="rmp_serving_size"><?php _e( 'Serving Size', 'recipe-manager-plugin' ); ?></label></th>
                    <td>
                        <input type="text" id="rmp_serving_size" name="rmp_serving_size" value="<?php echo esc_attr( $serving_size ); ?>" class="regular-text" placeholder="<?php _e( 'e.g., 4 servings', 'recipe-manager-plugin' ); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="rmp_difficulty"><?php _e( 'Difficulty', 'recipe-manager-plugin' ); ?></label></th>
                    <td>
                        <select id="rmp_difficulty" name="rmp_difficulty" class="postbox">
                            <option value=""><?php _e( 'Select Difficulty', 'recipe-manager-plugin' ); ?></option>
                            <option value="easy" <?php selected( $difficulty, 'easy' ); ?>><?php _e( 'Easy', 'recipe-manager-plugin' ); ?></option>
                            <option value="medium" <?php selected( $difficulty, 'medium' ); ?>><?php _e( 'Medium', 'recipe-manager-plugin' ); ?></option>
                            <option value="hard" <?php selected( $difficulty, 'hard' ); ?>><?php _e( 'Hard', 'recipe-manager-plugin' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="rmp_video_url"><?php _e( 'Recipe Video URL', 'recipe-manager-plugin' ); ?></label></th>
                    <td>
                        <input type="url" id="rmp_video_url" name="rmp_video_url" value="<?php echo esc_url( $video_url ); ?>" class="large-text" placeholder="<?php _e( 'e.g., https://youtube.com/watch?v=123', 'recipe-manager-plugin' ); ?>">
                        <p class="description"><?php _e( 'Enter a YouTube or Vimeo URL for a recipe video.', 'recipe-manager-plugin' ); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
    }

    /**
     * Save the meta box data when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save_recipe_metabox_data( $post_id ) {
        // Check if our nonce is set.
        if ( ! isset( $_POST['rmp_recipe_meta_nonce'] ) ) {
            return;
        }

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['rmp_recipe_meta_nonce'], 'rmp_save_recipe_details_data' ) ) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Only save data for our 'recipe' post type.
        if ( 'recipe' !== get_post_type( $post_id ) ) {
            return;
        }

        // Sanitize and save the data.

        // Ingredients (textarea)
        if ( isset( $_POST['rmp_ingredients'] ) ) {
            $ingredients = sanitize_textarea_field( $_POST['rmp_ingredients'] );
            update_post_meta( $post_id, '_rmp_ingredients', $ingredients );
        } else {
            delete_post_meta( $post_id, '_rmp_ingredients' );
        }

        // Preparation Time (text input)
        if ( isset( $_POST['rmp_prep_time'] ) ) {
            $prep_time = sanitize_text_field( $_POST['rmp_prep_time'] );
            update_post_meta( $post_id, '_rmp_prep_time', $prep_time );
        } else {
            delete_post_meta( $post_id, '_rmp_prep_time' );
        }

        // Cook Time (text input)
        if ( isset( $_POST['rmp_cook_time'] ) ) {
            $cook_time = sanitize_text_field( $_POST['rmp_cook_time'] );
            update_post_meta( $post_id, '_rmp_cook_time', $cook_time );
        } else {
            delete_post_meta( $post_id, '_rmp_cook_time' );
        }

        // Serving Size (text input)
        if ( isset( $_POST['rmp_serving_size'] ) ) {
            $serving_size = sanitize_text_field( $_POST['rmp_serving_size'] );
            update_post_meta( $post_id, '_rmp_serving_size', $serving_size );
        } else {
            delete_post_meta( $post_id, '_rmp_serving_size' );
        }

        // Difficulty (select)
        if ( isset( $_POST['rmp_difficulty'] ) ) {
            $difficulty = sanitize_text_field( $_POST['rmp_difficulty'] );
            // Validate against allowed options
            $allowed_difficulties = array( 'easy', 'medium', 'hard' );
            if ( in_array( $difficulty, $allowed_difficulties, true ) ) {
                update_post_meta( $post_id, '_rmp_difficulty', $difficulty );
            } else {
                delete_post_meta( $post_id, '_rmp_difficulty' ); // Or set a default
            }
        } else {
            delete_post_meta( $post_id, '_rmp_difficulty' );
        }

        // Video URL (URL input)
        if ( isset( $_POST['rmp_video_url'] ) ) {
            $video_url = esc_url_raw( $_POST['rmp_video_url'] ); // Sanitize URL
            update_post_meta( $post_id, '_rmp_video_url', $video_url );
        } else {
            delete_post_meta( $post_id, '_rmp_video_url' );
        }
    }
}