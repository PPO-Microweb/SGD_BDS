<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display Link Item
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_link_item($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'url' => '',
    ), $atts);

    $url = vc_build_link($instance['url']);
    $url_text = (!empty($url['title'])) ? $url['title'] : "Xem thêm";
    $url_link = $url['url'];
    $url_target = (!empty($url['target'])) ? 'target="' . $url['target'] . '"' : "";
    $url_rel = (!empty($url['rel'])) ? 'rel="' . $url['rel'] . '"' : "";
    $html_output = <<<HTML
    <div class="link-item-widget">
        <a href="{$url_link}" {$url_rel} {$url_target}>
            <h3 class="link-title">{$instance['title']}</h3>
            <span>{$url_text}</span>
        </a>
    </div>
HTML;

    return $html_output;
}

add_shortcode('ppo-link-item', 'ppo_shortcode_link_item');