<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	$login=$_GET['usuario'];

	$conn = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
	$query = "SELECT * from wp_usermeta WHERE meta_value='$login'";
	$result = mysqli_query($conn, $query);

	if(mysqli_num_rows($result) != 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$id=$row['user_id'];
		}
	}

	$query = "SELECT * from wp_usermeta WHERE user_id='$id' AND meta_key='first_name'";
	$result = mysqli_query($conn, $query);
	if(mysqli_num_rows($result) != 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$nombre=$row['meta_value'];
		}
	}
	$query = "SELECT * from wp_usermeta WHERE user_id='$id' AND meta_key='last_name'";
	$result = mysqli_query($conn, $query);
	if(mysqli_num_rows($result) != 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$apellido=$row['meta_value'];
		}
	}

	$query = "SELECT * from wp_usermeta WHERE user_id='$id' AND meta_key='profile_photo'";
	$result = mysqli_query($conn, $query);

	if(mysqli_num_rows($result) != 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$foto=$row['meta_value'];
		}
	}
	else { $foto='vacio'; }

	$outp = "";
    if ($outp != "") {$outp .= ",";}

    $outp .= '{"Avatar":"'.$row['id'].'",';
	$outp .= '"ID":"'.$id.'",';
	$outp .= '"Fotourl":"'.$foto.'",';
	$outp .= '"Apellido":"'.$apellido.'",';
    $outp .= '"Nombre":"'.$nombre.'"}';
  	

	$outp ='{"records2":['.$outp.']}';

	$conn->close();
	echo($outp);

?>