<?php
	//Constantes 
	$args=array('post_status' => 'publish', 'order' => 'ASC', 'posts_per_page' => -1, 'post_type'=> 'admin', 'tax_query' => array( array(  'taxonomy' => 'campaña', 'field' => 'name', 'terms' => $cliente ) ) ); 
	$my_query = new WP_Query($args);
    if( $my_query->have_posts() ) { 
    	//Inicializacion
    	$totalcosto=0;$totalcantidad=0;$x=0;
      	while ($my_query->have_posts()) : $my_query->the_post(); $id = get_the_ID();

      		//Ganancia del vendedor
	      	$gananciavendedorarray = get_the_terms( $post->ID , 'gananciavendedor' ); 
	      	$gananciavendedor=$gananciavendedorarray[0]->name;

	      	//Premio basico
	      	$premiobasicoarray = get_the_terms( $post->ID , 'premiobasico' ); 
	      	$premiobasico=$premiobasicoarray[0]->name;

	      	//Distribucion
	      	$distribucionarray = get_the_terms( $post->ID , 'distribucion' ); 
	      	$distribucion=$distribucionarray[0]->name;

	      	//Gerencia
	      	$gerenciaarray = get_the_terms( $post->ID , 'gerencia' ); 
	      	$gerencia=$gerenciaarray[0]->name;

	      	//Incentivo
	      	$incentivoarray = get_the_terms( $post->ID , 'incentivo' ); 
	      	$incentivo=$incentivoarray[0]->name;

	      	//Gerentes Seleccionados Cambios y Averias
	      	$gerentearray = get_the_terms( $post->ID , 'Gerente' );

      	endwhile; 
      } wp_reset_query();

?>