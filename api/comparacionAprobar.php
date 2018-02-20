<?php
	$mysqli  = new mysqli("localhost","adbddvc280118","cdadbddvc280118","vivebdd280118");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $usuario = $_GET['usuario'];
        $penId = $_GET['penId'];
        $depId = $_GET['depId'];
        $penCam = $_GET['penCam'];

        $status='aprobado';
        $stmt_ORDER = $mysqli->prepare("UPDATE vive_dep SET usuario=?, cam=?, status=? WHERE id=?");
        $stmt_ORDER->bind_param("ssss", $usuario, $penCam, $status, $depId);
        $stmt_ORDER->execute();
        $stmt_ORDER->close();

        $stmt = $mysqli->prepare("DELETE FROM vive_pen WHERE id=?");
        $stmt->bind_param("s", $penId);
        $stmt->execute();
        $stmt->close();

        $data = array('success' => true, 'message' => 'correcto');
        echo json_encode($data);
            
        $mysqli->close();
        exit();

    }

?>