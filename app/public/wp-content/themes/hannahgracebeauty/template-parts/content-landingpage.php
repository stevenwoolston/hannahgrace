<?php
/*
@package: wwd blankslate
*/
?>

<section class="container">
	
	<article id="page-<?php the_ID(); ?>" 
		<?php post_class(array($post->post_name)); ?>>

		<div class="entry-body">
			<?php the_content(); ?>
		</div>

		<div class="entry-footer"></div>

	</article>

</section>