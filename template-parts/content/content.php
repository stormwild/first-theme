<?php
/**
 * Template part for displaying posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (is_singular()): ?>
        <header class="entry-header">
            <h1 class="entry-title">
                <?php the_title(); ?>
            </h1>
            <?php first_theme_post_meta(); ?>
        </header>
    <?php else: ?>
        <header class="entry-header">
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark">
                    <?php the_title(); ?>
                </a>
            </h2>
            <?php first_theme_post_meta(); ?>
        </header>
    <?php endif; ?>

    <?php if (has_post_thumbnail() && !post_password_required()): ?>
        <div class="post-thumbnail">
            <?php if (is_singular()): ?>
                <?php the_post_thumbnail('large', array(
                    'class' => 'featured-image',
                    'loading' => 'eager',
                )); ?>
            <?php else: ?>
                <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                    <?php the_post_thumbnail('medium_large', array(
                        'class' => 'featured-image',
                    )); ?>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        if (is_singular()) {
            the_content(
                sprintf(
                    /* translators: %s: Post title. */
                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'first-theme'),
                    get_the_title()
                )
            );

            wp_link_pages(array(
                'before' => '<div class="page-links">' . __('Pages:', 'first-theme'),
                'after' => '</div>',
            ));
        } else {
            the_excerpt();
            printf(
                '<p class="more-link-container"><a href="%1$s" class="more-link">%2$s<span class="screen-reader-text"> %3$s</span></a></p>',
                esc_url(get_permalink()),
                __('Continue reading', 'first-theme'),
                /* translators: %s: Post title. */
                sprintf(__('"%s"', 'first-theme'), get_the_title())
            );
        }
        ?>
    </div>

    <footer class="entry-footer">
        <?php
        // Show categories and tags on single posts
        if (is_singular('post')) {
            $categories_list = get_the_category_list(', ');
            if ($categories_list) {
                printf(
                    /* translators: %s: List of categories. */
                    '<div class="cat-links">%s %s</div>',
                    esc_html__('Posted in:', 'first-theme'),
                    $categories_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                );
            }

            $tags_list = get_the_tag_list('', ', ');
            if ($tags_list) {
                printf(
                    /* translators: %s: List of tags. */
                    '<div class="tags-links">%s %s</div>',
                    esc_html__('Tagged:', 'first-theme'),
                    $tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                );
            }
        }

        // Edit post link
        edit_post_link(
            sprintf(
                /* translators: %s: Post title. */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'first-theme'),
                get_the_title()
            ),
            '<div class="edit-link">',
            '</div>'
        );
        ?>
    </footer>
</article>