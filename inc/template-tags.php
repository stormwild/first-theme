<?php
/**
 * Custom template tags for this theme
 */

if (!function_exists('firsttheme_post_meta')):
    /**
     * Prints HTML with meta information for the current post.
     */
    function firsttheme_post_meta()
    {
        // Get the author name; wrap it in a link.
        $byline = sprintf(
            /* translators: %s: post author */
            __('by %s', 'firsttheme'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">'
            . esc_html(get_the_author())
            . '</a></span>'
        );

        // Get the date.
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>'
                . '<time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        // Wrap the time string in a link, and preface it with 'Posted on'.
        $posted_on = sprintf(
            /* translators: %s: post date */
            __('Posted on %s', 'firsttheme'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        // Comments.
        $comments = '';
        if (!post_password_required() && (comments_open() || get_comments_number())) {
            $comments_number = get_comments_number();
            if ($comments_number > 0) {
                $comments = sprintf(
                    /* translators: %s: Number of comments. */
                    _nx(
                        '%s Comment',
                        '%s Comments',
                        $comments_number,
                        'Comments title',
                        'firsttheme'
                    ),
                    number_format_i18n($comments_number)
                );
            } else {
                $comments = __('Leave a comment', 'firsttheme');
            }
            $comments = '<span class="comments-link"><a href="' . esc_url(get_comments_link()) . '">' . $comments . '</a></span>';
        }

        // Categories.
        $categories_list = get_the_category_list(', ');
        if ($categories_list) {
            /* translators: 1: posted in label, 2: list of categories */
            $categories_list = sprintf(
                '<span class="cat-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
                esc_html__('Posted in', 'firsttheme'),
                $categories_list
            );
        }

        echo '<div class="entry-meta">';
        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

        if ($categories_list) {
            echo ' ' . $categories_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        if ($comments) {
            echo ' ' . $comments; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
        echo '</div>';
    }
endif;

if (!function_exists('firsttheme_post_thumbnail')):
    /**
     * Displays an optional post thumbnail.
     */
    function firsttheme_post_thumbnail()
    {
        if (!post_password_required() && !is_attachment() && has_post_thumbnail()) {
            ?>
            <div class="post-thumbnail">
                <?php
                if (is_singular()):
                    the_post_thumbnail('large', array(
                        'class' => 'featured-image',
                        'loading' => 'eager',
                    ));
                else:
                    ?>
                    <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                        <?php
                        the_post_thumbnail('medium_large', array(
                            'class' => 'featured-image',
                            'alt' => the_title_attribute(array('echo' => false)),
                        ));
                        ?>
                    </a>
                    <?php
                endif;
                ?>
            </div>
            <?php
        }
    }
endif;

if (!function_exists('firsttheme_entry_footer')):
    /**
     * Prints HTML with meta information for tags and edit link.
     */
    function firsttheme_entry_footer()
    {
        // Hide tag text for pages.
        if ('post' === get_post_type()) {
            $tags_list = get_the_tag_list('', ', ');
            if ($tags_list) {
                printf(
                    '<div class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</div>',
                    esc_html__('Tags:', 'firsttheme'),
                    $tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                );
            }
        }

        edit_post_link(
            sprintf(
                /* translators: %s: Post title. */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'firsttheme'),
                get_the_title()
            ),
            '<div class="edit-link">',
            '</div>'
        );
    }
endif;