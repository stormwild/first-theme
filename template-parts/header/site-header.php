<?php
/**
 * Displays the site header
 */
?>

<header class="site-header" role="banner">
    <div class="container">
        <div class="site-branding">
            <?php
            if (has_custom_logo()):
                the_custom_logo();
            else:
                ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
                <?php
                $description = get_bloginfo('description', 'display');
                if ($description || is_customize_preview()):
                    ?>
                    <p class="site-description">
                        <?php echo $description; ?>
                    </p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <nav id="site-navigation" class="main-navigation" role="navigation"
            aria-label="<?php esc_attr_e('Primary Navigation', 'firsttheme'); ?>">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="screen-reader-text"><?php esc_html_e('Menu', 'firsttheme'); ?></span>
                <span class="menu-toggle-icon"></span>
            </button>

            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id' => 'primary-menu',
                'menu_class' => 'primary-menu',
                'container_class' => 'primary-menu-container',
                'fallback_cb' => function () {
                    ?>
                <ul id="primary-menu" class="primary-menu">
                    <li><a
                            href="<?php echo esc_url(admin_url('nav-menus.php')); ?>"><?php esc_html_e('Add a menu', 'firsttheme'); ?></a>
                    </li>
                </ul>
                <?php
                },
            ));
            ?>
        </nav>
    </div>
</header>

<?php if (is_front_page() && has_header_image()): ?>
    <div class="header-image">
        <?php the_header_image_tag(); ?>
    </div>
<?php endif; ?>