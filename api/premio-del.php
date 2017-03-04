<?php
	$mysqli  = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $id = $_GET['id'];

        $query = "DELETE FROM vive_pre_con WHERE id='$id'";
		if ($mysqli->query( $query ) === TRUE) { }
        $mysqli->close();
        exit();

    }

?>