<?php
set_time_limit(500);
extract($_POST);
    $archivo = $_FILES['excel']['name']; 
    $tipo = $_FILES['excel']['type']; 
    $destino = "bak_".$archivo; 
    
    if (copy($_FILES['excel']['tmp_name'], '.$destino.')) { 
    	//echo "Archivo Cargado Con Exito"; 
    } else { 
    	//echo "Error Al Cargar el Archivo"; 
    }
    
    if (file_exists ('.$destino.')) {
    
	    require_once('Classes/PHPExcel.php');

	    $con =  mysqli_connect("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
	    
		
	    
		$sheetname = 'Sheet1'; 
	    $objReader = new PHPExcel_Reader_CSV();
	    $objReader->setInputEncoding('UTF-8');
		$objReader->setDelimiter(';');
		$objReader->setEnclosure('');
	    $objReader->setLoadSheetsOnly($sheetname); 
	    $objPHPExcel = $objReader->load('.$destino.');
	    $objPHPExcel->setActiveSheetIndex(0); 	
		
		$i=2;
		$param=0;
		while($param==0) {                  
	        $fecha = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();                     
	        $banco = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();                       
	        $referencia = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();		
	        $monto = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();   
			
			if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()!=NULL) { //Si no es null, lo guarda en la BdD
	            $c=("INSERT INTO vive_dep ( fecha, referencia, monto, banco ) VALUES ('$fecha','$referencia','$monto','$banco')");
	       		mysqli_query($con,$c);
			}                     
	        if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()==NULL) { $param=1; }
	        $i++;
		}           
    }
    else { //si no se ha cargado el bak
        //echo "<br> Necesitas primero importar el archivo <br> <a href='actualizar.php'>Volver</a>";
    }
    //unlink($destino); //desenlazar a destino el lugar donde salen los datos(archivo)

	echo "<script>window.close();</script>";
	mysqli_close($con);
?>