<?php
	$mysqli  = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $usuario = $_GET['usuario'];
        $logged = $_GET['logged'];
        $msn = $_GET['msn'];

        $stmt = $mysqli->prepare("INSERT INTO  vive_msn ( ini, fin, msn ) VALUES ( ?, ?, ? )");
        $stmt->bind_param("sss", $logged, $usuario, $msn);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("SELECT id FROM vive_msn WHERE (ini=? AND fin=?) OR (ini=? AND fin=?)");
        $stmt->bind_param("ssss", $usuario, $logged, $logged, $usuario);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->store_result();
        $numberofrows = $stmt->num_rows;
        if($numberofrows>=21){
            $borrar=$numberofrows-20;
            $stmt_ORDER = $mysqli->prepare("DELETE FROM vive_msn WHERE (ini=? AND fin=?) OR (ini=? AND fin=?) ORDER BY id asc limit $borrar");
            $stmt_ORDER->bind_param("ssss", $usuario, $logged, $logged, $usuario);
            $stmt_ORDER->execute();
            $stmt_ORDER->close();
        }
        $stmt->close();



        $data = array('success' => true, 'message' => 'correcto');
        echo json_encode($data);
            
        $mysqli->close();
        exit();

    }

?>