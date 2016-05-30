<?php
	$fecha=$_POST['fecha'];
	$banco=$_POST['banco'];
	$referencia=$_POST['referencia'];
	$monto=$_POST['monto'];
	$usuario=$_POST['usuario'];
    $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");

    $query = mysqli_query($con, "SELECT * FROM volatil WHERE fecha='".$fecha."' AND monto='".$monto."' AND banco LIKE '%".$banco."%'");
	if(!mysqli_fetch_array($query)) {

		$d = mysqli_query($con, "SELECT * FROM registro WHERE referencia='".$referencia."' AND banco='".$banco."' AND fecha='".$fecha."' AND monto='".$monto."'");
		if(mysqli_num_rows($d) > 0){

			$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','negada')");
			$status='negada';
			mysqli_query($con,$c);

		}else{

			//$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','pendiente')");
			$status='pendiente';
			//mysqli_query($con,$c);

		}
				
	}else{

		$d = mysqli_query($con, "SELECT * FROM registro WHERE referencia='".$referencia."' AND banco='".$banco."' AND fecha='".$fecha."' AND monto='".$monto."'");
		if(mysqli_num_rows($d) > 0){

			$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','negada')");
			$status='negada';
			mysqli_query($con,$c);

		}else{


	    	$query = mysqli_query($con, "SELECT * FROM volatil WHERE fecha='".$fecha."' AND banco='".$banco."' AND monto='".$monto."' AND referencia='".$referencia."' LIMIT 1");
	    	if(mysqli_num_rows($query) > 0){
				
				$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','aprobado')");
				$status='aprobado';
				mysqli_query($con,$c);

			} else {

				//$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','pendiente')");
				$status='pendiente';
				//mysqli_query($con,$c);

			}
		}
	}

	mysqli_close($con);
?>