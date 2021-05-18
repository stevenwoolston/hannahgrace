<?php
/*
@package: wwd blankslate
*/
    wp_reset_query();
	query_posts(array( 
		'post_type' => 'layout',
		'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'builder-component',
                'field' => 'slug',
                'terms' => 'footer'
            )
        ),
        'posts_per_page' => 2,
		'orderby' => 'menu_order',
		'order' => 'ASC')
	);
?>
<footer class="page-footer">
<?php   if (have_posts()):  ?>
    <div class="gutter footer-content">
<?php       while(have_posts()): the_post();    ?>
        <div class="footer-content-item">
<?php 
echo do_shortcode( apply_filters( 'the_content', get_the_content() ) );
?>
        </div>
<?php       endwhile;   ?>
    </div>
<?php   endif;  ?>
    <div class="gutter footer-references">
        <div>
            <?php echo 'Copyright ', esc_html(get_bloginfo('name')) . ' Ltd. All rights reserved ', date( 'Y' ); ?>
        </div>
        <div>
            Design by <a href="https://www.woolston.com.au" target="_blank">Woolston Web Design</a>
        </div>
        <div>
            <a href="/privacy-policy">Privacy Policy</a>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>