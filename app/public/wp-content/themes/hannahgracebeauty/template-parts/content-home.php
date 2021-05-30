<?php
/*
@package: wwd blankslate
*/
// var_dump($post);

    if (get_the_content()):
?>
    <section class="page-wrap">
<?php 
    the_content();
?>
    </section>
<?php
    endif;
?>