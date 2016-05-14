<?php 
    //Por usuario
	//Inicializacion
	$totalcosto=0;$totalcantidad=0;
	while ($my_query->have_posts()) : $my_query->the_post(); $id = get_the_ID();
		if (get_post_status ( $id ) == 'publish') {
	        
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

		}
    endwhile;

	$d = DateTime::createFromFormat("d/m/Y", $fecha);
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c1=date_format($d,"d-m-Y");
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c2=date_format($d,"d-m-Y");
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c3=date_format($d,"d-m-Y");
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c4=date_format($d,"d-m-Y");


	$fechacambiada = DateTime::createFromFormat("d/m/Y", $fecha);
	$fechacambiada=date_format($fechacambiada,"d-m-Y");
	$fechaunix=strtotime($fechacambiada);
	$c1unix=strtotime($c1);
	$c2unix=strtotime($c2);
	$c3unix=strtotime($c3);
	$c4unix=strtotime($c4);

	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");

	if ($pagina=='reportes') { $usuariologged=$cliente; }
	
	$result = mysqli_query($con, "SELECT * FROM registro WHERE cliente='".$usuariologged."' AND status='aprobado'");
	$montoq1=0;
	$montoq2=0;
	$montoq3=0;
	$montoq4=0;
	$montosp=0;

	while ($row = mysqli_fetch_array($result)) {
		$fechadeposito=$row['fecha'];
		$montodeposito=$row['monto'];
		$fechadepositocambiada = DateTime::createFromFormat("d/m/Y", $fechadeposito);
		$fechadepositocambiada=date_format($fechadepositocambiada,"d-m-Y");
		$fechadepositounix=strtotime($fechadepositocambiada);

		//echo 'fecha '.$fecha.'<br>';
		//echo 'fecha unix '.$fechaunix.'<br>';
		//echo 'fecha post unix '.date("d-m-Y", $fechaunix).'<br><br>';

		if ($fechaunix <= $fechadepositounix && $fechadepositounix <= $c1unix){
			$montoq1=$montoq1+$montodeposito;
		}
		elseif ($c1unix < $fechadepositounix && $fechadepositounix <= $c2unix){
			$montoq2=$montoq2+$montodeposito;
		}
		elseif ($c2unix < $fechadepositounix && $fechadepositounix <= $c3unix){
			$montoq3=$montoq3+$montodeposito;
		}
		elseif ($c3unix < $fechadepositounix && $fechadepositounix <= $c4unix){
			$montoq4=$montoq4+$montodeposito;
		} 
		elseif ($fechadepositounix > $c4unix) { $montosp=$montosp+$montodeposito; }
	}
	$totaldepositado=$montoq1+$montoq2+$montoq3+$montoq4+$montosp;

	if ($totaladepositarquincenal==0) {
		$premioporcentajeq1=0;
		$premioq1=0;

		$premioporcentajeq2=0;
		$premioq2=0;

		$premioporcentajeq3=0;
		$premioq3=0;

		$premioporcentajeq4=0;
		$premioq4=0;

		$premioporcentajetotal=0;

		$premiototal=0;
	} else {
		$premioporcentajeq1=$montoq1*$totalcantidad/$totaladepositarquincenal;
		$premioq1=$premioporcentajeq1*1000;

		$premioporcentajeq2=$montoq2*$totalcantidad/$totaladepositarquincenal;
		$premioq2=$premioporcentajeq2*1000;

		$premioporcentajeq3=$montoq3*$totalcantidad/$totaladepositarquincenal;
		$premioq3=$premioporcentajeq3*1000;

		$premioporcentajeq4=$montoq4*$totalcantidad/$totaladepositarquincenal;
		$premioq4=$premioporcentajeq4*1000;

		$premioporcentajetotal=$premioporcentajeq1+$premioporcentajeq2+$premioporcentajeq3+$premioporcentajeq4;
		$premiototal=$premioq1+$premioq2+$premioq3+$premioq4;
	}

	//Ganancia del vendedor actual
	$totalvendedor=$gananciavendedor*$totalcantidad;

	//Total
	$total=$totalcosto-$totalvendedor;

	$debe=$total-$totaldepositado;
?>