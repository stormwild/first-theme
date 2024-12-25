<?php
/**
 * The main template file
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    if (have_posts()):
        // Load posts loop
        while (have_posts()):
            the_post();
            get_template_part('template-parts/content/content', get_post_type());
        endwhile;

        // Previous/next page navigation
        the_posts_pagination(array(
            'prev_text' => __('Previous page', 'first-theme'),
            'next_text' => __('Next page', 'first-theme'),
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'first-theme') . ' </span>',
            'mid_size' => 2,
            'screen_reader_text' => __('Posts navigation', 'first-theme'),
        ));

    else:
        // If no content, display message
        ?>
        <section class="no-results not-found">
            <header class="page-header">
                <h1 class="page-title"><?php _e('Nothing Found', 'first-theme'); ?></h1>
            </header>

            <div class="page-content">
                <?php
                if (is_search()):
                    ?>
                    <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'first-theme'); ?>
                    </p>
                    <?php
                    get_search_form();
                else:
                    ?>
                    <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'first-theme'); ?>
                    </p>
                    <?php
                    get_search_form();
                endif;
                ?>
            </div>
        </section>
        <?php
    endif;
    ?>
</main>

<?php
get_footer();