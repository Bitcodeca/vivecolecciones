<?php
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	if ($pagina=='inicio' || $pagina=='inventariogeneral') {
		$result = mysqli_query($con, "SELECT * FROM cambios ORDER BY fecha DESC");
	} else {
		$result = mysqli_query($con, "SELECT * FROM cambios WHERE cliente='".$usuariologged."' ORDER BY fecha DESC");
	}
	while ($row = mysqli_fetch_array($result)) {
		$iddeposito=$row['id'];
		$fecha=$row['fecha'];
		$cliente=$row['cliente'];
		$coleccion=$row['coleccion'];
		$motivo=$row['motivo'];
		$descripcion=$row['descripcion'];
		$cantidad=$row['cantidad'];
		$tipo=$row['tipo'];
		$especifique=$row['especifique'];
		$status=$row['status'];
		if ($status=='aprobado') {
			$fondo="btn-success";
		} elseif ($status=='pendiente') {
			$fondo="btn-warning";
		} elseif ($status=='negado') {
			$fondo="btn-danger";
		}
		$fechaunixdep=strtotime($fecha);
		
		if( current_user_can('subscriber')) { ?>
			<div class="mix <?php echo $status; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
				<div class="container <?php echo $fondo; ?> bordertopnegro borderbotnegro paddingbot10 paddingtop10 text-center">
					<div class="row">
						<div class="col-md-1 col-sm-1 col-xs-6">
							<?php echo $fecha; ?>
						</div>
						<div class="col-md-1 col-sm-1 col-xs-6">
							<?php echo $coleccion; ?>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<?php echo $motivo ?>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<?php echo $descripcion ?>
						</div>
						<div class="col-md-1 col-sm-1 col-xs-6">
							<?php echo $cantidad ?>
						</div>
						<div class="col-md-1 col-sm-1 col-xs-6">
							<?php echo $tipo ?>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<?php echo $especifique ?>
						</div>
						<div class="col-md-1 col-sm-1 col-xs-12">
							<?php echo $status ?>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<?php
		} elseif (current_user_can('administrator')) {
			if ($pagina=='inicio') { ?>
			<div class="mix <?php echo $cliente; ?> <?php echo $status; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
				<form name="importa<?php echo $iddeposito; ?>" method="post" action="http://vivecolecciones.com.ve/inicio/" >
					<div class="container bordertopnegro borderbotnegro paddingbot10 text-center">
						<div class="row">
							<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
								<?php echo $fecha; ?>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
								<?php echo $cliente; ?>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
								<?php echo $coleccion; ?>
							</div>
							<div class="col-md-1 col-sm-2 col-xs-4 paddingtop10">
								<?php echo $motivo ?>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-4 paddingtop10">
								<?php echo $descripcion ?>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
								<?php echo $cantidad ?>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
								<?php echo $tipo ?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-4 paddingtop10">
								<?php echo $especifique ?>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-4 <?php echo $fondo; ?> ">
								<h6><?php echo $status ?></h6>
							</div>
						</div>
						<div class="row text-center">
							<input class="btn btn-success btnedc" type="submit" name="btncya" id="btncya"  value="Aprobar" />
						
							<input class="btn btn-warning btnedc" type="submit" name="btncya" id="btncya"  value="Pendiente" />
						
							<input class="btn btn-danger btnedc" type="submit" name="btncya" id="btncya"  value="Negar" />
						
							<input class="btn btn-default btnedc" type="submit" name="btncya" id="btncya"  value="Eliminar" />
						</div>
					</div>
					<input hidden type="text" name="cliente" id="cliente" value="<?php echo $cliente; ?>">
					<input hidden type="text" name="id" id="id" value="<?php echo $iddeposito; ?>">
				</form>
				<div class="clearfix marginbot10"></div>
			</div>
			<?php } elseif ($pagina=='inventariogeneral') { ?>
				<div class="mix <?php echo $cliente; ?> <?php echo $status; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
					<form name="importa<?php echo $iddeposito; ?>" method="post" action="http://vivecolecciones.com.ve/inventario-general/">
						<div class="container bordertopnegro borderbotnegro paddingbot10 text-center">
							<div class="row">
								<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
									<?php echo $fecha; ?>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
									<?php echo $cliente; ?>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
									<?php echo $coleccion; ?>
								</div>
								<div class="col-md-1 col-sm-2 col-xs-4 paddingtop10">
									<?php echo $motivo ?>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-4 paddingtop10">
									<?php echo $descripcion ?>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
									<?php echo $cantidad ?>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
									<?php echo $tipo ?>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-4 paddingtop10">
									<?php echo $especifique ?>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-4 <?php echo $fondo; ?> ">
									<h6><?php echo $status ?></h6>
								</div>
							</div>
							<div class="row text-center">
								<input class="btn btn-success btnedc" type="submit" name="btncya" id="btncya"  value="Aprobar" />
							
								<input class="btn btn-warning btnedc" type="submit" name="btncya" id="btncya"  value="Pendiente" />
							
								<input class="btn btn-danger btnedc" type="submit" name="btncya" id="btncya"  value="Negar" />
							
								<input class="btn btn-default btnedc" type="submit" name="btncya" id="btncya"  value="Eliminar" />
							</div>
						</div>
						<input hidden type="text" name="cliente" id="cliente" value="<?php echo $cliente; ?>">
						<input hidden type="text" name="id" id="id" value="<?php echo $iddeposito; ?>">
					</form>
			<div class="clearfix marginbot10"></div>
				</div>
			<?php } else { ?>
				<div class="mix <?php echo $cliente; ?> <?php echo $status; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
				<form name="importa<?php echo $iddeposito; ?>" method="post" action="http://vivecolecciones.com.ve/reportes/" >
					<div class="container bordertopnegro borderbotnegro paddingbot10 text-center">
						<div class="row">
							<div class="col-md-1 col-sm-1 col-xs-12 paddingtop10">
								<?php echo $fecha; ?>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
								<?php echo $coleccion; ?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-4 paddingtop10">
								<?php echo $motivo ?>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-4 paddingtop10">
								<?php echo $descripcion ?>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
								<?php echo $cantidad ?>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-4 paddingtop10">
								<?php echo $tipo ?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-4 paddingtop10">
								<?php echo $especifique ?>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-12 <?php echo $fondo; ?> ">
								<h6><?php echo $status ?></h6>
							</div>
						</div>
						<div class="row text-center">
							<input class="btn btn-success btnedc" type="submit" name="btncya" id="btncya"  value="Aprobar" />
						
							<input class="btn btn-warning btnedc" type="submit" name="btncya" id="btncya"  value="Pendiente" />
						
							<input class="btn btn-danger btnedc" type="submit" name="btncya" id="btncya"  value="Negar" />
						
							<input class="btn btn-default btnedc" type="submit" name="btncya" id="btncya"  value="Eliminar" />
						</div>
					</div>
					<input hidden type="text" name="cliente" id="cliente" value="<?php echo $cliente; ?>">
					<input hidden type="text" name="id" id="id" value="<?php echo $iddeposito; ?>">
					</form>
			<div class="clearfix marginbot10"></div>
				</div>
			<?php } ?>
	<?php }
	}
?>