<?php get_header(); 
	if ( is_user_logged_in() ) {
		$user_logged=user_logged();
		require_once 'api/vive-db.php';
		
	} 
 get_footer(); ?>
<script>
	jQuery(document).ready(function() {
	});
</script>