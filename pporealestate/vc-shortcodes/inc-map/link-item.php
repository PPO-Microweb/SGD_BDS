<?php

vc_map(array(
    'name' => esc_html__('PPO: Link Item', SHORT_NAME),
    'base' => 'ppo-link-item',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display Link Item', SHORT_NAME),
    'params' => array(
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Title', SHORT_NAME),
            'param_name' => 'title',
            'value' => '',
        ),
        array(
            'type' => 'vc_link',
            'admin_label' => true,
            'heading' => esc_html__('URL', SHORT_NAME),
            'param_name' => 'url',
            'value' => '',
        ),
    )
));
