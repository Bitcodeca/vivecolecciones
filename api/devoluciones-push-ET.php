<?php
	$mysqli  = new mysqli("localhost","adbddvc280118","cdadbddvc280118","vivebdd280118");
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