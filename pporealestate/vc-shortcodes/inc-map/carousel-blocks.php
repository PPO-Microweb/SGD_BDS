<?php

vc_map(array(
    'name' => esc_html__('PPO: Carousel Blocks', SHORT_NAME),
    'base' => 'ppo-carousel-blocks',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display carousel blocks', SHORT_NAME),
    'params' => array(
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Title', SHORT_NAME),
            'param_name' => 'title',
            'value' => '',
        ),
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Number', SHORT_NAME),
            'param_name' => 'number',
            'value' => '',
        ),
        array(
            'type' => 'dropdown',
            'admin_label' => true,
            'heading' => esc_html__('Order by', SHORT_NAME),
            'param_name' => 'orderby',
            'std' => 'date',
            'value' => array(
                esc_html__('Select', SHORT_NAME) => '',
                esc_html__('Recent', SHORT_NAME) => 'date',
                esc_html__('Title', SHORT_NAME) => 'title',
                esc_html__('Random', SHORT_NAME) => 'rand',
            ),
        ),
        array(
            'type' => 'dropdown',
            'admin_label' => true,
            'heading' => esc_html__('Order', SHORT_NAME),
            'param_name' => 'order',
            'std' => 'desc',
            'value' => array(
                esc_html__('Select', SHORT_NAME) => '',
                esc_html__('ASC', SHORT_NAME) => 'asc',
                esc_html__('DESC', SHORT_NAME) => 'desc',
            ),
        ),
    )
));
