<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '/home1/bitcodeweb/public_html/wp-content/themes/metroacero/phpmailer/PHPMailerAutoload.php';



if (!empty( $_POST['pagina'] ) && $_POST['pagina'] == "nueva_orden"){
    $title     = $_POST['asunto'];
    $content   = $_POST['description'];
    $post_type = 'post';
    $categoria = 'orden-de-compra';
    $dirigido = $_POST['dirigido'];
    $nombredirigido = $_POST['nombredirigido'];
  /*  $new_post = array(
        'post_title'    => $title,
        'post_content'  => $content,
        'post_status'   => 'pending',          
        'post_type'     => $post_type 
    );
    $pid = wp_insert_post($new_post);
    wp_set_object_terms( $pid, $categoria, 'category');
    wp_set_object_terms( $pid, $dirigido, 'status' );*/



    if (isset($_POST['asunto']) && isset($_POST['description']) && isset($_POST['dirigido'])) {

        //check if any of the inputs are empty
        if (empty($_POST['asunto']) || empty($_POST['description']) || empty($_POST['dirigido'])) {
            $data = array('success' => false, 'message' => 'Please fill out the form completely.');
            echo json_encode($data);
            exit;
        }
        
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->From = 'intranet@metroacero.com';
        $mail->FromName = 'nombre';
        $mail->AddAddress('fcastillo90@gmail.com');
        $mail->Subject ='Intranet Metroacero - NOTIFICACION';
        $mail->Body    = $title;
        $mail->AltBody = 'Prueba';
        
        if(!$mail->send()) {
            $data = array('success' => false, 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
            echo json_encode($data);
            exit;
        }

        $data = array('success' => true, 'message' => 'enviado');
        echo json_encode($data);

    } else {
        $data = array('success' => false, 'message' => 'Por favor, termine de llenar el formulario.');
        echo json_encode($data);
    }




}


