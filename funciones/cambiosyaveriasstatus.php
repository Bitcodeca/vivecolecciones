<?php
	$id=$_POST['id'];
	$btn=$_POST['btncya'];

	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");

	if ($btn=='Aprobar') {

		$sql = "UPDATE cambios SET status='aprobado' WHERE id=$id";
		mysqli_query($con, $sql);
		mysqli_close($con);

	} elseif ($btn=='Pendiente') {

		$sql = "UPDATE cambios SET status='pendiente' WHERE id=$id";
		mysqli_query($con, $sql);
		mysqli_close($con);

	} elseif ($btn=='Negar') {

		$sql = "UPDATE cambios SET status='negado' WHERE id=$id";
		mysqli_query($con, $sql);
		mysqli_close($con);

	} elseif ($btn=='Eliminar') {

		$sql = "DELETE FROM cambios WHERE id=$id";
		mysqli_query($con, $sql);
		mysqli_close($con);

	}
?>