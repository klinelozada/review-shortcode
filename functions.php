<?php
/**
 * Dame Digital Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dame Digital
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_DAME_DIGITAL_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'dame-digital-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_DAME_DIGITAL_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function enqueue_custom_scripts() {
    // Enqueue jQuery from Google CDN
    wp_enqueue_script('rp-jq', 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js', array(), '2.0.0', true);

    // Enqueue star-rating-svg script from jsDelivr CDN
    wp_enqueue_script('star-rating-svg', 'https://cdn.jsdelivr.net/npm/star-rating-svg@3.5.0/dist/jquery.star-rating-svg.min.js', array('jquery'), '3.5.0', true);

    // Enqueue RP App
    wp_enqueue_script('rp-app', get_stylesheet_directory_uri() . '/js/rp.app.js', array(), '1.0.0', true);

}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function rp_author_review_sc($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'avatar' => 'https://pillowspecialist.com/img/profile.webp',
            'author' => 'John Doe',
            'position' => 'Obsessive Tester. Avid Dreamer',
        ),
        $atts,
        'rp_author_review'
    );

    $avatar = $atts['avatar'];
    $author = $atts['author'];
    $position = $atts['position'];

    $html = '
        <div class="review-author-container">
            <div class="ra-bio">
                <div class="ra-avatar">
                    <img src="' . esc_url($avatar) . '" alt="' . esc_attr($author) . ' Avatar">
                </div>
                <div class="ra-info">
                    <div class="ra-name">' . esc_html($author) . '</div>
                    <div class="ra-tag">' . esc_html($position) . '</div>
                </div>
            </div>
            <div class="ra-description">' . do_shortcode($content) . '</div>
        </div>
    ';

    return $html;
}
add_shortcode('rp_author_review', 'rp_author_review_sc');


// Define [pros] shortcode
function rp_excerpt_shortcode($atts, $content = null) {
    return '<div class="rp-excerpt">' . $content . '</div>';
}
add_shortcode('rp_excerpt', 'rp_excerpt_shortcode');

function rp_pros_shortcode($atts, $content = null) {
    return '<ul class="rp-pros"><li>' . str_replace(', ', '</li><li>', $content) . '</li></ul>';
}
add_shortcode('rp_pros', 'rp_pros_shortcode');

// Define [cons] shortcode
function rp_cons_shortcode($atts, $content = null) {
    return '<ul class="rp-cons"><li>' . str_replace(', ', '</li><li>', $content) . '</li></ul>';
}
add_shortcode('rp_cons', 'rp_cons_shortcode');

function rp_item_review_sc($atts, $content = null) {
    
    $atts = shortcode_atts(
        array(
            'item_win_tag' => 'Best Memory Foam Pillow, Best Pillow for Side-Sleepers',
            'item_image' => 'https://pillowspecialist.com/img/saybrook-pillow.webp',
            'item_image_link' => 'Saybrook, https://example.com/',
            'item_score' => '9.8',
            'item_score_link' => 'https://example.com/',
            'item_specs_firmness' => 'Medium',
            'Item_specs_loft' => 'Adjustable',
            'item_specs_positions' => 'Side, Stomach, Back',
            'item_specs_body_type' => 'Petite, Average, Big-and-tall',
            'item_specs_filling_score' => '5',
            'item_specs_quality_score' => '5'
        ),
        $atts,
        'rp_item_review'
    );
    
    $item_win_tag = explode(', ', $atts['item_win_tag']);
    $item_image = $atts['item_image'];
    $item_image_link = explode(', ', $atts['item_image_link']);
    $item_score = $atts['item_score'];
    $item_score_link = $atts['item_score_link'];
    $item_specs_firmness = $atts['item_specs_firmness'];
    $Item_specs_loft = $atts['Item_specs_loft'];
    $item_specs_positions = $atts['item_specs_positions'];
    $item_specs_body_type = $atts['item_specs_body_type'];
    $item_specs_filling_score = $atts['item_specs_filling_score'];
    $item_specs_quality_score = $atts['item_specs_quality_score'];

    // Item Review Container
    $html = '<div class="review-product-container">';

    // Header

    $html .= '<div class="rp-header">
    
        <div class="rp-winner">
            <strong>Winner: #<span class="win-no"></span></strong> out of <span class="total-no"></span>
        </div>

        <div class="rp-tags">';

        foreach ($item_win_tag as $tag) {
            $html .= '<div class="rp-tag">' . esc_html($tag) . '</div>';
        }

    $html .= '</div></div>';

    // Item Review
    $html .= '
        <div class="rp-product-info">
            
            <div class="rp-image">
                <img src="' . esc_url($item_image) . '">
                <a href="' . esc_url($item_image_link[1]) . '" class="rp-image-link">' . esc_html($item_image_link[0]) . '</a>
            </div>
            
            <div class="rp-description">
            '.do_shortcode($content).'
            </div>
            
            <div class="rp-rating">
                
                <div class="rp-score score-98">
                    <div class="score">' . esc_html($item_score) . '</div>
                </div>
            
                <a href="' . esc_url($item_score_link) . '" class="rp-rating-link">Check Price</a>

            </div>
        
        </div>';

    // Specs Rating
    $html .= '
        <div class="rp-specs">

            <div class="rp-col">
                        
                <div class="rp-spec">
                    <div class="spec-name">Firmness / Softness:</div>
                    <div class="spec-content">' . esc_html($item_specs_firmness) . '</div>
                </div>
                <div class="rp-spec">
                    <div class="spec-name">Starting Loft:</div>
                    <div class="spec-content">' . esc_html($Item_specs_loft) . '</div>
                </div>
                <div class="rp-spec">
                    <div class="spec-name">Sleep Positions:</div>
                    <div class="spec-content">' . esc_html($item_specs_positions) . '</div>
                </div>
                <div class="rp-spec">
                    <div class="spec-name">Body Types:</div>
                    <div class="spec-content">' . esc_html($item_specs_body_type) . '</div>
                </div>
                
            </div>
            
            <div class="rp-col">
                
                <div class="rp-spec">
                    <div class="spec-name">Filling Comfort:</div>
                    <div class="spec-content">
                        <div class="rp-star-rating" data-rating-score="' . esc_attr($item_specs_filling_score) . '"></div>
                    </div>
                </div>

                <div class="rp-spec">
                    <div class="spec-name">Construction Quality:</div>
                    <div class="spec-content">
                        <div class="rp-star-rating" data-rating-score="' . esc_attr($item_specs_quality_score) . '"></div>
                    </div>
                </div>
                
            </div>

        </div>
    ';

    $html .= '</div>';

    return $html;
    
}

add_shortcode( 'rp_item_review', 'rp_item_review_sc' );