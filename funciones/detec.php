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

	    $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	    
		mysqli_query($con, "truncate table volatil");
	    
		$sheetname = 'Sheet1'; 
	    $objReader = new PHPExcel_Reader_CSV();
	    $objReader->setInputEncoding('UTF-8');
		$objReader->setDelimiter(';');
		$objReader->setEnclosure('');
	    $objReader->setLoadSheetsOnly($sheetname); 
	    $objPHPExcel = $objReader->load('.$destino.');
	    $objPHPExcel->setActiveSheetIndex(0); 	
		$result = mysqli_query($con, 'select * from volatil');

		if (!$result) { die('Query failed: ' . mysqli_error($con)); }

		$i = 1; $total=0;
		while ($meta=mysqli_fetch_field($result)) {
			${'ltenombre'.$i}=$meta->name;
			${'lteposicion'.$i}=$i;
			$i++; $total++;	
		}
		mysqli_free_result($result);	
		$A = $objPHPExcel->getActiveSheet()->getCell("A".'1')->getCalculatedValue();                        
	    $B = $objPHPExcel->getActiveSheet()->getCell("B".'1')->getCalculatedValue();                        
	    $C = $objPHPExcel->getActiveSheet()->getCell("C".'1')->getCalculatedValue();                        
	    $D = $objPHPExcel->getActiveSheet()->getCell("D".'1')->getCalculatedValue();                        
	    $E = $objPHPExcel->getActiveSheet()->getCell("E".'1')->getCalculatedValue();                        
	    $F = $objPHPExcel->getActiveSheet()->getCell("F".'1')->getCalculatedValue();                        
	    $G = $objPHPExcel->getActiveSheet()->getCell("G".'1')->getCalculatedValue();                        
	    $H = $objPHPExcel->getActiveSheet()->getCell("H".'1')->getCalculatedValue();                        
	    $II = $objPHPExcel->getActiveSheet()->getCell("I".'1')->getCalculatedValue();                        
	    $J = $objPHPExcel->getActiveSheet()->getCell("J".'1')->getCalculatedValue();                        
	    $K = $objPHPExcel->getActiveSheet()->getCell("K".'1')->getCalculatedValue();                        
	    $L = $objPHPExcel->getActiveSheet()->getCell("L".'1')->getCalculatedValue();                        
	    $M= $objPHPExcel->getActiveSheet()->getCell("M".'1')->getCalculatedValue();                        
	    $N = $objPHPExcel->getActiveSheet()->getCell("N".'1')->getCalculatedValue();                        
	    $O = $objPHPExcel->getActiveSheet()->getCell("O".'1')->getCalculatedValue();                        
	    $P = $objPHPExcel->getActiveSheet()->getCell("P".'1')->getCalculatedValue();                        
	    $Q = $objPHPExcel->getActiveSheet()->getCell("Q".'1')->getCalculatedValue();                        
	    $R = $objPHPExcel->getActiveSheet()->getCell("R".'1')->getCalculatedValue();                        
	    $S = $objPHPExcel->getActiveSheet()->getCell("S".'1')->getCalculatedValue();                        
	    $T = $objPHPExcel->getActiveSheet()->getCell("T".'1')->getCalculatedValue();                        
	    $U = $objPHPExcel->getActiveSheet()->getCell("U".'1')->getCalculatedValue();	
		$V = $objPHPExcel->getActiveSheet()->getCell("V".'1')->getCalculatedValue();	
		$W = $objPHPExcel->getActiveSheet()->getCell("W".'1')->getCalculatedValue();	
		$X = $objPHPExcel->getActiveSheet()->getCell("X".'1')->getCalculatedValue();	
		$Y = $objPHPExcel->getActiveSheet()->getCell("Y".'1')->getCalculatedValue();	
		$Z = $objPHPExcel->getActiveSheet()->getCell("Z".'1')->getCalculatedValue();
		$i = 1;
		while ($i <= $total) {
			if (${'ltenombre'.$i}==$A){${'ltecolumna'.$i}='A';}		
			if (${'ltenombre'.$i}==$B){${'ltecolumna'.$i}='B';}		
			if (${'ltenombre'.$i}==$C){${'ltecolumna'.$i}='C';}		
			if (${'ltenombre'.$i}==$D){${'ltecolumna'.$i}='D';}			
			if (${'ltenombre'.$i}==$E){${'ltecolumna'.$i}='E';}		
			if (${'ltenombre'.$i}==$F){${'ltecolumna'.$i}='F';}		
			if (${'ltenombre'.$i}==$G){${'ltecolumna'.$i}='G';}		
			if (${'ltenombre'.$i}==$H){${'ltecolumna'.$i}='H';}		
			if (${'ltenombre'.$i}==$II){${'ltecolumna'.$i}='I';}		
			if (${'ltenombre'.$i}==$J){${'ltecolumna'.$i}='J';}		
			if (${'ltenombre'.$i}==$K){${'ltecolumna'.$i}='K';}		
			if (${'ltenombre'.$i}==$L){${'ltecolumna'.$i}='L';}		
			if (${'ltenombre'.$i}==$M){${'ltecolumna'.$i}='M';}		
			if (${'ltenombre'.$i}==$N){${'ltecolumna'.$i}='N';}		
			if (${'ltenombre'.$i}==$O){${'ltecolumna'.$i}='O';}		
			if (${'ltenombre'.$i}==$P){${'ltecolumna'.$i}='P';}		
			if (${'ltenombre'.$i}==$Q){${'ltecolumna'.$i}='Q';}		
			if (${'ltenombre'.$i}==$R){${'ltecolumna'.$i}='R';}		
			if (${'ltenombre'.$i}==$S){${'ltecolumna'.$i}='S';}		
			if (${'ltenombre'.$i}==$T){${'ltecolumna'.$i}='T';}		
			if (${'ltenombre'.$i}==$U){${'ltecolumna'.$i}='U';}		
			if (${'ltenombre'.$i}==$V){${'ltecolumna'.$i}='V';}		
			if (${'ltenombre'.$i}==$W){${'ltecolumna'.$i}='W';}		
			if (${'ltenombre'.$i}==$X){${'ltecolumna'.$i}='X';}		
			if (${'ltenombre'.$i}==$Y){${'ltecolumna'.$i}='Y';}		
			if (${'ltenombre'.$i}==$Z){${'ltecolumna'.$i}='Z';}	
			$i++;
		}
		$i=1;
 		$id=1;
		 $param=0;
		while($param==0) {                  
	        $fecha = $objPHPExcel->getActiveSheet()->getCell($ltecolumna2.$i)->getCalculatedValue();                     
	        $banco = $objPHPExcel->getActiveSheet()->getCell($ltecolumna3.$i)->getCalculatedValue();                       
	        $referencia = $objPHPExcel->getActiveSheet()->getCell($ltecolumna4.$i)->getCalculatedValue();		
	        $monto = $objPHPExcel->getActiveSheet()->getCell($ltecolumna5.$i)->getCalculatedValue();   
			
			if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()!=NULL) { //Si no es null, lo guarda en la BdD
	            $c=("INSERT INTO volatil VALUES ('$id','$fecha','$banco','$referencia','$monto')");
	       		mysqli_query($con,$c);
			}                     
	        if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()==NULL) { $param=1; }
	        $i++; $id++;
		}           
    }
    else { //si no se ha cargado el bak
        //echo "<br> Necesitas primero importar el archivo <br> <a href='actualizar.php'>Volver</a>";
    }
    //unlink($destino); //desenlazar a destino el lugar donde salen los datos(archivo)

	echo "<script>window.close();</script>";
	mysqli_close($con);
?>