<?php
	$mysqli  = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $total = $_POST['total'];
        $usuario= $_POST['usuario'];
        $cam=$_POST['cam'];


        $stmt = $mysqli->prepare("DELETE FROM vive_fac_prem WHERE usuario = ? AND cam = ?");
        $stmt->bind_param("ss", $usuario, $cam);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("INSERT INTO vive_fac_prem ( usuario, cam, nombre, cantidad ) VALUES ( ?, ?, ?, ? )");
        /*
        if(isset($_POST['efectivo'])){
            if(!empty($_POST['efectivo'])){

                $nombre='Premio Efectivo';
                $can=$_POST['efectivo'];

                $stmt->bind_param("ssss", $usuario, $cam, $nombre, $can);
                $stmt->execute();

            }
        }
        */

        for ($i = 0; $i <$total; $i++) {
            if(isset($_POST['premio'.$i]) && isset($_POST['nombre'.$i]) ){
                if(!empty($_POST['premio'.$i]) && !empty($_POST['nombre'.$i]) ){
                    
                    $nombre=$_POST['nombre'.$i];
                    $can=$_POST['premio'.$i];

                    $stmt->bind_param("ssss", $usuario, $cam, $nombre, $can);
                    $stmt->execute();

                }
            }
        }
        
        $stmt->close();

        $data = array('success' => false, 'message' => 'GRABADO');
        echo json_encode($data);

        $mysqli->close();
        exit();

    }

?>