<?php get_header(); 
	if ( is_user_logged_in() ) {
		header("Location: http://vivecolecciones.com.ve/inicio/"); /* Redirect browser */
		exit(); 
	} else {  ?>
		<div class="container">
			<?php echo do_shortcode( '[ultimatemember form_id=5]' ); ?>
		</div>
	<?php }
 get_footer(); ?>