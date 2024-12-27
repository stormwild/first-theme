<?php get_header(); ?>

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
                <div class="entry-meta">
                    <span class="byline">
                        <span class="screen-reader-text">Posted by </span>
                        <span class="author vcard">
                            <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                                title="<?php echo esc_attr(trim(get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name')) ?: get_the_author_meta('display_name')); ?>">
                                <?php echo esc_html(get_the_author_meta('display_name')); ?>
                            </a>
                        </span>
                    </span>
                    <span class="posted-on">
                        <span class="screen-reader-text">Article published on </span>
                        <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo get_the_date(get_option('date_format', 'l, F j, Y')); ?>
                        </time>
                    </span>
                    <?php if (get_the_modified_time('U') !== get_the_time('U')): ?>
                        <span class="updated-on">
                            <span class="screen-reader-text">Article last updated on </span>
                            <time class="entry-date modified" datetime="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                                <?php echo get_the_modified_date(get_option('date_format', 'l, F j, Y')); ?>
                            </time>
                        </span>
                    <?php endif; ?>
                </div>
            </header>

            <div class="entry-content" role="main" aria-label="Article content">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . __('Pages:', 'firsttheme'),
                    'after' => '</div>',
                ));
                ?>
            </div>

            <footer class="entry-footer">
                <?php
                $categories_list = get_the_category_list(', ');
                if ($categories_list) {
                    printf('<span class="cat-links">Posted in %s</span>', $categories_list);
                }

                $tags_list = get_the_tag_list('', ', ');
                if ($tags_list) {
                    printf('<span class="tags-links">Tagged %s</span>', $tags_list);
                }
                ?>
            </footer>
        </article>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()):
            comments_template();
        endif;
        ?>

        <?php
    endwhile;
else:
    ?>
    <section class="no-posts" aria-label="No posts found">
        <h1>No Post Found</h1>
        <p>Sorry, the requested post could not be found.</p>
    </section>
    <?php
endif;
?>

<?php get_footer(); ?>