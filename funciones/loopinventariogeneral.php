<?php 
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$finalmonto=0;
	$finalcantidad=0;
	$finalaprobado=0;
	$finaltotalacancelar=0;
	$todoslosusuarios = get_users();
	foreach ( $todoslosusuarios as $user ) {
		$buscar=$user->user_login;
	 	$args=array('post_status' => 'publish', 'post_type'=> 'post',  'order' => 'ASC', 'posts_per_page' => -1, 'tax_query' => array( array(  'taxonomy' => 'Gerente', 'field' => 'slug', 'terms' => $buscar ) ) ); $my_query = new WP_Query($args);
	    if( $my_query->have_posts() ) { $totalcosto=0;$totalcantidad=0;
			$totalcosto=0;$totalcantidad=0;$x=0;
			while ($my_query->have_posts()) : $my_query->the_post(); $id = get_the_ID();

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

		        echo '<div class="row margintop25 text-center"> 
				     	<div class="col-md-2 col-sm-2 col-xs-4 finalinventario">'.$gerente.'</div> 
				     	<div class="col-md-2 col-sm-2 col-xs-4">'.$producto.'</div>
				     	<div class="col-md-2 col-sm-2 col-xs-4">'.$cantidad.'</div>
				     	<div class="col-md-3 col-sm-3 col-xs-6">Bsf '.number_format($costo, 2, ',', '.').'</div>
				     	<div class="col-md-3 col-sm-3 col-xs-6">Bsf '.number_format($preciototal, 2, ',', '.').'</div> 
			     	</div>'; 

				
		    endwhile;
		    $monto=0;
			$result = mysqli_query($con, "SELECT * FROM registro WHERE cliente='".$buscar."' AND status='aprobado'");
			while ($row = mysqli_fetch_array($result)) {
				$monto=$row['monto']+$monto;
			}
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

			$finalmonto=$finalmonto+$totalcosto;

			$finalcantidad=$finalcantidad+$totalcantidad;

			$finalaprobado=$finalaprobado+$monto;

			$finaltotalacancelar=$totalacancelar+$finaltotalacancelar;

			echo '<div class="row finalinventario bordertopnegro borderbotnegro">
	    			<div class="col-md-4 col-sm-4 col-xs-12"><h4>Total: '.$totalcantidad.'</h4></div>
	    			<div class="col-md-4 col-sm-4 col-xs-12"><h4>Saldo Aprobado Bsf '.number_format($monto, 2, ',', '.').'</h4></div>
	    			<div class="col-md-4 col-sm-4 col-xs-12"><h4>Saldo Deudor Total Bsf '.number_format($totalacancelar, 2, ',', '.').'</h4></div>
	    		</div>';

		} wp_reset_query();
	}
	echo '<div class="row finalinventario bordertopnegro borderbotnegro">
	    			<div class="col-md-4 col-sm-4 col-xs-12"><h4>Total Entregado: '.$finalcantidad.'</h4></div>
	    			<div class="col-md-4 col-sm-4 col-xs-12"><h4>Total Aprobado Bsf '.number_format($finalaprobado, 2, ',', '.').'</h4></div>
	    			<div class="col-md-4 col-sm-4 col-xs-12"><h4>Total Invertido Bsf '.number_format($finaltotalacancelar, 2, ',', '.').'</h4></div>
	    		</div>';
?>