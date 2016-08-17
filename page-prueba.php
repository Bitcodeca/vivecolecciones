<?php get_header();
	$current_user = wp_get_current_user(); 
	$usuarioid = $current_user->id;
	$grvimg = get_avatar( $usuarioid, 56 );
    $grvimg = explode('class="', $grvimg);
    $grvimg[1] = 'class="img-circle ' . $grvimg[1];
    $grvimg = $grvimg[0] . $grvimg[1];
    echo $grvimg;
get_footer(); ?>