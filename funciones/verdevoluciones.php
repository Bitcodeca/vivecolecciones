<?php
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$result = mysqli_query($con, "SELECT * FROM devoluciones WHERE cliente='".$usuariologged."'");
 	echo '<div class="row margintop25 fondoazul text-center">';
	echo			    '<div class="col-md-4 col-sm-4 col-xs-6"><h4>Fecha</h4></div>';
	echo			    '<div class="col-md-4 col-sm-4 col-xs-6"><h4>Colección</h4></div>'	;	
	echo			    '<div class="col-md-4 col-sm-4 col-xs-12"><h4>Cantidad</h4></div>';
	echo '</div>';
	while ($row = mysqli_fetch_array($result)) {
		$fecha=$row['fecha'];
		$coleccion=$row['coleccion'];
		$cantidad=$row['cantidad'];
		$fechaunixcamb = DateTime::createFromFormat("d/m/Y", $fecha);
		$fechaunixcamb=date_format($fechaunixcamb,"Y-m-d");
		$fechaunixdep=strtotime($fechaunixcamb);
        echo '<div class="fondogrispar paddingtopbot10 row mix text-center"  data-myorder="'.$fechaunixdep.'">';
		echo     '<div class="col-md-4 col-sm-4 col-xs-6">'.$fecha.'</div>';
		echo     '<div class="col-md-4 col-sm-4 col-xs-6">'.$coleccion.'</div>';
		echo     '<div class="col-md-4 col-sm-4 col-xs-12">'.$cantidad.'</div>';
		echo '</div>'; 
	}
?>