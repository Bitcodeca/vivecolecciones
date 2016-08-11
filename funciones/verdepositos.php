<?php
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$result = mysqli_query($con, "SELECT * FROM registro WHERE cliente='".$usuariologged."' AND status='aprobado'");
 	echo '<div class="row margintop25 fondoazul text-center">';
	echo			    '<div class="col-md-3 col-sm-3 col-xs-6"><h4>Fecha</h4></div>';
	echo			    '<div class="col-md-3 col-sm-3 col-xs-6"><h4>Banco</h4></div>'	;	
	echo			    '<div class="col-md-3 col-sm-3 col-xs-6"><h4># Referencia</h4></div>';
	echo			    '<div class="col-md-3 col-sm-3 col-xs-6"><h4>Monto</h4></div>';
	echo '</div>';
	while ($row = mysqli_fetch_array($result)) {
		$banco=$row['banco'];
		$fecha=$row['fecha'];
		$referencia=$row['referencia'];
		$monto=$row['monto'];
		$status=$row['status'];
		$cliente=$row['cliente'];
		$fechaunixcamb = DateTime::createFromFormat("d/m/Y", $fecha);
		$fechaunixcamb=date_format($fechaunixcamb,"Y-m-d");
		$fechaunixdep=strtotime($fechaunixcamb);
        echo '<div class="fondogrispar paddingtopbot10 row mix text-center '.$banco.'"  data-myorder="'.$fechaunixdep.'">';
		echo     '<div class="col-md-3 col-sm-3 col-xs-6">'.$fecha.'</div>';
		echo     '<div class="col-md-3 col-sm-3 col-xs-6">'.$banco.'</div>';
		echo     '<div class="col-md-3 col-sm-3 col-xs-6">'.$referencia.'</div>';
		echo     '<div class="col-md-3 col-sm-3 col-xs-6">Bsf '.$monto.'</div>';
		echo '</div>'; 
	}
?>