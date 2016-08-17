<?php
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$result = mysqli_query($con, "SELECT * FROM denuncias");
	while ($row = mysqli_fetch_array($result)) {
		$fecha=$row['fecha'];
		$cliente=$row['cliente'];
		$nombre=$row['nombre'];
		$localidad=$row['localidad'];
		$observacion=$row['observacion'];
		$cedula=$row['cedula'];
		$id=$row['id'];
		?>
		<div class="fondogrispar paddingtopbot10 mix" data-myorder="<?php echo $id; ?>">
	        <div class="row text-center">
				<div class="col-md-2 col-sm-2 col-xs-6"> 
					<?php echo $fecha; ?>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-6"> 
					<?php echo $cliente; ?>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-6"> 
					<?php echo $localidad; ?>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12"> 
					<?php echo $nombre; ?>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-12">
					<?php echo $cedula; ?>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 paddingtopbot10">
					<?php echo $observacion; ?>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php }
?>