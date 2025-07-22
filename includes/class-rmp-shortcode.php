<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handles the [recipes] shortcode.
 */
class RMP_Shortcode {

    /**
     * Constructor.
     */
    public function __construct() {
        add_shortcode( 'recipes', array( $this, 'render_recipes_shortcode' ) );
    }

    /**
     * Renders the [recipes] shortcode.
     *
     * @param array $atts Shortcode attributes.
     * @return string HTML output.
     */
    public function render_recipes_shortcode( $atts ) {
        // Parse shortcode attributes and set defaults
        $atts = shortcode_atts(
            array(
                'limit'    => -1, // -1 for all, any number for specific count
                'category' => '', // Filter by category slug
                'id'       => '', // Display a single recipe by ID
            ),
            $atts,
            'recipes'
        );

        ob_start(); // Start output buffering

        // Display single recipe by ID
        if ( ! empty( $atts['id'] ) ) {
            $this->display_single_recipe( intval( $atts['id'] ) );
        } else {
            // Query arguments for recipes
            $args = array(
                'post_type'      => 'recipe',
                'posts_per_page' => intval( $atts['limit'] ),
                'post_status'    => 'publish',
            );

            // Filter by category if specified
            if ( ! empty( $atts['category'] ) ) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'category', // Using default WP categories
                        'field'    => 'slug',
                        'terms'    => sanitize_title( $atts['category'] ), // Sanitize category slug
                    ),
                );
            }

            $recipes_query = new WP_Query( $args );

            if ( $recipes_query->have_posts() ) {
                echo '<div class="rmp-recipe-list">';
                while ( $recipes_query->have_posts() ) {
                    $recipes_query->the_post();
                    $this->display_recipe_card( get_the_ID() );
                }
                echo '</div>'; // .rmp-recipe-list
                wp_reset_postdata(); // Restore original post data
            } else {
                echo '<p>' . esc_html__( 'No recipes found.', 'recipe-manager-plugin' ) . '</p>';
            }
        }

        return ob_get_clean(); // Return buffered content
    }

    /**
     * Displays a single recipe card.
     *
     * @param int $post_id The ID of the recipe post.
     */
    private function display_recipe_card( $post_id ) {
        $ingredients      = get_post_meta( $post_id, '_rmp_ingredients', true );
        $prep_time        = get_post_meta( $post_id, '_rmp_prep_time', true );
        $cook_time        = get_post_meta( $post_id, '_rmp_cook_time', true );
        $serving_size     = get_post_meta( $post_id, '_rmp_serving_size', true );
        $difficulty       = get_post_meta( $post_id, '_rmp_difficulty', true );
        $video_url        = get_post_meta( $post_id, '_rmp_video_url', true );

        ?>
        <div class="rmp-recipe-card">
            <h3><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></h3>

            <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                <div class="rmp-recipe-thumbnail">
                    <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
                        <?php echo get_the_post_thumbnail( $post_id, 'medium' ); ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="rmp-recipe-meta">
                <?php if ( ! empty( $prep_time ) ) : ?>
                    <span class="rmp-meta-item"><span class="dashicons dashicons-clock"></span> <?php echo esc_html( $prep_time ); ?> Prep</span>
                <?php endif; ?>
                <?php if ( ! empty( $cook_time ) ) : ?>
                    <span class="rmp-meta-item"><span class="dashicons dashicons-hourglass"></span> <?php echo esc_html( $cook_time ); ?> Cook</span>
                <?php endif; ?>
                <?php if ( ! empty( $serving_size ) ) : ?>
                    <span class="rmp-meta-item"><span class="dashicons dashicons-groups"></span> <?php echo esc_html( $serving_size ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $difficulty ) ) : ?>
                    <span class="rmp-meta-item rmp-difficulty-<?php echo esc_attr( $difficulty ); ?>"><span class="dashicons dashicons-star-filled"></span> <?php echo esc_html( ucfirst( $difficulty ) ); ?></span>
                <?php endif; ?>
            </div>

            <div class="rmp-recipe-excerpt">
                <?php echo wp_kses_post( get_the_excerpt( $post_id ) ); ?>
            </div>
            <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="rmp-read-more-button"><?php _e( 'View Recipe', 'recipe-manager-plugin' ); ?></a>
        </div>
        <?php
    }

    /**
     * Displays a single full recipe.
     * This is typically for single recipe pages, but can be used via shortcode too.
     *
     * @param int $post_id The ID of the recipe post.
     */
    private function display_single_recipe( $post_id ) {
        // Ensure it's a valid recipe post ID.
        if ( get_post_type( $post_id ) !== 'recipe' ) {
            echo '<p>' . esc_html__( 'Invalid recipe ID.', 'recipe-manager-plugin' ) . '</p>';
            return;
        }

        $ingredients      = get_post_meta( $post_id, '_rmp_ingredients', true );
        $prep_time        = get_post_meta( $post_id, '_rmp_prep_time', true );
        $cook_time        = get_post_meta( $post_id, '_rmp_cook_time', true );
        $serving_size     = get_post_meta( $post_id, '_rmp_serving_size', true );
        $difficulty       = get_post_meta( $post_id, '_rmp_difficulty', true );
        $video_url        = get_post_meta( $post_id, '_rmp_video_url', true );

        ?>
        <div class="rmp-single-recipe">
            <h1><?php echo esc_html( get_the_title( $post_id ) ); ?></h1>

            <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                <div class="rmp-single-thumbnail">
                    <?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
                </div>
            <?php endif; ?>

            <div class="rmp-recipe-meta-full">
                <?php if ( ! empty( $prep_time ) ) : ?>
                    <p><strong><?php _e( 'Prep Time:', 'recipe-manager-plugin' ); ?></strong> <?php echo esc_html( $prep_time ); ?></p>
                <?php endif; ?>
                <?php if ( ! empty( $cook_time ) ) : ?>
                    <p><strong><?php _e( 'Cook Time:', 'recipe-manager-plugin' ); ?></strong> <?php echo esc_html( $cook_time ); ?></p>
                <?php endif; ?>
                <?php if ( ! empty( $serving_size ) ) : ?>
                    <p><strong><?php _e( 'Servings:', 'recipe-manager-plugin' ); ?></strong> <?php echo esc_html( $serving_size ); ?></p>
                <?php endif; ?>
                <?php if ( ! empty( $difficulty ) ) : ?>
                    <p><strong><?php _e( 'Difficulty:', 'recipe-manager-plugin' ); ?></strong> <span class="rmp-difficulty-<?php echo esc_attr( $difficulty ); ?>"><?php echo esc_html( ucfirst( $difficulty ) ); ?></span></p>
                <?php endif; ?>
            </div>

            <?php if ( ! empty( $ingredients ) ) : ?>
                <div class="rmp-ingredients">
                    <h2><?php _e( 'Ingredients', 'recipe-manager-plugin' ); ?></h2>
                    <ul>
                        <?php
                        $ingredient_lines = explode( "\n", $ingredients );
                        foreach ( $ingredient_lines as $line ) {
                            $line = trim( $line );
                            if ( ! empty( $line ) ) {
                                echo '<li>' . esc_html( $line ) . '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="rmp-instructions">
                <h2><?php _e( 'Instructions', 'recipe-manager-plugin' ); ?></h2>
                <?php
                // Get the main content (instructions)
                $content_post = get_post( $post_id );
                $content = $content_post->post_content;
                echo apply_filters( 'the_content', $content ); // Apply filters for paragraphs, embeds, etc.
                ?>
            </div>

            <?php if ( ! empty( $video_url ) ) : ?>
                <div class="rmp-video">
                    <h2><?php _e( 'Recipe Video', 'recipe-manager-plugin' ); ?></h2>
                    <?php echo wp_oembed_get( $video_url ); // Auto-embed video from URL ?>
                </div>
            <?php endif; ?>

        </div>
        <?php
    }
}