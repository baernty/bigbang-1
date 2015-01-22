<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package bigbang
 */
?>

    </div><!-- #content -->

    <div class="footer-navigation">
        <?php bb_secondary_nav(); ?>
    </div>

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="site-info">
            <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'bigbang' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'bigbang' ), 'WordPress' ); ?></a>
            <span class="sep"> | </span>
            <?php printf( __( 'Theme: %1$s by %2$s.', 'bigbang' ), 'bigbang', '<a href="http://www.markus-schober.at/" rel="designer">Markus Schober</a>' ); ?>
        </div><!-- .site-info -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
