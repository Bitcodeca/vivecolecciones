<?php
	$mysqli  = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $cam = $_GET['cam'];
        $art = $_GET['art'];
        $cos = $_GET['cos'];
        $ref = $_GET['ref'];

        if(!empty($cam)){
            $query = "SELECT * from vive_cam WHERE art='$art'";
    		$result = mysqli_query($mysqli, $query);
    		if(mysqli_num_rows($result) == 0) {
    
    			$query="INSERT INTO  vive_cam ( cam, art, cos, ref ) VALUES ( '$cam', '$art', '$cos', '$ref' )";
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