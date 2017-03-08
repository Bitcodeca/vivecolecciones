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

            $stmt = $mysqli->prepare("SELECT usuario, id FROM vive_dep WHERE banco=? AND fecha=? AND referencia=? AND monto=?");
            $stmt->bind_param("ssss", $ban, $fec, $ref, $mon);
            $stmt->execute();
            $stmt->bind_result($query_usuario, $id);
            $stmt->store_result();
            $numberofrows = $stmt->num_rows;
            if($numberofrows>0){
                while($stmt->fetch()){
                    if($query_usuario=='vacio'){                        
                        $status='aprobado';
                        $stmt_ORDER = $mysqli->prepare("UPDATE vive_dep SET usuario=?, cam=?, status=? WHERE id=?");
                        $stmt_ORDER->bind_param("ssss", $usuario, $cam, $status, $id);
                        $stmt_ORDER->execute();

                        $stmt_ORDER->close();

                        $data = array('success' => true, 'message' => 'Depósito aprobado');
                        echo json_encode($data);
                    }
                    /////////////////////////////////////////////////////////////////
                    //////            SI YA ESTA OCUPADO EL DEPOSITO          //////
                    ///////////////////////////////////////////////////////////////
                    else {
                        $data = array('success' => false, 'message' => 'El depósito no es válido, puede ya estar registrado');
                        echo json_encode($data);
                    }
                }
            }

            /////////////////////////////////////////////////////////////////
            //////                SI NO ESTA EN LA BD                 //////
            ///////////////////////////////////////////////////////////////
            else {
                $data = array('success' => false, 'message' => 'Depósito no registrado correctamente. Registrarlo en depósitos problemas');
                echo json_encode($data);
            }
            $stmt->close();
        }
        else {
                $data = array('success' => false, 'message' => 'Llene todos los campos');
                echo json_encode($data);
        }
        $mysqli->close();
        exit();

    }

?>