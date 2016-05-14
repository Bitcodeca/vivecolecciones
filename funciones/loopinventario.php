<?php 
    //Por usuario
	//Inicializacion
	$totalcosto=0;$totalcantidad=0;$x=0;
	while ($my_query->have_posts()) : $my_query->the_post(); $id = get_the_ID();
		if (get_post_status ( $id ) == 'publish') {
	        //Gerente
	        $gerentearray = get_the_terms( $post->ID , 'Gerente' ); 
	        $gerente=$gerentearray[0]->name; 

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

	        if ( $pagina=='print') {
		        echo '<div class="row">';
				echo     '<div class="col-md-2 col-sm-2 col-xs-3"><h4 class="margintop0 marginbot0">'.$cantidad.'</h4></div>';
				echo     '<div class="col-md-2 col-sm-2 col-xs-3"><h4 class="margintop0 marginbot0">'.$producto.'</h4></div>';
				echo     '<div class="col-md-2 col-sm-2 col-xs-3"><h4 class="margintop0 marginbot0">Bsf '.number_format($costo, 2, ',', '.').'</h4></div>';
				echo     '<div class="col-md-2 col-sm-2 col-xs-3"><h4 class="margintop0 marginbot0">Bsf '.number_format($preciototal, 2, ',', '.').'</h4></div>';
				echo '</div>';
	        } else {
		        echo '<div class="row margintop10">';
			    echo   	'<div class="col-md-2 col-sm-2 hidden-xs"></div>';
				echo     '<div class="col-md-2 col-sm-2 col-xs-6">'.$producto.'</div>';
				echo     '<div class="col-md-2 col-sm-2 col-xs-6">'.$cantidad.'</div>';
				echo     '<div class="col-md-2 col-sm-2 col-xs-6">Bsf '.number_format($costo, 2, ',', '.').'</div>';
				echo     '<div class="col-md-2 col-sm-2 col-xs-6">Bsf '.number_format($preciototal, 2, ',', '.').'</div>';
				echo '</div>'; 
			}
		}
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