<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else { 

	    	if(isset($_POST['btn']) || $_POST['modif']=='modificar' ){
	    		if($_POST['btn']=='siguiente'){
	    			$usuario=$_POST['usuario']; ?>
	
			    	<div class="container margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable">
								<div class="row">
									<form name="importa" method="post" action="?" >
										<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" />
										<div class="row">
											<div class="col-xs-12 col-sm-4 col-sm-offset-4">
												<h1 class="center-align">Modificar Factura</h1>
												<div class="input-field col-xs-12">
													<select name="cam" id="cam">
														<option value="" disabled selected>Selecciona la Campaña</option>
														<?php
														$query3 = "SELECT DISTINCT cam from vive_fac WHERE usuario='$usuario' ORDER BY cam ASC";
														$result3 = mysqli_query($mysqli, $query3);
														if(mysqli_num_rows($result3) != 0) {
															while($row3 = mysqli_fetch_assoc($result3)) {
																$cam=$row3['cam'];
																if($row['cam']!=$cam){
																	?>
																	<option value="<?php echo $cam; ?>">Campaña #<?php echo $cam; ?></option>
																	<?php
																}
															}
														} ?>
														<label>Seleccionar</label>
													</select>
												</div>
											</div>
										</div>
										<div class="row center-align">
											<button type="submit" value="campana" id="btn" name="btn" class="btn fondo3 waves-effect waves-light btn-radius">
												<i class="material-icons medium right">arrow_forward</i>
												SIGUIENTE
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

	    		<?php } elseif($_POST['btn']=='campana' || $_POST['modif']=='modificar') {
		    			$usuario=$_POST['usuario'];
		    			$cam=$_POST['cam'];

		    			if($_POST['modif']=='modificar'){
		    				$numart=$_POST['numart'];
		    				$fec=$_POST['fec'];				
		    				$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fec);
							$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
							$fechaunixdep=strtotime($fechacambiadadep);
							$q1unix = strtotime('+7 days', $fechaunixdep);
							$q2unix = strtotime('+7 days', $q1unix);
							$q3unix = strtotime('+7 days', $q2unix);
							$q4unix = strtotime('+7 days', $q3unix);
							$q5unix = strtotime('+7 days', $q4unix);
							$q6unix = strtotime('+7 days', $q5unix);
							$q1=gmdate("d/m/Y", $q1unix);
							$q2=gmdate("d/m/Y", $q2unix);
							$q3=gmdate("d/m/Y", $q3unix);
							$q4=gmdate("d/m/Y", $q4unix);
							$q5=gmdate("d/m/Y", $q5unix);
							$q6=gmdate("d/m/Y", $q6unix);

		    				for ($i = 0; $i < $numart; $i++) {
		    					if(!empty($_POST['vnombre'.$i])){

		    						$art_id=$_POST['vart'.$i];
		    						$art_can=$_POST['vcan'.$i];
		    						$post_id=$_POST['id'.$i];

									$query = "UPDATE vive_fac SET art_id='$art_id', can='$art_can', fec='$fec', q1='$q1', q2='$q2', q3='$q3', q4='$q4', q5='$q5', q6='$q6' WHERE id='$post_id'";
									if ($mysqli->query( $query ) === TRUE) { }

		    					}
		    					else {

		    						$post_id=$_POST['id'.$i];
									$query = "DELETE FROM vive_fac WHERE id=$post_id";
									if ($mysqli->query( $query ) === TRUE) { }

		    					}
		    					
		    				}

		    			}

	    				?>

						<div class="container margintop25 marginbot25">
							<div class="col-xs-12">
								<div class="card-panel z-depth-2 hoverable">
									<div class="row">
										<h1 class="center-align">Modificar Factura</h1>
										<h2 class="center-align"><?php echo $usuario.' Campaña #'.$cam; ?></h2>
									</div>

									<form role="form" method="post" name="contactform" action="?" >
										<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>"/>
										<input type="hidden" name="cam" id="cam" value="<?php echo $cam; ?>" />
										<?php
						    			$query = "SELECT * FROM vive_cam WHERE cam='$cam'"; 
						    			$result = mysqli_query($mysqli, $query);
										if(mysqli_num_rows($result) != 0) { while($row = mysqli_fetch_assoc($result)) { $id=$row['id']; $articulo=$row['art']; ${'articulo'.$id}=$articulo; } }
										$x=0;
										$query = "SELECT * FROM vive_fac WHERE usuario='$usuario' AND cam='$cam'";
										$result = mysqli_query($mysqli, $query);
										if(mysqli_num_rows($result) != 0) {
											while($row = mysqli_fetch_assoc($result)) {
												$fecha=$row['fec'];
												$artid=$row['art_id'];
												$id=$row['id'];
												$nombre=${'articulo'.$artid};
												?>
												<input type="hidden" name="vart<?php echo $x; ?>"  id="vart<?php echo $x; ?>"  value="<?php echo $artid; ?>"/>
												<input type="hidden" name="id<?php echo $x; ?>"  id="id<?php echo $x; ?>"  value="<?php echo $id; ?>"/>
												<div class="row">
													<div class="input-field col-xs-12 col-sm-6">
														<h4>Colección</h4>
										        		<input type="text" placeholder="Colección" value="<?php echo $nombre; ?>" id="vnombre<?php echo $x; ?>" name="vnombre<?php echo $x; ?>" >
											        </div>
													<div class="input-field col-xs-12 col-sm-6">
														<h4>Cantidad</h4>
										        		<input type="number" placeholder="Cantidad" name="vcan<?php echo $x; ?>"  id="vcan<?php echo $x; ?>"  value="<?php echo $row['can']; ?>"  >
											        </div>
										        </div>
												<?php
												$x++;
											}
											?>
											<input type="hidden" name="numart"  id="numart"  value="<?php echo $x; ?>"/>
											<div class="row marginbot0">
												<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
													<input type="date" class="datepicker" id="fec" name="fec" data-value="<?php echo $fecha; ?>" required>
										        </div>
									        </div>
											<?php
										}
										?>
											<div class="row center-align">
												<button type="submit" value="modificar" id="modif" name="modif" class="btn btn-radius fondo3 waves-effect waves-light margintop25">
													<i class="material-icons medium left">&#xE2C3;</i>
													MODIFICAR FACTURA
												</button>
												<button  type="submit" value="borrar" id="modif" name="modif" class="btn btn-radius fondo5 waves-effect waves-light margintop25">
													<i class="material-icons medium left">&#xE2C3;</i>
													BORRAR FACTURA
												</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<?php

	    			}
	    	} else{ 

	    		if($_POST['modif']=='borrar'){
	    			$usuario=$_POST['usuario'];
	    			$cam=$_POST['cam'];
					$query = "DELETE FROM vive_fac WHERE usuario='$usuario' AND cam='$cam'";
					if ($mysqli->query( $query ) === TRUE) { }
	    		}

	    		?>			

		    	<div class="container margintop25 marginbot25">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card-panel z-depth-2 hoverable">
							<div class="row">
								<form name="importa" method="post" action="?" >

									<div class="row">
										<div class="col-xs-12 col-sm-4 col-sm-offset-4">
											<h1 class="center-align">Modificar Factura</h1>
											<div class="input-field col-xs-12">
												<input placeholder="Seleccionar gerente" type="text" name="usuario" id="usuario" class="autocomplete">
												<label for="usuario"></label>
									        </div>

										</div>
									</div>
									<div class="row center-align">
										<button type="submit" value="siguiente" id="btn" name="btn" class="btn fondo3 waves-effect waves-light btn-radius">
											<i class="material-icons medium right">arrow_forward</i>
											SIGUIENTE
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

	    	<?php }	?>

	    <?php }
	} else{ ?>
		<h1> ACCESO NEGADO </h1>
	<?php	}  ?>
<?php } else {  
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit(); 
 } get_footer(); ?>
<script>
	jQuery(document).ready(function() {
		jQuery('input.autocomplete').autocomplete({
			data: {
				<?php
					$rol='Gerente';
					$devoluciones=usuarioPorRol($rol);
					foreach ($devoluciones as $value) {
					?>
			  			"<?php echo $value['login']; ?>": '<?php echo $value['avatarxs']; ?>',
					<?php
					}
				?>
			}
		});
	    jQuery('select').material_select();
	    jQuery('.datepicker').pickadate({
	    	monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		    selectMonths: true, // Creates a dropdown to control month
		    selectYears: 1, // Creates a dropdown of 15 years to control year
		    format: 'dd/mm/yyyy',
		    today: 'Hoy',
			clear: 'Borrar',
			close: 'Cerrar',
		});
	  });
</script>