<?php get_header(); ?>

<main id="main-content" class="site-content" role="main" aria-label="Main content">
    <div class="container">
        <?php
        if (have_posts()):
            while (have_posts()):
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom: 2rem">
                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <div class="entry-meta">
                            <span class="byline">
                                <span class="screen-reader-text">Posted by </span>
                                <span class="author vcard">
                                    <a class="url fn n"
                                        href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                                        title="<?php echo esc_attr(trim(get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name')) ?: get_the_author_meta('display_name')); ?>">
                                        <?php echo esc_html(get_the_author_meta('display_name')); ?>
                                    </a>
                                </span>
                            </span>
                            <span class="posted-on">
                                <span class="screen-reader-text">Article published on </span>
                                <a href="<?php the_permalink(); ?>" rel="bookmark" <?php echo (is_single()) ? ' aria-current="page"' : ''; ?>><time class="entry-date published"
                                        datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php
                                        echo get_the_date(get_option('date_format', 'l, F j, Y'));
                                        ?>
                                    </time></a>
                            </span>
                            <?php if (get_the_modified_time('U') !== get_the_time('U')): ?>
                                <span class="updated-on">
                                    <span class="screen-reader-text">Article last updated on </span>
                                    <a href="<?php the_permalink(); ?>" rel="bookmark" <?php echo (is_single()) ? ' aria-current="page"' : ''; ?>><time class="entry-date modified"
                                            datetime="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                                            <?php
                                            echo get_the_modified_date(get_option('date_format', 'l, F j, Y'));
                                            ?>
                                        </time></a>
                                </span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <div class="entry-summary" aria-label="Article excerpt">
                        <?php the_excerpt(); ?>
                    </div>

                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more" title="<?php the_title_attribute(); ?>">
                            Read more<span class="screen-reader-text"> about <?php the_title(); ?></span>
                        </a>
                    </footer>
                </article>
                <?php
            endwhile;

            the_posts_pagination(array(
                'prev_text' => __('Previous page', 'firsttheme'),
                'next_text' => __('Next page', 'firsttheme'),
                'screen_reader_text' => __('Posts navigation', 'firsttheme')
            ));

        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>