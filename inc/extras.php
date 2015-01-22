<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package bigbang
 */

/*
|--------------------------------------------------------------------------
| Title tag
|--------------------------------------------------------------------------
*/
if (version_compare($GLOBALS['wp_version'], '4.1', '<'))
{
    /**
     * Filters wp_title to print a neat <title> tag based on what is being viewed.
     *
     * @param  string $title Default title text for current view
     * @param  string $sep   Optional separator
     * @return string        The filtered title
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_wp_title($title, $sep)
    {
        if (is_feed()) return $title;

        global $page, $paged;

        // Add the blog name
        $title .= get_bloginfo('name', 'display');

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo('description', 'display');

        if ($site_description && (is_home() || is_front_page()))
        {
            $title .= "$sep $site_description";
        }

        // Add a page number if necessary
        if (($paged >= 2 || $page >=2) && !is_404())
        {
            $title .= " $sep " . sprintf(__('Page %s', 'bigbang'), max($paged, $page));
        }

        return $title;
    }

    add_filter('wp_title', 'bb_wp_title', 10, 2);
}



/**
 * Title shim for sites older than Wordpress 4.1.
 * TODO: Remove this function when WordPress 4.3 is released.
 *
 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
 * @author Markus Schober
 * @since  1.0.0
 */
function bb_render_title()
{
    ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php
}

add_action('wp_head', 'bb_render_title');



/*
|--------------------------------------------------------------------------
| Big bang browser body_class
|--------------------------------------------------------------------------
 */
if( ! function_exists('bb_add_browser_to_body_class') )
{
    /**
     * Adds a CSS-class to the <body> tag based on the brower
     *
     * @param  array $classes
     * @return array
     * @author Markus Schober
     * @since 1.0.0
     */
    function bb_add_browser_to_body_class($classes)
    {
        global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

        if( $is_lynx ) $classes[] = 'browser-lynx';
        elseif( $is_gecko ) $classes[] = 'browser-gecko';
        elseif( $is_IE ) $classes[] = 'browser-ie';
        elseif( $is_opera ) $classes[] = 'browser-opera';
        elseif( $is_NS4 ) $classes[] = 'browser-ns4';
        elseif( $is_safari ) $classes[] = 'browser-safari';
        elseif( $is_chrome ) $classes[] = 'browser-chrome';
        elseif( $is_iphone ) $classes[] = 'browser-iphone';
        else $classes[] = '';

        return $classes;
    }

    add_filter('body_class', 'bb_add_browser_to_body_class');
}



/*
|--------------------------------------------------------------------------
| Big Bang page-slug body_class
|--------------------------------------------------------------------------
 */
if( ! function_exists('bb_add_slug_to_body_class') )
{
    /**
     * Adds a CSS-Class to the <body> tag based on the slug of the current page
     *
     * @param  array $classes
     * @return array
     * @author Markus Schober
     * @since 1.0.0
     */
    function bb_add_slug_to_body_class($classes)
    {
        global $post;

        if( is_home() ) {
            $key = array_search('blog', $classes);
            if( $key > -1 ) {
                unset( $classes[$key] );
            }
        }
        elseif( is_page() ) {
            $classes[] = sanitize_html_class( $post->post_name );
        }
        elseif( is_singular() ) {
            $classes[] = sanitize_html_class( $post->post_name );
        }

        return $classes;
    }

    add_filter('body_class', 'bb_add_slug_to_body_class');
}



/*
|--------------------------------------------------------------------------
| Remove unnecessary headlinks
|--------------------------------------------------------------------------
 */
if( ! function_exists('bb_remove_headlinks') ) {
    /**
     * Remove some not really needed stuff between the <head>-tags
     *
     * @author Markus Schober
     * @since 1.0.0
     */
    function bb_remove_headlinks()
    {
        // remove simple discovery link
        remove_action('wp_head', 'rsd_link');
        // remove windows live writer link
        remove_action('wp_head', 'wlwmanifest_link');
        // remove the version number of wordpress
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'start_post_rel_link');
        remove_action('wp_head', 'index_rel_link');
    }

    add_action('init', 'bb_remove_headlinks');
}
