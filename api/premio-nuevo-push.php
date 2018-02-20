<?php
	$mysqli  = new mysqli("localhost","adbddvc280118","cdadbddvc280118","vivebdd280118");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $cam = $_GET['cam'];
        $art = $_GET['art'];
        $tipo = $_GET['tipo'];

        if(!empty($cam)){
            $query = "SELECT * from vive_pre WHERE articulo='$art'";
    		$result = mysqli_query($mysqli, $query);
    		if(mysqli_num_rows($result) == 0) {
    
    			$query="INSERT INTO  vive_pre ( cam, articulo, tipo ) VALUES ( '$cam', '$art', '$tipo' )";
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