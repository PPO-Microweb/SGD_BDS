<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display carousel blocks
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_carousel_blocks($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'number' => 10,
        'orderby' => 'rand',
        'order' => 'DESC',
    ), $atts);

    $args = array(
        'post_type' => 'block',
        'showposts' => $instance['number'],
        'orderby' => $instance['orderby'],
        'order' => $instance['order'],
    );
    $loop_query = new WP_Query($args);
    
    $html_output = '<div class="carousel-blocks-widget">';
    if (!empty($atts['title'])) {
        $html_output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
    }
    $html_output .= '<div class="owl-carousel">';
    while ($loop_query->have_posts()) : $loop_query->the_post();
        $img = get_template_directory_uri() . '/assets/images/icon-home.png';
        $title = get_the_title();
        $bgcolor = get_post_meta(get_the_ID(), 'bgcolor', true);
        if(!empty($bgcolor)){
            $bgcolor = "style=\"background-color:$bgcolor;\"";
        }
//        $link_bds = get_post_meta(get_the_ID(), 'link_bds', true);
        $link_block = get_post_meta(get_the_ID(), 'link_block', true);
        $html_output .= <<<HTML
        <div class="item" $bgcolor>
            <img src="$img" alt="{$title}" />
            <h3>{$title}</h3>
            <!--<a href="{$link_bds}" class="xem-bds">Xem bất động sản</a> -->
            <a href="{$link_block}" class="xem-block">Xem thêm</a>
        </div>
HTML;
    endwhile;
    wp_reset_query();
    $html_output .= "</div></div>";

    return $html_output;
}

add_shortcode('ppo-carousel-blocks', 'ppo_shortcode_carousel_blocks');
