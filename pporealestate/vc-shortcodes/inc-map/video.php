<?php

vc_map(array(
    'name' => esc_html__('PPO: Video Player', SHORT_NAME),
    'base' => 'ppo-video-player',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display video player', SHORT_NAME),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Title', SHORT_NAME),
            'param_name' => 'title',
            'std' => '',
        ),
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Video link', SHORT_NAME),
            'description' => __('Enter link to video (Note: read more about available formats at WordPress <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">codex page</a>).', SHORT_NAME),
            'param_name' => 'video_link',
        ),
        array(
            'type' => 'attach_image',
            'admin_label' => true,
            'heading' => esc_html__('Image', SHORT_NAME),
            'param_name' => 'image',
        ),
        array(
            'type' => 'dropdown',
            'admin_label' => true,
            'heading' => esc_html__('Image size', SHORT_NAME),
            'param_name' => 'image_size',
            'value' => ppo_sc_get_list_image_size(),
        ),
    )
));
