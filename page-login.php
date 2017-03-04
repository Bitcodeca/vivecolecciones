<?php get_header(); 
	if ( is_user_logged_in() ) {
		header("Location:http://app.vivecolecciones.com.ve/escritorio/"); /* Redirect browser */
		exit(); 
	} else {  ?>
		<div class="container">
			<?php echo do_shortcode( '[ultimatemember form_id=8]' ); ?>
		</div>
	<?php }
 get_footer(); ?>