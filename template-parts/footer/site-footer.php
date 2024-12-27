<?php
/**
 * Displays the site footer
 */
?>

<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-content">
            <div class="footer-branding">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <p class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>

            <nav class="footer-navigation" role="navigation"
                aria-label="<?php esc_attr_e('Footer Navigation', 'first-theme'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class' => 'footer-menu',
                    'container_class' => 'footer-menu-container',
                    'depth' => 1,
                    'fallback_cb' => false,
                ));
                ?>
            </nav>

            <div class="footer-info">
                <div class="copyright">
                    <?php
                    printf(
                        /* translators: %1$s: Current year, %2$s: Site name */
                        esc_html__('© %1$s %2$s. All rights reserved.', 'first-theme'),
                        date_i18n('Y'),
                        get_bloginfo('name')
                    );
                    ?>
                </div>

                <?php
                if (function_exists('the_privacy_policy_link')) {
                    the_privacy_policy_link('<div class="privacy-policy-link">', '</div>');
                }
                ?>
            </div>
        </div>

        <?php if (is_active_sidebar('footer-widgets')): ?>
            <div class="footer-widgets" role="complementary"
                aria-label="<?php esc_attr_e('Footer Widgets', 'first-theme'); ?>">
                <?php dynamic_sidebar('footer-widgets'); ?>
            </div>
        <?php endif; ?>

        <div class="scroll-to-top">
            <button class="scroll-to-top-button" aria-label="<?php esc_attr_e('Scroll to top', 'first-theme'); ?>">
                <span class="screen-reader-text"><?php esc_html_e('Scroll to top', 'first-theme'); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M12 4l-8 8h6v8h4v-8h6z" />
                </svg>
            </button>
        </div>
    </div>
</footer>