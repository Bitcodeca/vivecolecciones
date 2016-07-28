<?php
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$todoslosusuarios = get_users();

	foreach ( $todoslosusuarios as $user ) {
		$buscar=$user->user_login;
		$result = mysqli_query($con, "SELECT * FROM historial WHERE cliente='".$buscar."' ");
		while ($row = mysqli_fetch_array($result)) {
			$id=$row['id'];
			$cliente=$row['cliente'];
			$fechaini=$row['fechaini'];
			$fechafin=$row['fechafin'];
			$monto=$row['monto'];
			$comentario=$row['comentario'];
			?>
			<div class="mix <?php echo $cliente; ?>" data-myorder="<?php echo $id; ?>">
		        <div class="row text-center bordertopnegro">
					<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
						<?php echo $cliente; ?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
						<?php echo $fechaini; ?>
					</div>
					<div class="col-md-2 col-sm-3 col-xs-6 paddingtop10"> 
						<?php echo $fechafin; ?>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12 paddingtop10">
						Bsf <?php echo number_format($monto, 2, ',', '.'); ?>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12  paddingtop10">
						<?php echo $comentario; ?>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php }
	}
?>