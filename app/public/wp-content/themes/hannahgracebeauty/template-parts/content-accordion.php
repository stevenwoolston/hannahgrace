<?php
/*
@package: wwd blankslate
*/
?>

<div class="card">
    <div class="card-header gutter" id="<?php echo 'article' .get_the_ID(); ?>">
        <h2 class="mb-0">
            <button class="btn btn-link btn-block" type="button" data-toggle="collapse" 
                data-target="#<?php echo 'faq' .get_the_ID(); ?>" aria-expanded="true" 
                aria-controls="<?php echo 'faq' .get_the_ID(); ?>">
                <span><?php the_title(); ?></span>
                <i class="las la-plus-circle bg-1 rounded-circle float-right"></i>
                <i class="las la-minus-circle bg-1 rounded-circle float-right"></i>
            </button>
        </h2>
    </div>

    <div class="collapse" id="<?php echo 'faq' .get_the_ID(); ?>" 
        aria-labelledby="headingOne" data-parent="#md_accordion">
        <div class="card-body"><?php the_content(); ?></div>
    </div>

</div>