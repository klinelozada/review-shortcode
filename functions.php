<?php
/**
 * Enqueue styles
 */
function child_enqueue_styles() {

    wp_enqueue_style('review-shortcode-css', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

// Enqueue Script
function enqueue_custom_scripts() {
    // Enqueue jQuery from Google CDN
    wp_enqueue_script('rp-jq', 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js', array(), '2.0.0', true);

    // Enqueue star-rating-svg script from jsDelivr CDN
    wp_enqueue_script('star-rating-svg', 'https://cdn.jsdelivr.net/npm/star-rating-svg@3.5.0/dist/jquery.star-rating-svg.min.js', array('jquery'), '3.5.0', true);

    // Enqueue Total Rating
    wp_enqueue_script('rp-circle-progress-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.1.3/circle-progress.min.js', array('jquery'), '1.1.3', true);

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
            'item_specs_loft' => 'Adjustable',
            'item_specs_positions' => 'Side, Stomach, Back',
            'item_specs_body_type' => 'Petite, Average, Big-and-tall',
            'item_specs_filling_score' => '5',
            'item_specs_quality_score' => '5',
            'item_style_border_color' => 'E6C300',
            'item_style_button_color' => 'EB5020'
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
    $Item_specs_loft = $atts['item_specs_loft'];
    $item_specs_positions = $atts['item_specs_positions'];
    $item_specs_body_type = $atts['item_specs_body_type'];
    $item_specs_filling_score = $atts['item_specs_filling_score'];
    $item_specs_quality_score = $atts['item_specs_quality_score'];
    $item_style_border_color = $atts['item_style_border_color'];
    $item_style_button_color = $atts['item_style_button_color'];
    
    // Item Review Container
    $html = '<div class="review-product-container" style="border:solid 3px #' . esc_html($item_style_border_color) . ';" data-rating="' . esc_html($item_score) . '">';

    // Header

    $html .= '<div class="rp-header">
        <style></style>
        <div class="rp-winner" style="background">
            <strong>Winner: #<span class="win-no"></span></strong> out of <span class="total-no"></span>
        </div>

        <div class="rp-tags">';

        foreach ($item_win_tag as $tag) {
            $html .= '<div class="rp-tag">' . esc_html($tag) . '</div>';
        }

    $html .= '</div></div>';

    // Item Review
    $item_score_rate = ($item_score * 10) - 18;
    $html .= '
        <div class="rp-product-info">
            
            <div class="rp-image">
                <img src="' . esc_url($item_image) . '">
                <a href="' . esc_url($item_image_link[1]) . '" class="rp-image-link">' . esc_html($item_image_link[0]) . '</a>
                <a href="' . esc_url($item_score_link) . '" class="rp-rating-link mobile-only" style="background:#'.esc_html($item_style_button_color).'">Check Price</a>
            </div>
            
            <div class="rp-description">
            '.do_shortcode($content).'
            </div>
            
            <div class="rp-rating">
                
                <div class="rp-score score-98">
                    <div class="score">' . esc_html($item_score) . '</div>
                </div>
            
                <a href="' . esc_url($item_score_link) . '" class="rp-rating-link" style="background:#'.esc_html($item_style_button_color).'">Check Price</a>

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


// ========================================================================================================


function rp__review_sc($atts, $content = null) {

    static $count = 0; // Initialize and increment the count

    $count++; // Increment the count for each instance

    $atts = shortcode_atts(
        array(
            'item_label' => 'Our Pick',
            'item_title' => 'Nest Bedding Easy Breather Pillow',
            'item_tags' => 'A high-quality layered-foam pillow',
            'item_button_1' => '$179 from Tempur-Pedic, queen size, https://www.nytimes.com/wirecutter/out/link/32745/154073/4/109235?merchant=Tempur-Pedic',
            'item_button_2' => '',
            'item_image' => 'https://d1b5h9psu9yexj.cloudfront.net/32745/Tempur-Pedic-Tempur-Adapt-Pro---Cooling-Pillow--mid-density-_20190603-155806_full.jpeg',
            'item_link' => 'https://www.nytimes.com/wirecutter/out/link/32745/154073/4/109235?merchant=Tempur-Pedic',
        ),
        $atts,
        'rp__review_sc'
    );

    $item_label = $atts['item_label'];
    $item_title = $atts['item_title'];
    $item_tags = explode(', ', $atts['item_tags']);
    $item_button_1 = explode(', ', $atts['item_button_1']);
    $item_button_2 = explode(', ', $atts['item_button_2']);
    $item_image = $atts['item_image'];
    $item_link = $atts['item_link'];

    // Item Review Container with data-count attribute
    $html = '<div class="review-card-container" data-count="' . $count . '">';

    // Header
    $html .= '<div class="review-header">';
    $html .= '<div class="review-winner"><strong>' . esc_html($item_label) . '</strong></div>';
    $html .= '</div>';

    // Item Review
    $html .= '<div class="review-info">';
    $html .= '<div class="review-col review-image">';
    $html .= '<a href="' . esc_url($item_link) . '"><img src="' . esc_url($item_image) . '"></a>';
    $html .= '</div>';

    $html .= '<div class="review-col review-description">';
    $html .= '<div class="review-title"><a href="' . esc_url($item_link) . '">' . esc_html($item_title) . '</a></div>';
    $html .= '<div class="review-tags">';

    foreach ($item_tags as $tag) {
        $html .= '<span class="tag">' . esc_html($tag) . '</span>, ';
    }

    $html .= '</div>';

        $html .= do_shortcode($content);

        $html .= '<div class="review-links">';

        // Check if item_button_1 exists
        if (!empty($item_button_1[0])) {
            $html .= '<a href="' . esc_url($item_button_1[2]) . '" class="review-link">' . esc_html($item_button_1[0]) . '<br/>(' . esc_html($item_button_1[1]) . ')</a>';
        }

        // Check if item_button_2 exists
        if (!empty($item_button_2[0])) {
            $html .= '<a href="' . esc_url($item_button_2[1]) . '" class="review-link">' . esc_html($item_button_2[0]) . '</a>';
        }

        $html .= '</div>';

    $html .= '</div>';

    $html .= '</div>';

    $html .= '</div>';

    return $html;

}

add_shortcode( 'rp__review', 'rp__review_sc' );
