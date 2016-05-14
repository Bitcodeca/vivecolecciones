<?php
	$fecha=$_POST['fecha'];
	$banco=$_POST['banco'];
	$referencia=$_POST['referencia'];
	$monto=$_POST['monto'];
	$usuario=$_POST['usuario'];
    $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
    $query = mysqli_query($con, "SELECT * FROM volatil WHERE fecha='".$fecha."' AND banco LIKE '%".$banco."%'");

	if(!mysqli_fetch_array($query)) {

			$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','pendiente')");
			$status='pendiente';
			mysqli_query($con,$c);
				
	}else {
    	$query = mysqli_query($con, "SELECT * FROM volatil WHERE fecha='".$fecha."' AND banco LIKE '%".$banco."%'");
	    while ($row = mysqli_fetch_array($query)){
			$refbanco=$row['banco'];
			$reffecha=$row['fecha'];
			$refreferencia=$row['referencia'];
			$refmonto=$row['monto'];

			if ($reffecha==$fecha && $refbanco==$banco && $refmonto==$monto) {

				if ($refreferencia==$referencia) {

					$q = mysqli_query($con, "SELECT * FROM registro WHERE referencia='".$referencia."' AND banco LIKE '%".$banco."%' AND fecha='".$fecha."' LIMIT 1");
					$r = mysqli_num_rows($q);

	    			if ($r>='1'){		

						$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','negada')");
						$status='negada';
						mysqli_query($con,$c);

					} else {

						$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','aprobado')");
						$status='aprobado';
						mysqli_query($con,$c);

					} 

				} elseif ($refreferencia!=$referencia){

					$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','pendiente')");
					$status='pendiente';
					mysqli_query($con,$c);

				}
			} else {

				$c=("INSERT INTO registro (fecha,banco,referencia,monto,cliente,status) VALUES ('$fecha','$banco','$referencia','$monto','$usuario','pendiente')");
				$status='pendiente';
				mysqli_query($con,$c);
					
			}
		}
	}
	mysqli_close($con);
?>