<?php
/*
Plugin Name: Rewrite Footer The7
Plugin URI:
Description: Auto Rewrite Footer for The7 Template
Author: David Galet
Author URI: http://www.davidev.it
Version: 1.0.0
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

// Include the dependencies needed to instantiate the plugin.
foreach ( glob( plugin_dir_path( __FILE__ ) . 'admin/*.php' ) as $file ) include_once $file;

// Add process to loaded
add_action( 'plugins_loaded', 'auto_rewrite_footer_the7_settings' );

// Add post method
add_action( 'admin_post_process_rewrite_footer_the7', 'drf_updateDatabase' );

// Starter module
function auto_rewrite_footer_the7_settings() {
    $plugin = new Submenu( new Submenu_Page() );
    $plugin->init();
}

// POST request update database
function drf_updateDatabase() {
    // Get url request
    if ( !empty( $_POST['_wp_http_referer'] ) ) {
        $form_url = esc_url_raw( wp_unslash( $_POST['_wp_http_referer'] ) );
    } else {
        $form_url = home_url( '/' );
    }
    // Check if is present widgetarea_id
    if (isset($_POST['widgetarea_id'])){
        global $wpdb;
        $elements = get_element($_POST['type']);
        // Check presence post or page
        if (count($elements) > 0) {
            foreach ($elements as $element) {
                $wpdb->query("UPDATE {$wpdb->prefix}postmeta SET `meta_value` = 1 WHERE post_id = '" . (int)$element . "' AND meta_key = '_dt_footer_show'");
                $wpdb->query("UPDATE {$wpdb->prefix}postmeta SET `meta_value` = '" . esc_sql($_POST['widgetarea_id']) . "' WHERE post_id = '" . (int)$element . "' AND meta_key = '_dt_footer_widgetarea_id'");
            }
        }
        wp_safe_redirect(
            esc_url_raw(
                add_query_arg( array(
                        'status' => 'success',
                        'elements' => count($elements)
                ), $form_url )
            )
        );
        exit();
    } else {
        wp_safe_redirect(
            esc_url_raw(
                add_query_arg('status', 'error', $form_url)
            )
        );
        exit();
    }
}

// Get list id page or post
function get_element( $type = 'page' ) {
    if ($type == 'page'){
        return wp_list_pluck( get_pages(), 'ID' );
    } else {
        return wp_list_pluck( get_posts(), 'ID' );
    }
}

// Message Success
add_action( 'drf_success', 'drf_notice__success' );
function drf_notice__success() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Done! ' . (isset($_GET['elements'])) ? 'Edit: ' . $_GET['elements'] . ' elements.' : 0 . ' elements.' , 'davidev-rewrite-footer' ); ?></p>
    </div>
    <?php
}

// Message error
add_action( 'drf_error', 'drf_notice__error' );
function drf_notice__error() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( 'Error, please try again', 'davidev-rewrite-footer' ); ?></p>
    </div>
    <?php
}

