<?php
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$result = mysqli_query($con, "SELECT * FROM historial");
	while ($row = mysqli_fetch_array($result)) {
		$id=$row['id'];
		$cliente=$row['cliente'];
		$fechaini=$row['fechaini'];
		$fechafin=$row['fechafin'];
		$monto=$row['monto'];
		$comentario=$row['comentario'];
		?>
		<div class="fondogrispar paddingtopbot10 mix <?php echo $cliente; ?>" data-myorder="<?php echo $id; ?>">
	        <div class="row text-center">
				<div class="col-md-2 col-sm-2 col-xs-6"> 
					<?php echo $cliente; ?>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-6"> 
					<?php echo $fechaini; ?>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6"> 
					<?php echo $fechafin; ?>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					Bsf <?php echo number_format($monto, 2, ',', '.'); ?>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<?php echo $comentario; ?>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php }
?>