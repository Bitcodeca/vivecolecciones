<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


if (isset($_POST['nombre']) && isset($_POST['cedula']) && isset($_POST['localidad']) && isset($_POST['comentario']) ) {

    require_once 'vive-db.php';
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $nombre=$_POST['nombre'];
        $cedula=$_POST['cedula'];
        $localidad=$_POST['localidad'];
        $comentario=$_POST['comentario'];
        $cliente=$_POST['usuario'];
        $fecha=date("d/m/Y");

        $stmt = $mysqli->prepare("INSERT INTO vive_den ( usuario, ced, loc, obs, den, fec ) VALUES ( ?, ?, ?, ?, ?, ? )");
        $stmt->bind_param("ssss", $cliente, $cedula, $localidad, $comentario, $nombre, $fecha);
        $stmt->execute();
        $stmt->close();

        else{
            $data = array('success' => false, 'message' => 'error al escribir');
            echo json_encode($data);
            exit();
        }
        $data = array('success' => true, 'message' => 'escribio');
        echo json_encode($data);
        exit();
        $mysqli->close();
    }

} else {
    $data = array('success' => false, 'message' => 'Por favor, agregue un producto.');
    echo json_encode($data);
}