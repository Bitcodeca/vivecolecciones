<?php
	$mysqli  = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {

        $stmt2 = $mysqli->prepare("TRUNCATE TABLE vive_dev_con");
        $stmt2->execute();
        $stmt2->close();

        $mysqli->close();
        exit();

    }

?>