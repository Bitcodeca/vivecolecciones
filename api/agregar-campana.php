<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


if (isset($_POST['cam']) && isset($_POST['art0']) && isset($_POST['gven']) && isset($_POST['pbas']) && isset($_POST['dis']) && isset($_POST['ger']) && isset($_POST['q1']) && isset($_POST['q2'])) {

    //check if any of the inputs are empty
    if (empty($_POST['cam']) || empty($_POST['art0'])) {
        $data = array('success' => false, 'message' => 'Por favor, agregue un producto.');
        echo json_encode($data);
        exit;
    }

    // global $wpdb;
    // $result = $wpdb->get_results('SELECT * FROM wp_posts LIMIT 10');
    // $wpdb->query("INSERT INTO  $wpdb->postmeta ( post_id, meta_key, meta_value ) VALUES ( $post_id, $meta_key, $meta_value )" );
    // $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s", $post_id, $key ) );
    // $wpdb->insert( 'vive_con', array( 'cam' => $_POST['cam'], 'gven' => $_POST['gven'], 'pbas' => $_POST['pbas'], 'dis' => $_POST['dis'], 'ger' => $_POST['ger'], 'q1' => $_POST['q1'], 'q2' => $_POST['q2'], 'q3' => $_POST['q3'] ) );
    require_once 'vive-db.php';
    if (mysqli_connect_errno()) {
        $data = array('success' => false, 'message' => 'error de conexion');
        echo json_encode($data);
        exit();
    } else {
        $cam=$_POST['cam'];
        $gven=$_POST['gven'];
        $pbas=$_POST['pbas'];
        $dis=$_POST['dis'];
        $ger=$_POST['ger'];
        $q1=$_POST['q1'];
        $q2=$_POST['q2'];
        $query="INSERT INTO  vive_con ( cam, gven, pbas, dis, ger, q1, q2 ) VALUES ( $cam, $gven, $pbas, $dis, $ger, $q1, $q2 )";
        if( $mysqli->query( $query ) ){
            $x=0;
            $i=0;
            while ($x=='0') {
                if(isset($_POST['art'.$i]) && !empty($_POST['art'.$i])){
                    $art=$_POST['art'.$i];
                    $cos=$_POST['cos'.$i];
                    $ref=$_POST['ref'.$i];
                $query2="INSERT INTO  vive_cam ( cam, art, cos, ref ) VALUES ( '$cam', '$art', '$cos', '$ref' )";
                if( $mysqli->query( $query2 ) ){}
                    $i++;
                } else {
                    $x++;
                }
            }

            $x=0;
            $i=0;
            while ($x=='0') {
                if(isset($_POST['premio'.$i]) && !empty($_POST['tipo'.$i])){
                    $art=$_POST['premio'.$i];
                    $tip=$_POST['tipo'.$i];
                    $query3="INSERT INTO  vive_pre ( cam, articulo, tipo ) VALUES ( '$cam', '$art', '$tip' )";
                    if( $mysqli->query( $query3 ) ){}
                    $i++;
                } else {
                    $x++;
                }
            }


        }
        else{
            $data = array('success' => false, 'message' => 'error al escribir');
            echo json_encode($data);
            exit();
        }
        $data = array('success' => true, 'message' => 'Campaña exitosamente agregada');
        echo json_encode($data);
        exit();
        $mysqli->close();
    }

} else {
    $data = array('success' => false, 'message' => 'Por favor, agregue un producto.');
    echo json_encode($data);
}