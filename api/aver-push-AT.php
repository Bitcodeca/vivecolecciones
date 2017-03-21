<?php
	$mysqli  = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {


        $stmt0 = $mysqli->prepare("SELECT DISTINCT usuario FROM vive_fac");
        $stmt0->execute();
        $stmt0->bind_result($usuario);
        $stmt0->store_result();
        while ($stmt0->fetch()) {
            $stmt1 = $mysqli->prepare("SELECT usuario, id FROM vive_averia_con WHERE usuario=?");
            $stmt1->bind_param("s", $usuario);
            $stmt1->execute();
            $stmt1->bind_result($query_usuario, $id);
            $stmt1->store_result();
            $numberofrows = $stmt1->num_rows;
            if($numberofrows==0){

                $stmt2 = $mysqli->prepare("INSERT INTO  vive_averia_con ( usuario ) VALUES ( ? )");
                $stmt2->bind_param("s", $usuario);
                $stmt2->execute();
                $stmt2->close();

            }
        }
        $stmt0->close();
                                
        $mysqli->close();
        exit();

    }

?>