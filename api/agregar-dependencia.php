<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


if (isset($_POST['ger']) && isset($_POST['sub']) ) {

    //check if any of the inputs are empty
    if (empty($_POST['ger']) || empty($_POST['sub'])) {
        $data = array('success' => false, 'message' => 'Por favor, seleccione los gerentes.');
        echo json_encode($data);
        exit;
    }

    require_once 'vive-db.php';
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $ger=$_POST['ger'];
        $sub=$_POST['sub'];

        if($ger==$sub){

            $data = array('success' => false, 'message' => 'El Subgerente no puede ser igual al Gerente');
            echo json_encode($data);

        } else {

            if ($result = $mysqli->query("SELECT * FROM vive_sub WHERE ger='$ger' AND sub='$sub'")) {
                $cant = mysqli_num_rows($result);
                if($cant==0){

                    $query="INSERT INTO  vive_sub ( ger, sub ) VALUES ( '$ger', '$sub' )";
                    if( $mysqli->query( $query ) ){ }
                    else{
                        $data = array('success' => false, 'message' => 'Error al escribir');
                        echo json_encode($data);
                        exit();
                    }
                    $data = array('success' => true, 'message' => 'Se ha agregado correctamente');
                    echo json_encode($data);

                }
                else {

                    $data = array('success' => false, 'message' => 'Ya existe la dependencia');
                    echo json_encode($data);

                }
            }

        }

        exit();
        $mysqli->close();
    }

} else {
    $data = array('success' => false, 'message' => 'Por favor, seleccione los gerentes');
    echo json_encode($data);
}
?>