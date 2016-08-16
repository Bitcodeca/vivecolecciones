<?php
	$fecha=$_POST['fecha'];
	$cliente=$_POST['cliente'];
	$coleccion=$_POST['coleccion'];
	$cantidad=$_POST['cantidad'];

    $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$c=("INSERT INTO devoluciones (cliente,fecha,coleccion,cantidad) VALUES ('$cliente','$fecha','$coleccion','$cantidad')");
	mysqli_query($con,$c);
	mysqli_close($con);
?>