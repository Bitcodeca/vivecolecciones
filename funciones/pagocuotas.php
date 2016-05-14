<?php	
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

	if ($pagina=='inicio') {

		$totaldepositado=0;
		$totalaprobado=0;
		$totalpendiente=0;
		
		$result = mysqli_query($con, "SELECT * FROM registro WHERE status='aprobado'");
		while ($row = mysqli_fetch_array($result)) { $totalaprobado=$totalaprobado+$row['monto']; }

		$result = mysqli_query($con, "SELECT * FROM registro WHERE status='pendiente'");
		while ($row = mysqli_fetch_array($result)) { $totalpendiente=$totalpendiente+$row['monto'];}

		$totaldepositado=$totalaprobado+$totalpendiente;
	} else {

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
			$premioq1=$premioporcentajeq1*$incentivo;

			$premioporcentajeq2=$montoq2*$totalcantidad/$totaladepositarquincenal;
			$premioq2=$premioporcentajeq2*$incentivo;

			$premioporcentajeq3=$montoq3*$totalcantidad/$totaladepositarquincenal;
			$premioq3=$premioporcentajeq3*$incentivo;

			$premioporcentajeq4=$montoq4*$totalcantidad/$totaladepositarquincenal;
			$premioq4=$premioporcentajeq4*$incentivo;

			$premioporcentajetotal=$premioporcentajeq1+$premioporcentajeq2+$premioporcentajeq3+$premioporcentajeq4;
			$premiototal=$premioq1+$premioq2+$premioq3+$premioq4;
		}
	}

	
?>