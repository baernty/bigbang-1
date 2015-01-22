<?php
/**
 * bigbang functions and definitions
 *
 * @package bigbang
 * @author Markus Schober
 */

/*
|--------------------------------------------------------------------------
| Theme constants
|--------------------------------------------------------------------------
*/
// Theme version
if (!defined('BB_VERSION')) define('BB_VERSION', '1.1.2');


/*
|--------------------------------------------------------------------------
| Content width
|--------------------------------------------------------------------------
*/
/**
 * Content width
 * Set the content width based on the theme's design and stylesheet.
 *
 * @author Markus Schober
 * @since  1.0.0
 */
if ( ! isset( $content_width ) ) {
    $content_width = 1024; /* pixels */
}



/*
|--------------------------------------------------------------------------
| Theme setup
|--------------------------------------------------------------------------
*/
if (!function_exists('bb_setup'))
{
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_setup()
    {
        /**
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on bigbang, use a find and replace
         * to change 'bigbang' to the name of your theme in all the template files
         */
        load_theme_textdomain('bigbang', get_template_directory() . '/languages');

        /**
         * Add default posts and comments RSS feed links to head.
         */
        add_theme_support('automatic-feed-links');

        /**
         * Let Wordpress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect Wordpress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /**
         * Enable support for Post thumbnails on posts and pages.
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');

        /**
         * This theme comes with 2 menus.
         * Feel free to add more in the array
         */
        register_nav_menus(array(
            'primary_nav'   => __('Primary Menu', 'bigbang'),
            'secondary_nav' => __('Secondary Menu', 'bigbang'),
        ));

        /**
         * Switch default core markup for search form, comment form, comments, galleries
         * and captions to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ));

        /**
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ));

        /**
         * Set up the WordPress core custom background feature.
         */
        add_theme_support('custom-background', apply_filters('bb_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
    }

    add_action( 'after_setup_theme', 'bb_setup' );
}



/*
|--------------------------------------------------------------------------
| Register Widgetareas
|--------------------------------------------------------------------------
*/
if (!function_exists('bb_widgets_init'))
{
    /**
     * Register widget areas.
     *
     * @link http://codex.wordpress.org/Function_Reference/register_sidebar
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_widgets_init()
    {
        register_sidebar(array(
            'name' => __('Sidebar', 'bigbang'),
            'id' => 'sidebar-1',
            'description' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h1 class="widget__title">',
            'after_title'   => '</h1>',
        ));
    }

    add_action('widgets_init', 'bb_widgets_init');
}



/*
|--------------------------------------------------------------------------
| Add stylesheets
|--------------------------------------------------------------------------
*/
if (!function_exists('bb_styles'))
{
    /**
     * Adds style.css
     *
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_styles()
    {
        wp_enqueue_style('bigbang_css', get_stylesheet_uri(), array(), BB_VERSION);
    }

    add_action('wp_enqueue_scripts', 'bb_styles');
}



/*
|--------------------------------------------------------------------------
| Add scripts
|--------------------------------------------------------------------------
*/
if (!function_exists('bb_scripts'))
{
    /**
     * Adds scripts
     *
     * @author Markus Schober
     * @since  1.0.0
     */
    function bb_scripts()
    {
        /**
         * Let's add modernizr in the head
         */
        wp_enqueue_script('modernizr', get_template_directory_uri(). '/assets/js/modernizr-min.js', array(), '2.8.3', false);

        /**
         * Add jquery, served by cdnjs
         * You may choose your jquery version
         * jquery 1.11.1 = wordpress default
         */
        $jQuery_version = '1.11.1';
        wp_deregister_script('jquery');
        wp_register_script(
            'jquery',
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/'. $jQuery_version . '/jquery.min.js',
            false,
            $jQuery_version,
            true
        );
        wp_enqueue_script('jquery');

        /**
         * Adds our main script
         */
        wp_enqueue_script('bigbang-main', get_template_directory_uri() . '/assets/js/frontend/main.min.js', array('jquery'), BB_VERSION, true);

        if (is_singular() && comments_open() && get_option('thread_comments'))
        {
            wp_enqueue_script('comment-reply');
        }
    }

    add_action('wp_enqueue_scripts', 'bb_scripts');
}




/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
