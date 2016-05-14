<?php 
	$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
	$bancoarray = array(mercantil, provincial, banesco, activo, bicentenario, venezuela, banplus);
	foreach ($bancoarray as $ordenbanco) {
		$result = mysqli_query($con, "SELECT * FROM registro WHERE cliente='".$cliente."' AND banco LIKE '%".$ordenbanco."%' ");
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
				} elseif ($statusdeposito=='pendiente') {
					$fondo="btn-warning";
				} elseif ($statusdeposito=='negada') {
					$fondo="btn-danger";
				}
				$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fechadeposito);
				$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
				$fechaunixdep=strtotime($fechacambiadadep);
		?>
		<div class="mix <?php echo $clientedeposito; ?> <?php echo $bancodeposito; ?> <?php echo $statusdeposito; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
			<form name="importa<?php echo $iddeposito; ?>" method="post" action="http://vivecolecciones.com.ve/reportes/" >
		        <div class="row text-center bordertopnegro">
					<div class="col-md-2 col-sm-2 col-xs-4"> 
						<input placeholder="Fecha"  id="fecha<?php echo $iddeposito; ?>" name="fecha<?php echo $iddeposito; ?>" type="text" class="form-control" value="<?php echo $fechadeposito; ?>">
					</div>
					<div class="col-md-2 col-sm-2 col-xs-4 paddingtop10"> 
						<?php echo $clientedeposito; ?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-4 paddingtop10"> 
						<?php echo $bancodeposito; ?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
						<?php echo $referenciadeposito; ?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10">
						Bsf <?php echo number_format($montodeposito, 2, ',', '.'); ?>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12 <?php echo $fondo; ?>">
						<h6><?php echo $statusdeposito; ?></h6>
					</div>
				</div>
				<div class="row text-center marginbot25 paddingbot10 borderbotnegro">
						<input class="btn btn-success btnedc" type="submit" name="btn" id="btn"  value="Aprobar" />
					
						<input class="btn btn-warning btnedc" type="submit" name="btn" id="btn"  value="Pendiente" />
					
						<input class="btn btn-danger btnedc" type="submit" name="btn" id="btn"  value="Negar" />
					
						<input class="btn btn-primary btnedc" type="submit" name="btn" id="btn"  value="Editar" />
					
						<input class="btn btn-default btnedc" type="submit" name="btn" id="btn"  value="Eliminar" />
					
				</div>
				<input hidden type="text" name="id" id="id" value="<?php echo $iddeposito; ?>">
				<input hidden type="text" name="cliente" id="cliente" value="<?php echo $cliente; ?>">
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
			if (${'fecha'.$clientedeposito} <= $fechadeposito && $fechadeposito <= ${'c1'.$clientedeposito}){
				${'montoq1'.$clientedeposito}=${'montoq1'.$clientedeposito}+$montodeposito;
			}
			if (${'c1'.$clientedeposito} < $fechadeposito && $fechadeposito <= ${'c2'.$clientedeposito}){
				${'montoq2'.$clientedeposito}=${'montoq2'.$clientedeposito}+$montodeposito;
			}
			if (${'c2'.$clientedeposito} < $fechadeposito && $fechadeposito <= ${'c3'.$clientedeposito}){
				${'montoq3'.$clientedeposito}=${'montoq3'.$clientedeposito}+$montodeposito;
			}
			if (${'c3'.$clientedeposito} < $fechadeposito && $fechadeposito <= ${'c4'.$clientedeposito}){
				${'montoq4'.$clientedeposito}=${'montoq4'.$clientedeposito}+$montodeposito;
			}
		}
	}
?>