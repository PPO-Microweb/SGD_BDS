<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display Video player
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_video_player($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'video_link' => '',
        'image' => '',
        'image_size' => 'large', 
    ), $atts);

    $img = wp_get_attachment_image_src($instance["image"], "large");
    $html_output = <<<HTML
    <div class="video-player-widget">
        <a class="thumbnail" href="{$instance['video_link']}" data-fancybox="gallery">
            <img src="{$img[0]}" alt="{$instance['title']}" />
            <span class="play_video"></span>
        </a>
    </div>
HTML;

    return $html_output;
}

add_shortcode('ppo-video-player', 'ppo_shortcode_video_player');


