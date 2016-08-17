<?php
	$fecha=$_POST['fecha'];
	$cliente=$_POST['cliente'];
	$nombre=$_POST['nombre'];
	$localidad=$_POST['localidad'];
	$message=$_POST['message'];
	$cedula=$_POST['cedula'];
    $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");

    $query = mysqli_query($con, "SELECT * FROM denuncias WHERE nombre='".$nombre."' AND localidad='".$localidad."' ");
	if(!mysqli_fetch_array($query)) {

    		$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
			$c=("INSERT INTO denuncias (fecha,cliente,nombre,localidad,observacion,cedula) VALUES ('$fecha','$cliente','$nombre','$localidad','$message','$cedula')");
			$status='aprobado';
			mysqli_query($con,$c);

				
	}else{
			$status='negada';

		}
	mysqli_close($con);
?>