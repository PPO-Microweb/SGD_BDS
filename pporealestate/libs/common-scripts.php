<?php
/* ----------------------------------------------------------------------------------- */
# Register main Scripts and Styles
/* ----------------------------------------------------------------------------------- */
add_action('admin_enqueue_scripts', 'ppo_register_scripts');

function ppo_register_scripts(){
    wp_enqueue_media();
    
    ## Register All Styles
    wp_register_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_register_style('chosen-template', get_template_directory_uri() . '/libs/css/chosen.min.css');
    wp_register_style('colorpicker-template', get_template_directory_uri() . '/libs/css/colorpicker.css');
    wp_register_style('toastr-template', get_stylesheet_directory_uri() . '/libs/css/toastr.min.css');
    
    wp_enqueue_style('font-awesome');
    wp_enqueue_style('chosen-template');
    wp_enqueue_style('colorpicker-template');
    wp_enqueue_style('toastr-template');
    
    ## Register All Scripts
    wp_register_script(SHORT_NAME . '-chosen', get_template_directory_uri() . '/libs/js/chosen.jquery.min.js', array('jquery'));
    wp_register_script(SHORT_NAME . '-colorpicker', get_template_directory_uri() . '/libs/js/colorpicker.js', array('jquery'));
    wp_register_script(SHORT_NAME . '-md5', get_template_directory_uri() . '/libs/js/jquery.md5.min.js', array('jquery'));
    wp_register_script(SHORT_NAME . '-toastr', get_stylesheet_directory_uri() . '/libs/js/toastr.min.js', array('jquery'));
    wp_register_script(SHORT_NAME . '-scripts', get_template_directory_uri() . '/libs/js/scripts.js', array('jquery'));

    ## Get Global Scripts
    wp_enqueue_script(SHORT_NAME . '-chosen');
    wp_enqueue_script(SHORT_NAME . '-colorpicker');
    wp_enqueue_script(SHORT_NAME . '-md5');
    wp_enqueue_script(SHORT_NAME . '-toastr');
    wp_enqueue_script(SHORT_NAME . '-scripts');
}