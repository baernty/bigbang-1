<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bigbang
 */

/*
|--------------------------------------------------------------------------
| Menus
|--------------------------------------------------------------------------
*/

/* Primary Menu
------------------------------------- */
if (!function_exists('bb_primary_nav'))
{
    /**
     * Generate your primary menu and feel free to overwrite/extend the sensible defaults
     *
     * @param  array  $args Arguments
     * @return string       Menu
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_primary_nav($args = array())
    {
        $defaults = array(
            'menu'           => 'primary_nav',
            'theme_location' => 'primary_nav',
            'container'      => false,
            'menu_class'     => 'menu primary-nav',
            'fallback_cb'    => 'bb_primary_nav_fallback',
        );

        $args = array_merge($defaults, $args);

        wp_nav_menu($args);
    }
}

if (!function_exists('bb_primary_nav_fallback'))
{
    /**
     * Callback function if no primary menu exists
     *
     * @return string Generated menu
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_primary_nav_fallback()
    {
        wp_page_menu(array('show_home' => true, 'menu_class' => 'menu primary-nav'));
    }
}


/* Secondary Menu
------------------------------------- */
if (!function_exists('bb_secondary_nav'))
{
    /**
     * Generate your secondary menu and feel free to overwrite/extend the sensible defaults
     *
     * @param  array  $args Arguments
     * @return string       Generated menu
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_secondary_nav($args = array())
    {
        $defaults = array(
            'menu'           => 'secondary_nav',
            'theme_location' => 'secondary_nav',
            'container'      => false,
            'menu_class'     => 'menu secondary-nav',
            'fallback_cb'    => false,
        );

        $args = array_merge($defaults, $args);

        wp_nav_menu($args);
    }
}



/*
|--------------------------------------------------------------------------
| Paging nav
|--------------------------------------------------------------------------
*/
if (!function_exists('bb_paging_nav'))
{
    /**
     * Display navigation to next/previous set of posts when applicable
     *
     * @return string HTML
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_paging_nav()
    {
        // Don't print empty markup if there's only one page
        if ($GLOBALS['wp_query']->max_num_pages < 2) return;
        ?>

        <nav class="navigation paging-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php _e('Posts navigation', 'bigbang'); ?></h1>
            <div class="nav-links">
                <?php if (get_next_posts_link()) : ?>
                    <div class="nav-previous">
                        <?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bigbang' ) ); ?>
                    </div>
                <?php endif; ?>

                <?php if (get_previous_posts_link()) : ?>
                    <div class="nav-next">
                        <?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bigbang' ) ); ?>
                    </div>
                <?php endif; ?>
            </div><!-- .nav-links -->
        </nav><!-- .navigation -->

        <?php
    }
}



/*
|--------------------------------------------------------------------------
| Posts nav
|--------------------------------------------------------------------------
*/
if (!function_exists('bb_post_nav'))
{
    /**
     * Display navigation to next/previous post when applicable
     *
     * @return string HTML
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_post_nav()
    {
        // Don't print empty markup if there's nowhere to navigate
        $previous = (is_attachment()) ? get_post( get_post()->post_parent ) : get_adjacent_post(false, '', true);
        $next     = get_adjacent_post(false, '', false);

        if (!$next && !$previous) return;
        ?>

        <nav class="navigation post-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php _e('Post navigation', 'bigbang'); ?></h1>
            <div class="nav-links">
                <?php
                    previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'bigbang' ) );
                    next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'bigbang' ) );
                ?>
            </div><!-- .nav-links -->
        </nav><!-- .navigation -->

        <?php
    }
}



/*
|--------------------------------------------------------------------------
| Posted on
|--------------------------------------------------------------------------
*/
if (!function_exists('bb_posted_on'))
{
    /**
     * Prints HTML with meta information for the current post-date/time and author
     *
     * @return strin HTML
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_posted_on()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        if (get_the_time('U') !== get_the_modified_time('U'))
        {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            _x('Posted on %s', 'post date', 'bigbang'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        $byline = sprintf(
            _x('by %s', 'post author', 'bigbang'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
    }
}



/*
|--------------------------------------------------------------------------
| Article Footer
|--------------------------------------------------------------------------
*/
if (!function_exists('bb_entry_footer'))
{
    /**
     * Prints HTML with meta information for the categories, tags and comments
     * @return string HTML Output
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_entry_footer()
    {
        // Hide category and tag text for pages.
        if ('post' == get_post_type())
        {
            // Categories
            $categories_list = get_the_category_list(__(', ', 'bigbang')); // Translators, there's a space after the comma

            if ($categories_list && bb_categorized_blog())
            {
                printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'bigbang' ) . '</span>', $categories_list );
            }

            // Tags
            $tags_list = get_the_tag_list( '', __( ', ', 'bigbang' ) ); // Translators, there's a space after the comma

            if ( $tags_list )
            {
                printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'bigbang' ) . '</span>', $tags_list );
            }
        }

        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) )
        {
            echo '<span class="comments-link">';
            comments_popup_link( __( 'Leave a comment', 'bigbang' ), __( '1 Comment', 'bigbang' ), __( '% Comments', 'bigbang' ) );
            echo '</span>';
        }

        edit_post_link( __( 'Edit', 'bigbang' ), '<span class="edit-link">', '</span>' );
    }
}



/*
|--------------------------------------------------------------------------
| The Archive title
|--------------------------------------------------------------------------
*/
if (!function_exists('the_archive_title'))
{
    /**
     * Shim for 'the_archive_title()'
     * Display the archive title base on the queried object
     * TODO: Remove this function when Wordpress 4.3 is released
     *
     * @param  string $before Optional. Content to prepend to the title. Default empty.
     * @param  string $after  Optional. Content to append to the title. Default empty.
     * @return string         Title
     * @author Markus Schober
     * @since  1.0.0
     */
    function the_archive_title($before = '', $after = '')
    {
        if (is_category())
        {
            $title = sprintf( __('Category: %s', 'bigbang'), single_cat_title('', false));
        }
        elseif (is_tag())
        {
            $title = sprintf(__('Tag: %s', 'bigbang'), single_tag_title('', false));
        }
        elseif (is_author())
        {
            $title = sprintf(__('Author: %s', 'bigbang'), '<span class="vcard">' . get_the_author() . '</span>' );
        }
        elseif (is_year())
        {
            $title = sprintf(__('Year: %s', 'bigbang'), get_the_date(_x('Y', 'yearly archives date format', 'bigbang')));
        }
        elseif (is_month())
        {
            $title = sprintf(__('Month: %s', 'bigbang'), get_the_date(_x('F Y', 'monthly archives date format', 'bigbang')));
        }
        elseif (is_day())
        {
            $title = sprintf(__('Day: %s', 'bigbang'), get_the_date(_x('F j, Y', 'daily archives date format', 'bigbang')));
        }
        elseif (is_tax('post_format'))
        {
            if (is_tax( 'post_format', 'post-format-aside'))
            {
                $title = _x('Asides', 'post format archive title', 'bigbang');
            }
            elseif (is_tax( 'post_format', 'post-format-gallery'))
            {
                $title = _x('Galleries', 'post format archive title', 'bigbang');
            }
            elseif (is_tax('post_format', 'post-format-image'))
            {
                $title = _x('Images', 'post format archive title', 'bigbang');
            }
            elseif (is_tax( 'post_format', 'post-format-video'))
            {
                $title = _x('Videos', 'post format archive title', 'bigbang');
            }
            elseif (is_tax('post_format', 'post-format-quote'))
            {
                $title = _x('Quotes', 'post format archive title', 'bigbang');
            }
            elseif (is_tax( 'post_format', 'post-format-link'))
            {
                $title = _x('Links', 'post format archive title', 'bigbang');
            }
            elseif (is_tax('post_format', 'post-format-status'))
            {
                $title = _x('Statuses', 'post format archive title', 'bigbang');
            }
            elseif (is_tax('post_format', 'post-format-audio'))
            {
                $title = _x('Audio', 'post format archive title', 'bigbang');
            }
            elseif (is_tax('post_format', 'post-format-chat'))
            {
                $title = _x('Chats', 'post format archive title', 'bigbang');
            }
        }
        elseif (is_post_type_archive())
        {
            $title = sprintf(__('Archives: %s', 'bigbang'), post_type_archive_title('', false));
        }
        elseif (is_tax())
        {
            $tax = get_taxonomy(get_queried_object()->taxonomy);
            /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
            $title = sprintf(__('%1$s: %2$s', 'bigbang'), $tax->labels->singular_name, single_term_title('', false));
        }
        else
        {
            $title = __('Archives', 'bigbang');
        }

        $title = apply_filters( 'get_the_archive_title', $title );

        if (!empty($title))
        {
            echo $before . $title . $after;
        }
    }
}



/*
|--------------------------------------------------------------------------
| The Archive description
|--------------------------------------------------------------------------
*/
if (!function_exists('the_archive_description'))
{
    /**
     * Shim for `the_archive_description()`
     * Display category, tag or term description
     * TODO Remove this function when Wordpress 4.3 is released
     *
     * @param  string $before Optional. Content to prepend to the description. Default empty.
     * @param  string $after  Optional. Content to append to the description. Default empty.
     * @return string         Archive description
     * @author Markus Schober
     * @since  1.0.0
     */
    function the_archive_description($before = '', $after = '')
    {
        $description = apply_filters('get_the_archive_description', term_description());

        if (!empty($description))
        {
            echo $before . $description . $after;
        }
    }
}



/*
|--------------------------------------------------------------------------
| Is categorized blog
|--------------------------------------------------------------------------
*/
if (!function_exists('bb_categorized_blog'))
{
    /**
     * Returns true if a blog has more than 1 category
     *
     * @return bool
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_categorized_blog()
    {
        if (false === ($all_the_cool_cats = get_transient('bb_categories')))
        {
            $all_the_cool_cats = get_categories(array(
                'fields'     => 'ids',
                'hide_empty' => 1,
                'number'     => 2, // We only need to know if there is more tha one category
            ));

            $all_the_cool_cats = count($all_the_cool_cats);

            set_transient('bb_categories', $all_the_cool_cats);
        }

        if ($all_the_cool_cats > 1)
        {
            return true; // This blog has more than 1 category so bb_categorized_blog should return true.
        }
        else
        {
            return false; // This blog has only 1 category so bb_categorized_blog should return false.
        }
    }
}



/*
|--------------------------------------------------------------------------
| Category transient flusher
|--------------------------------------------------------------------------
*/
if (!function_exists('bb_category_transient_flusher'))
{
    /**
     * Flush out the transients used in bb_categorized_blog
     * @return void
     * @author Markus Schober
     * @since  1.0.0.
     */
    function bb_category_transient_flusher()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        {
            return;
        }

        delete_transient('bb_categories');
    }

    add_action('edit_category', 'bb_category_transient_flusher');
    add_action('save_post', 'bb_category_transient_flusher');
}
