<?php get_header(); ?>

<main id="main-content" class="site-content" role="main" aria-label="Main content">
    <div class="container">
        <?php
        if (have_posts()):
            while (have_posts()):
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title">
                            <?php the_title(); ?>
                        </h1>
                        <?php if (get_the_modified_time('U') !== get_the_time('U')): ?>
                            <div class="entry-meta">
                                <span class="updated-on">
                                    <span class="screen-reader-text">Page last updated on </span>
                                    <time class="entry-date modified"
                                        datetime="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                                        <?php echo get_the_modified_date(get_option('date_format', 'l, F j, Y')); ?>
                                    </time>
                                </span>
                            </div>
                        <?php endif; ?>
                    </header>

                    <div class="entry-content" role="main" aria-label="Page content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . __('Pages:', 'firsttheme'),
                            'after' => '</div>',
                        ));
                        ?>
                    </div>

                    <?php if (comments_open() || get_comments_number()): ?>
                        <footer class="entry-footer">
                            <?php comments_template(); ?>
                        </footer>
                    <?php endif; ?>
                </article>
                <?php
            endwhile;
        else:
            ?>
            <section class="no-content" aria-label="No content found">
                <h1>Page Not Found</h1>
                <p>Sorry, the requested page could not be found.</p>
            </section>
            <?php
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>