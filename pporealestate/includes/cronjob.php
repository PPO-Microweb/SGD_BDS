<?php

/**
 * add custom time to cron
 */
function filter_cron_schedules($schedules) {
    $schedules['daily'] = array(
        'interval' => 86400, // seconds
        'display' => __('Daily')
    );

    return $schedules;
}

add_filter('cron_schedules', 'filter_cron_schedules');

//wp_clear_scheduled_hook('ppo_delete_post_sync');
//wp_clear_scheduled_hook('ppo_delete_user_sync');

if (!wp_next_scheduled('ppo_delete_post_sync')) {
    wp_schedule_event(time(), 'daily', 'ppo_delete_post_sync'); // hourly, daily and twicedaily
}
if (!wp_next_scheduled('ppo_delete_user_sync')) {
    wp_schedule_event(time(), 'daily', 'ppo_delete_user_sync'); // hourly, daily and twicedaily
}

/**
 * Xóa tin trong danh sách yêu thích khi bản tin chính bị xóa
 */
function ppo_delete_post_sync_process() {
    global $wpdb;
    $favorites = $wpdb->prefix . 'favorites';
    $wpdb->query( $wpdb->prepare("DELETE FROM $favorites WHERE post_id NOT IN (SELECT P.ID FROM $wpdb->posts as P)") );
}

add_action('ppo_delete_post_sync', 'ppo_delete_post_sync_process');

/**
 * Xóa user_id trong bảng rating của user không tồn tại trong hệ thống
 */
function ppo_delete_user_sync_process() {
    global $wpdb;
    $user_ratings = $wpdb->prefix . 'user_ratings';
    $wpdb->query( $wpdb->prepare("DELETE FROM $user_ratings WHERE rating_userid NOT IN (SELECT U.ID FROM $wpdb->users as U)") );
}

add_action('ppo_delete_user_sync', 'ppo_delete_user_sync_process');