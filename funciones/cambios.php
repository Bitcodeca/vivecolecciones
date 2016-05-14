<?php
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$fecha=date("Y/m/d");
	$status='pendiente';
	$message='';

	if(isset($_POST['coleccion1'])) {
		if (!empty($_POST['coleccion1'])) {
			$coleccion1=$_POST['coleccion1'];
			$motivo1=$_POST['motivo1'];
			$descripcion1=$_POST['descripcion1'];
			$cantidad1=$_POST['cantidad1'];
			$tipo1=$_POST['tipo1'];
			$especifique1=$_POST['especifique1'];

			$message=' Coleccion: '.$coleccion1.' 
			Motivo: '.$motivo1.'
			Descripción: '.$descripcion1.'
			Cantidad: '.$cantidad1.' 
			Tipo: '.$tipo1.'
			Especifique: '.$especifique1.'
			
			'.$message;

			$c=("INSERT INTO cambios (fecha,cliente,coleccion,motivo,descripcion,cantidad,tipo,especifique,status) VALUES ('$fecha','$usuariologged','$coleccion1','$motivo1','$descripcion1','$cantidad1','$tipo1','$especifique1','pendiente')");
			mysqli_query($con,$c);	
		}
	}
	if(isset($_POST['coleccion2'])) {
		if (!empty($_POST['coleccion2'])) {
			$coleccion2=$_POST['coleccion2'];
			$motivo2=$_POST['motivo2'];
			$descripcion2=$_POST['descripcion2'];
			$cantidad2=$_POST['cantidad2'];
			$tipo2=$_POST['tipo2'];
			$especifique2=$_POST['especifique2'];

			$message=' Coleccion: '.$coleccion2.'
			Motivo: '.$motivo2.'
			Descripción: '.$descripcion2.'
			Cantidad: '.$cantidad2.' 
			Tipo: '.$tipo2.' 
			Especifique: '.$especifique2.'

			'.$message;

			$c=("INSERT INTO cambios (fecha,cliente,coleccion,motivo,descripcion,cantidad,tipo,especifique,status) VALUES ('$fecha','$usuariologged','$coleccion2','$motivo2','$descripcion2','$cantidad2','$tipo2','$especifique2','pendiente')");
			mysqli_query($con,$c);
		}
	}
	if(isset($_POST['coleccion3'])) {
		if (!empty($_POST['coleccion3'])) {
			$coleccion3=$_POST['coleccion3'];
			$motivo3=$_POST['motivo3'];
			$descripcion3=$_POST['descripcion3'];
			$cantidad3=$_POST['cantidad3'];
			$tipo3=$_POST['tipo3'];
			$especifique3=$_POST['especifique3'];

			$message=' Coleccion: '.$coleccion3.' 
			Motivo: '.$motivo3.'
			Descripción: '.$descripcion3.'
			Cantidad: '.$cantidad3.' 
			Tipo: '.$tipo3.' 
			Especifique: '.$especifique3.'

			'.$message;

			$c=("INSERT INTO cambios (fecha,cliente,coleccion,motivo,descripcion,cantidad,tipo,especifique,status) VALUES ('$fecha','$usuariologged','$coleccion3','$motivo3','$descripcion3','$cantidad3','$tipo3','$especifique3','pendiente')");
			mysqli_query($con,$c);
		}
	}
	if(isset($_POST['coleccion4'])) {
		if (!empty($_POST['coleccion4'])) {
			$coleccion4=$_POST['coleccion4'];
			$motivo4=$_POST['motivo4'];
			$descripcion4=$_POST['descripcion4'];
			$cantidad4=$_POST['cantidad4'];
			$tipo4=$_POST['tipo4'];
			$especifique4=$_POST['especifique4'];

			$message=' Coleccion: '.$coleccion4.'
			Motivo: '.$motivo4.'
			Descripción: '.$descripcion4.'
			Cantidad: '.$cantidad4.'
			Tipo: '.$tipo4.'
			Especifique: '.$especifique4.'

			'.$message;

			$c=("INSERT INTO cambios (fecha,cliente,coleccion,motivo,descripcion,cantidad,tipo,especifique,status) VALUES ('$fecha','$usuariologged','$coleccion4','$motivo4','$descripcion4','$cantidad4','$tipo4','$especifique4','pendiente')");
			mysqli_query($con,$c);
		}
	}
	if(isset($_POST['coleccion5'])) {
		if (!empty($_POST['coleccion5'])) {
			$coleccion5=$_POST['coleccion5'];
			$motivo5=$_POST['motivo5'];
			$descripcion5=$_POST['descripcion5'];
			$cantidad5=$_POST['cantidad5'];
			$tipo5=$_POST['tipo5'];
			$especifique5=$_POST['especifique5'];

			$message=' Coleccion: '.$coleccion5.'
			Motivo: '.$motivo5.'
			Descripción: '.$descripcion5.'
			Cantidad: '.$cantidad5.' 
			Tipo: '.$tipo5.' 
			Especifique: '.$especifique5.'
			
			'.$message;

			$c=("INSERT INTO cambios (fecha,cliente,coleccion,motivo,descripcion,cantidad,tipo,especifique,status) VALUES ('$fecha','$usuariologged','$coleccion5','$motivo5','$descripcion5','$cantidad5','$tipo5','$especifique5','pendiente')");
			mysqli_query($con,$c);
		}
	}

	if(isset($message)) {
		if (!empty($message)) {
			require_once (TEMPLATEPATH . '/phpmailer/PHPMailerAutoload.php');

		    $mail = new PHPMailer();
		    $mail->CharSet = 'UTF-8';
		    $mail->From = $emaillogged;
		    $mail->FromName = $usuariologged;
		    $mail->AddAddress('coimtex@hotmail.com');
		    $mail->Subject = 'Solicitud de cambio y avería '.$usuariologged;
		    $mail->Body = $usuariologged.' ha introducido una solicitud de cambio y avería
		     '.$message;
		    if(!$mail->Send()) {
			   echo "Intente nuevamente mas tarde.";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			   exit;
			}
	    }
	}
	    
?>