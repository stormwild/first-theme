<?php
/**
 * Theme functions and definitions
 */

// Define theme constants
define('FIRST_THEME_VERSION', wp_get_theme()->get('Version'));
define('FIRST_THEME_DIR', get_template_directory());
define('FIRST_THEME_URI', get_template_directory_uri());

// Include required files
require_once FIRST_THEME_DIR . '/inc/assets.php';
require_once FIRST_THEME_DIR . '/inc/template-tags.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function first_theme_setup()
{
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Add support for responsive embedded content.
    add_theme_support('responsive-embeds');

    // Add support for editor styles.
    add_theme_support('editor-styles');

    // Add support for HTML5 features.
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ));

    // Add support for custom logo.
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-width' => true,
        'flex-height' => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'first-theme'),
        'footer' => __('Footer Menu', 'first-theme'),
    ));

    // Set content width
    if (!isset($content_width)) {
        $content_width = 1200;
    }
}
add_action('after_setup_theme', 'first_theme_setup');

/**
 * Register widget areas
 */
function first_theme_widgets_init()
{
    register_sidebar(array(
        'name' => __('Footer Widgets', 'first-theme'),
        'id' => 'footer-widgets',
        'description' => __('Add widgets here to appear in your footer.', 'first-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'first_theme_widgets_init');

/**
 * Add security headers
 */
function first_theme_security_headers()
{
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(self), microphone=()');

        // Only add HSTS header if SSL is detected
        if (is_ssl()) {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        }
    }
}
add_action('send_headers', 'first_theme_security_headers');

/**
 * Customize the excerpt ending
 */
function first_theme_excerpt_more($more)
{
    return '&hellip;';
}
add_filter('excerpt_more', 'first_theme_excerpt_more');

/**
 * Add aria-current attribute to nav menu items
 */
function first_theme_nav_menu_link_attributes($atts, $item, $args, $depth)
{
    if (in_array('current-menu-item', $item->classes)) {
        $atts['aria-current'] = 'page';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'first_theme_nav_menu_link_attributes', 10, 4);

/**
 * Ensure images have alt text
 */
function first_theme_ensure_image_alt($html, $post_id)
{
    if (!str_contains($html, 'alt=')) {
        $title = get_the_title($post_id);
        $html = str_replace('<img', '<img alt="' . esc_attr($title) . '"', $html);
    }
    return $html;
}
add_filter('post_thumbnail_html', 'first_theme_ensure_image_alt', 10, 2);

/**
 * Enhance excerpt accessibility
 */
function first_theme_excerpt_append($excerpt)
{
    if (!empty($excerpt)) {
        $post_title = get_the_title();
        return $excerpt . '<span class="screen-reader-text"> of article: ' . esc_html($post_title) . '</span>';
    }
    return $excerpt;
}
add_filter('get_the_excerpt', 'first_theme_excerpt_append', 20);

/**
 * Add custom body classes
 */
function first_theme_body_classes($classes)
{
    // Add a class if there is a custom header image.
    if (has_header_image()) {
        $classes[] = 'has-header-image';
    }

    // Add a class if we're in the customizer preview.
    if (is_customize_preview()) {
        $classes[] = 'customizer-preview';
    }

    // Add a class for JavaScript detection
    $classes[] = 'no-js';

    return $classes;
}
add_filter('body_class', 'first_theme_body_classes');

/**
 * Remove 'no-js' class from body
 */
function first_theme_js_detection()
{
    echo "<script>if (document.body) { document.body.classList.remove('no-js'); }</script>\n";
}
add_action('wp_head', 'first_theme_js_detection', 0);

/**
 * Disable WordPress admin bar for all users except administrators
 */
function first_theme_disable_admin_bar()
{
    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'first_theme_disable_admin_bar');
