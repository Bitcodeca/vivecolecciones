<?php
	$mysqli  = new mysqli("localhost","adbddvc280118","cdadbddvc280118","vivebdd280118");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $id = $_GET['id'];

        $query = "DELETE FROM vive_cambio_con WHERE id='$id'";
		if ($mysqli->query( $query ) === TRUE) { }
        $mysqli->close();
        exit();

    }

?>