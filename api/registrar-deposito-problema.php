<?php
    $mysqli  = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $usuario = $_GET['usuario'];
        $fec = $_GET['fec'];
        $cam = $_GET['cam'];
        $ban = $_GET['ban'];
        $ref = $_GET['ref'];
        $mon = $_GET['mon'];

        if(!empty($usuario) && !empty($fec) && !empty($cam) && !empty($ban) && !empty($ref) && !empty($mon) ){

            ////////////////////////////////////////////////////////////////////////////////////////////////////
            //////                CHEQUEA SI EXISTE EL DEPOSITO EN LA BD Y SI ESTA VACIO                 //////
            //////////////////////////////////////////////////////////////////////////////////////////////////

            $stmt = $mysqli->prepare("SELECT id FROM vive_pen WHERE usuario=? AND banco=? AND fecha=? AND referencia=? AND monto=?");
            $stmt->bind_param("sssss", $usuario, $ban, $fec, $ref, $mon);
            $stmt->execute();
            $stmt->bind_result($id);
            $stmt->store_result();
            $numberofrows = $stmt->num_rows;
            if($numberofrows==0){                       
                    $status='Pendiente';
                    $stmt_ORDER = $mysqli->prepare("INSERT INTO vive_pen ( usuario, banco, fecha, referencia, monto, status, cam ) VALUES ( ?, ?, ?, ?, ?, ?, ? )");
                    $stmt_ORDER->bind_param("sssssss", $usuario, $ban, $fec, $ref, $mon, $status, $cam);
                    $stmt_ORDER->execute();

                    $stmt_ORDER->close();

                    $data = array('success' => true, 'message' => 'REGISTRADO');
                    echo json_encode($data);
            }

            /////////////////////////////////////////////////////////////////
            //////                SI NO ESTA EN LA BD                 //////
            ///////////////////////////////////////////////////////////////
            else {
                $data = array('success' => false, 'message' => 'REPETIDO');
                echo json_encode($data);
            }
            $stmt->close();
        }
        else {
                $data = array('success' => false, 'message' => 'CAMPO VACIO');
                echo json_encode($data);
        }
        $mysqli->close();
        exit();

    }

?>