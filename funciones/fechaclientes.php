<?php
	$d = DateTime::createFromFormat("d/m/Y", $fecha);
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c1=date_format($d,"d/m/Y");
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c2=date_format($d,"d/m/Y");
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c3=date_format($d,"d/m/Y");
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c4=date_format($d,"d/m/Y");

	$todoslosusuarios = get_users();
	foreach ( $todoslosusuarios as $user ) {
		 $buscar=$user->user_login;
		 $args=array('post_status' => 'publish', 'post_type'=> 'post', 'posts_per_page' => -1,  'order' => 'DESC', 'tax_query' => array( array(  'taxonomy' => 'Gerente', 'field' => 'slug', 'terms' => $buscar ) ) ); $my_query = new WP_Query($args);
	        if( $my_query->have_posts() ) {
	        	while ($my_query->have_posts()) : $my_query->the_post(); $id = get_the_ID();
	        		${'fecha'.$buscar}=get_the_date('d/m/Y');
	        	endwhile;
	        	$d = DateTime::createFromFormat("d/m/Y", ${'fecha'.$buscar});
				date_add($d,date_interval_create_from_date_string("15 days"));
				${'c1'.$buscar}=date_format($d,"d/m/Y");
				date_add($d,date_interval_create_from_date_string("15 days"));
				${'c2'.$buscar}=date_format($d,"d/m/Y");
				date_add($d,date_interval_create_from_date_string("15 days"));
				${'c3'.$buscar}=date_format($d,"d/m/Y");
				date_add($d,date_interval_create_from_date_string("15 days"));
				${'c4'.$buscar}=date_format($d,"d/m/Y");
				${'montoq1'.$buscar}=0;
				${'montoq2'.$buscar}=0;
				${'montoq3'.$buscar}=0;
				${'montoq4'.$buscar}=0;
	        }
	}
?>