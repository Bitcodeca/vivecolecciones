<?php
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$todoslosusuarios = get_users();
	$aprobado=0;
	$pendiente=0;
	$negado=0;
	$bancoarray = array(mercantil, provincial, banesco, activo, bicentenario, venezuela, banplus);

	foreach ( $todoslosusuarios as $user ) {
		$buscar=$user->user_login;
			$result = mysqli_query($con, "SELECT * FROM registro WHERE cliente='".$buscar."' AND status='pendiente'");
			while ($row = mysqli_fetch_array($result)) {
				$iddeposito=$row['id'];
				$clientedeposito=$row['cliente'];
				$fechadeposito=$row['fecha'];
				$bancodeposito=$row['banco'];
				$referenciadeposito=$row['referencia'];
				$montodeposito=$row['monto'];
				$statusdeposito=$row['status'];
				if ($statusdeposito=='aprobado') {
					$fondo="btn-success";
					$aprobado++;
				} elseif ($statusdeposito=='pendiente') {
					$fondo="btn-warning";
					$pendiente++;
				}elseif ($statusdeposito=='negada') {
					$fondo="btn-danger";
					$negado++;
				}
				$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fechadeposito);
				$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
				$fechaunixdep=strtotime($fechacambiadadep);
			?>
			<div class="fondogrispar mix <?php echo $clientedeposito; ?> <?php echo $bancodeposito; ?> <?php echo $statusdeposito; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
				<form name="importa<?php echo $iddeposito; ?>" method="post" action="http://vivecolecciones.com.ve/depositos-problemas/" >
			        <div class="row text-center bordertopnegro">
						<div class="col-md-2 col-sm-2 col-xs-12"> 
							<input placeholder="Fecha"  id="fecha<?php echo $iddeposito; ?>" name="fecha<?php echo $iddeposito; ?>" type="text" class="form-control" value="<?php echo $fechadeposito; ?>">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
							<?php echo $clientedeposito; ?>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
							<?php echo $bancodeposito; ?>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12"> 
							<input placeholder="referencia"  id="referencia<?php echo $iddeposito; ?>" name="referencia<?php echo $iddeposito; ?>" type="text" class="form-control" value="<?php echo $referenciadeposito; ?>">							
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12 paddingtop10">
							Bsf <?php echo number_format($montodeposito, 2, ',', '.'); ?>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12 <?php echo $fondo; ?>">
							<h6><?php echo $statusdeposito; ?></h6>
						</div>
					</div>
					<div class="row text-center marginbot10 paddingbot10 borderbotnegro">
							<input class="btn btn-success btnedc" type="submit" name="btn" id="btn"  value="Aprobar" />
						
							<input class="btn btn-warning btnedc" type="submit" name="btn" id="btn"  value="Pendiente" />
						
							<input class="btn btn-danger btnedc" type="submit" name="btn" id="btn"  value="Negar" />
						
							<input class="btn btn-primary btnedc" type="submit" name="btn" id="btn"  value="Editar" />
						
							<input class="btn btn-default btnedc" type="submit" name="btn" id="btn"  value="Eliminar" />
						
					</div>
					<input hidden type="text" name="id" id="id" value="<?php echo $iddeposito; ?>">
				</form>
			</div>
			<script>
			  jQuery(function() {
			    jQuery( "#fecha<?php echo $iddeposito; ?>" ).datepicker({
	        		dateFormat: 'dd/mm/yy',
	        		defaultDate: '<?php echo $fechadeposito; ?>'
	    		});
			  });
			</script>
			<div class="clearfix"></div>
				<?php
		}
	}
?>