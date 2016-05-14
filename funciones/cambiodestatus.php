<?php
	$id=$_POST['id'];
	$btn=$_POST['btn'];

	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");

	if ($btn=='Aprobar') {

		$sql = "UPDATE registro SET status='aprobado' WHERE id=$id";
		mysqli_query($con, $sql);
		mysqli_close($con);

	} elseif ($btn=='Pendiente') {

		$sql = "UPDATE registro SET status='pendiente' WHERE id=$id";
		mysqli_query($con, $sql);
		mysqli_close($con);

	} elseif ($btn=='Negar') {

		$sql = "UPDATE registro SET status='negada' WHERE id=$id";
		mysqli_query($con, $sql);
		mysqli_close($con);

	} elseif ($btn=='Eliminar') {

		$sql = "DELETE FROM registro WHERE id=$id";
		mysqli_query($con, $sql);
		mysqli_close($con);

	} elseif ($btn=='Editar') {

		$fechaeditada=$_POST['fecha'.$id];
		$sql = "UPDATE registro SET fecha='$fechaeditada' WHERE id=$id";
		mysqli_query($con, $sql);
		mysqli_close($con);

	}
?>