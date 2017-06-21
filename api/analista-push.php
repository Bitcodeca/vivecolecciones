<?php
	$mysqli  = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $analista = $_GET['analista'];
        $gerente = $_GET['gerente'];

        if(!empty($gerente)){
	        $query = "SELECT * from vive_analista WHERE gerente='$gerente'";
			$result = mysqli_query($mysqli, $query);
			if(mysqli_num_rows($result) == 0) {

				$query="INSERT INTO  vive_analista ( analista, gerente ) VALUES ( '$analista', '$gerente' )";
		        if( $mysqli->query( $query ) ){
		            $data = array('success' => true, 'message' => 'Agregado');
		            echo json_encode($data);
		        }
		        else{
		            $data = array('success' => false, 'message' => 'error al escribir');
		            echo json_encode($data);
		        }

			}
			else{
		            $data = array('success' => false, 'message' => 'Ya está agregado');
		            echo json_encode($data);
		        }
		}
        $mysqli->close();
        exit();

    }

?>