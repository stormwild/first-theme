<?php

function firsttheme_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Add support for responsive embedded content.
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'firsttheme_setup');

function firsttheme_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('firsttheme-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'firsttheme_scripts');

/**
 * Customize the excerpt ending
 */
function firsttheme_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'firsttheme_excerpt_more');

/**
 * Add aria-current attribute to nav menu items
 */
function firsttheme_nav_menu_link_attributes($atts, $item, $args, $depth) {
    if (in_array('current-menu-item', $item->classes)) {
        $atts['aria-current'] = 'page';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'firsttheme_nav_menu_link_attributes', 10, 4);

/**
 * Ensure images have alt text
 */
function firsttheme_ensure_image_alt($html, $post_id) {
    if (!str_contains($html, 'alt=')) {
        $title = get_the_title($post_id);
        $html = str_replace('<img', '<img alt="' . esc_attr($title) . '"', $html);
    }
    return $html;
}
add_filter('post_thumbnail_html', 'firsttheme_ensure_image_alt', 10, 2);

/**
 * Enhance excerpt accessibility
 */
function firsttheme_excerpt_append($excerpt) {
    if (!empty($excerpt)) {
        $post_title = get_the_title();
        return $excerpt . '<span class="screen-reader-text"> of article: ' . esc_html($post_title) . '</span>';
    }
    return $excerpt;
}
add_filter('get_the_excerpt', 'firsttheme_excerpt_append', 20);
