<?php
/**
 * Asset management functions
 */

/**
 * Enqueue theme scripts and styles
 */
function first_theme_enqueue_assets()
{
    $theme_version = wp_get_theme()->get('Version');
    $is_development = defined('WP_DEBUG') && WP_DEBUG;

    // Main theme stylesheet (already enqueued in functions.php)

    // Enqueue compiled CSS
    wp_enqueue_style(
        'first-theme-compiled',
        get_template_directory_uri() . '/dist/css/styles.css',
        array(),
        $is_development ? time() : $theme_version
    );

    // Enqueue compiled JavaScript
    wp_enqueue_script(
        'first-theme-scripts',
        get_template_directory_uri() . '/dist/js/main.js',
        array('jquery'),
        $is_development ? time() : $theme_version,
        true
    );

    // Localize script with WordPress data
    wp_localize_script(
        'first-theme-scripts',
        'firstThemeData',
        array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('first-theme-nonce'),
            'isLoggedIn' => is_user_logged_in(),
            'homeUrl' => home_url('/'),
            'themeUrl' => get_template_directory_uri(),
        )
    );

    // Admin scripts
    if (is_admin()) {
        wp_enqueue_script(
            'first-theme-admin',
            get_template_directory_uri() . '/dist/js/admin.js',
            array('jquery', 'wp-api'),
            $is_development ? time() : $theme_version,
            true
        );
    }

    // Customizer preview script
    if (is_customize_preview()) {
        wp_enqueue_script(
            'first-theme-customizer',
            get_template_directory_uri() . '/dist/js/admin.js',
            array('jquery', 'customize-preview'),
            $is_development ? time() : $theme_version,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'first_theme_enqueue_assets');

/**
 * Add preload for critical assets
 */
function first_theme_resource_hints($urls, $relation_type)
{
    if ($relation_type === 'preload') {
        // Preload main CSS file
        $urls[] = array(
            'href' => get_template_directory_uri() . '/dist/css/styles.css',
            'as' => 'style',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'first_theme_resource_hints', 10, 2);

/**
 * Add async/defer attributes to scripts
 */
function first_theme_script_loader_tag($tag, $handle, $src)
{
    // Add async/defer attributes to non-critical scripts
    $async_scripts = array(
        'first-theme-admin',
    );

    $defer_scripts = array(
        'first-theme-scripts',
    );

    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'first_theme_script_loader_tag', 10, 3);