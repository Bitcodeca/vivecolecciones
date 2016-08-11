<?php
	$fecha=$_POST['fecha'];
	$banco=$_POST['banco'];
	$referencia=$_POST['referencia'];
	$monto=$_POST['monto'];
	$usuario=$_POST['usuario'];
    $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");

    $query = mysqli_query($con, "SELECT * FROM registro WHERE fecha='".$fecha."' AND monto='".$monto."' AND banco LIKE '%".$banco."%' AND cliente='".$usuario."'");
	if(!mysqli_fetch_array($query)) {

			$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','pendiente')");
			$status='pendiente';
			mysqli_query($con,$c);

				
	}else{
			$status='negada';

		}
	mysqli_close($con);
?>