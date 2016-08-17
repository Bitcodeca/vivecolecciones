<?php
$current_user = wp_get_current_user(); 
$usuariologged = $current_user->user_login;
$nombrelogged = $current_user->user_firstname;
$apellidologged = $current_user->user_lastname;
$emaillogged = $current_user->user_email;
$usuarioid = $current_user->id;
$grvimg = get_avatar( $usuarioid, 32 );
?>