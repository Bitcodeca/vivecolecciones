<?php
    $mysqli  = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $usuario = $_POST['usuario'];
        $art = $_POST['art'];
        $mot = $_POST['mot'];
        $des = $_POST['des'];
        $can = $_POST['can'];
        $esp = $_POST['esp'];
        $fecha=date("d/m/Y");


        if(!empty($usuario) && !empty($art) && !empty($mot) && !empty($des) && !empty($can) && !empty($esp) ){

            $stmt = $mysqli->prepare("INSERT INTO vive_cya ( usuario, fec, art, mot, des, can, esp, status ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )");
            $stmt->bind_param("ssssssss", $usuario, $fecha, $art, $mot, $des, $can, $esp, $status);
            $stmt->execute();            
            
            $x=0;
            $y=0;
            while($y==0){
                if(isset($_POST['art'.$x]) && isset($_POST['mot'.$x]) && isset($_POST['des'.$x]) && isset($_POST['can'.$x]) && isset($_POST['esp'.$x]) ){

                    if(!empty($_POST['art'.$x]) && !empty($_POST['mot'.$x]) && !empty($_POST['des'.$x]) && !empty($_POST['can'.$x]) && !empty($_POST['esp'.$x]) ){
                        $art = $_POST['art'.$x];
                        $mot = $_POST['mot'.$x];
                        $des = $_POST['des'.$x];
                        $can = $_POST['can'.$x];
                        $esp = $_POST['esp'.$x];
                        
                        $stmt->bind_param("ssssssss", $usuario, $fecha, $art, $mot, $des, $can, $esp, $status);
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