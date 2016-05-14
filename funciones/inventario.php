<?php 
    //Por usuario
	//Inicializacion
	$totalcosto=0;$totalcantidad=0;$x=0;
	
	while ($my_query->have_posts()) : $my_query->the_post(); $id = get_the_ID();

		//El producto
        $categories = get_the_category(); 
        $producto=$categories[0]->name;

        //Cantidad del producto
        $cantidadarray = get_the_terms( $post->ID , 'cantidad' ); 
        $cantidad=$cantidadarray[0]->name; 

        //Costo del producto
        $costoarray = get_the_terms( $post->ID , 'costo' ); 
        $costo=$costoarray[0]->name;

        //Total del producto
        $preciototal=$cantidad*$costo; 

        //Sumatoria de los totales de los productos
        $totalcosto=$totalcosto+$preciototal;

        //Sumatoria de las cantidades de productos 
        $totalcantidad=$totalcantidad+$cantidad;

        $fecha=get_the_date('d/m/Y');
        
        $x++;

    endwhile;

	//Ganancia del vendedor actual
	$totalvendedor=$gananciavendedor*$totalcantidad;

	//Total
	$total=$totalcosto-$totalvendedor;

	//Subtotal de Premio basico
	$subtotalpremiobasico=$totalcantidad*$premiobasico;

	//Subtotal de Distribucion
	$subtotaldistribucion=$totalcantidad*$distribucion;

	//Subtotal de Gerencia
	$subtotalgerencia=$totalcantidad*$gerencia;

	//Total a cancelar
	$totalacancelar=$total-$subtotalgerencia-$subtotaldistribucion-$subtotalpremiobasico;

	//Total a depositar quincenal
	$totaladepositarquincenal=$total/4;
?>