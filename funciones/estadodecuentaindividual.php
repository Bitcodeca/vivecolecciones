<?php
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$montototal=0;
	$bancoarray = array(mercantil, provincial, banesco, activo, bicentenario, venezuela, banplus, bancaribe, bnc, venezolano);

	$resultgeneral = mysqli_query($con, "SELECT * FROM registro WHERE cliente='".$buscar."' LIMIT 1 ");
	while ($row = mysqli_fetch_array($resultgeneral)) {
		$fechadeposito=$row['fecha'];
		$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fechadeposito);
		$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
		$fechaunixdep=strtotime($fechacambiadadep);
		$primerafecha=$fechaunixdep;
		$ultimafecha=$fechaunixdep;
	}

	foreach ($bancoarray as $ordenbanco) {
		$result = mysqli_query($con, "SELECT * FROM registro WHERE cliente='".$buscar."' AND banco LIKE '%".$ordenbanco."%' ");
		while ($row = mysqli_fetch_array($result)) {
			$iddeposito=$row['id'];
			$clientedeposito=$row['cliente'];
			$fechadeposito=$row['fecha'];
			$bancodeposito=$row['banco'];
			$referenciadeposito=$row['referencia'];
			$montodeposito=$row['monto'];
			$statusdeposito=$row['status'];

			if ($statusdeposito=='aprobado') { $fondo="btn-success"; $montototal=$montototal+$montodeposito; } 
			elseif ($statusdeposito=='pendiente') { $fondo="btn-warning"; }
			elseif ($statusdeposito=='negada') { $fondo="btn-danger"; }

			$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fechadeposito);
			$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
			$fechaunixdep=strtotime($fechacambiadadep);

			if ($fechaunixdep<=$primerafecha){ $primerafecha=$fechaunixdep; }
			elseif ($fechaunixdep>=$ultimafecha) { $ultimafecha=$fechaunixdep; }
			?>
			<div class="mix <?php echo $clientedeposito; ?> <?php echo $bancodeposito; ?> <?php echo $statusdeposito; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
		        <div class="row text-center bordertopnegro">
					<div class="col-md-2 col-sm-2 col-xs-12"> 
						<?php echo $fechadeposito; ?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
						<?php echo $clientedeposito; ?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
						<?php echo $bancodeposito; ?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12 paddingtop10"> 
						<?php echo $referenciadeposito; ?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12 paddingtop10">
						Bsf <?php echo number_format($montodeposito, 2, ',', '.'); ?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12 <?php echo $fondo; ?>">
						<h6><?php echo $statusdeposito; ?></h6>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php
		}
	}
	$primerafecha=gmdate("d-m-Y", $primerafecha);
	$ultimafecha=gmdate("d-m-Y", $ultimafecha);
?>