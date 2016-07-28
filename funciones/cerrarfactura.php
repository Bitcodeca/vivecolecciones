<?php 
	$fechainicierre=$_POST['fechainicierre'];
	$fechafincierre=$_POST['fechafincierre'];
	$clientecierre=$_POST['cliente'];
	$montocierre=$_POST['montocierre'];
	$comentario=$_POST['comentario'];

	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");

	$sql = "INSERT INTO historial (fechaini,fechafin,cliente,monto,comentario) VALUES ('$fechainicierre','$fechafincierre','$clientecierre','$montocierre','$comentario')";
	mysqli_query($con, $sql);

	$sql = "DELETE FROM registro WHERE cliente='$clientecierre'";
	mysqli_query($con, $sql);
	mysqli_close($con);

?>