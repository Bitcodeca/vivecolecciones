<?php
    $mysqli  = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $usuario = $_POST['usuario'];
        $art = $_POST['art'];
        $can = $_POST['can'];
        $fecha=date("d/m/Y");


        if(!empty($usuario) && !empty($art) && !empty($can)){

            $stmt = $mysqli->prepare("INSERT INTO vive_averia ( usuario, fecha, art, can ) VALUES ( ?, ?, ?, ? )");
            $stmt->bind_param("ssss", $usuario, $fecha, $art, $can);
            $stmt->execute();            
            
            $x=0;
            $y=0;
            while($y==0){
                if(isset($_POST['art'.$x]) && isset($_POST['can'.$x]) ){

                    if(!empty($_POST['art'.$x]) && !empty($_POST['can'.$x]) ){
                        $art = $_POST['art'.$x];
                        $can = $_POST['can'.$x];
                        
                        $stmt->bind_param("ssss", $usuario, $fecha, $art, $can);
                        $stmt->execute();
                    }
                }
                else{
                    $y++;
                }
                $x++;
            }
            
            $stmt->close();
            $data = array('success' => true, 'message' => 'REGISTRADO');
            echo json_encode($data);

        }
        else {
                $data = array('success' => false, 'message' => 'CAMPO VACIO');
                echo json_encode($data);
        }
        $mysqli->close();
        exit();

    }

?>