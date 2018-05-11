<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else { 

	    	if(isset($_POST['btn'])){
	    		if($_POST['btn']=='siguiente'){
	    			$usuario=$_POST['usuario'];
	    			$cam=$_POST['cam']; ?>
	<style>
		select {
		    display: inline-block;
		}
	</style>
			    	<div class="container margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable">
								<div class="row">
									<form name="importa" method="post" >

										<div class="row">
											<div class="col-xs-12 col-sm-4 col-sm-offset-4">
												<h1 class="center-align">Nueva Factura</h1>
							
												<div class="input-field col-xs-12">
													<h4>Gerente</h4>
									        		<input type="text" placeholder="Gerente" name="usuario"  id="usuario"  value="<?php echo $usuario;?>" readonly required>
												</div>

											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-4 col-sm-offset-4">
												<div class="input-field col-xs-12">
													<h4>Número de campaña</h4>
									        		<input type="text" placeholder="Campaña" name="cam"  id="cam"  value="<?php echo $cam;?>" readonly required>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-4 col-sm-offset-4">
												<div class="input-field col-xs-12">
													<h4>Fecha de inicio</h4>
													<input type="date" class="datepicker" id="fec" name="fec">
												</div>
											</div>
										</div>
										<?php
										$x=0;
										$query = "SELECT * from vive_cam WHERE cam='$cam'";
										$result = mysqli_query($mysqli, $query);
										if(mysqli_num_rows($result) != 0) {
											while($row = mysqli_fetch_assoc($result)) { ?>
												<div class="row">
													<div class="col-xs-12 col-sm-8 col-sm-offset-2">
														<div class="col-xs-6 right-align">
														    <p class=" right-align">
														      <input name="<?php echo $x; ?>" type="checkbox" id="<?php echo $x; ?>" />
														      <label for="<?php echo $x; ?>"><?php echo $row['art']; ?></label>
														    </p>
														</div>
														<div class="col-xs-6">
															<div class="input-field col-xs-12">
												        		<input type="number" placeholder="Cantidad" name="can<?php echo $x; ?>"  id="can<?php echo $x; ?>">
															</div>
														</div>
													</div>
												</div>

												<input type="hidden" name="id<?php echo $x; ?>" id="id<?php echo $x; ?>" value="<?php echo $row['id']; ?>" />
											<?php $x++;
											 }
										} ?>
										<input type="hidden" name="articulos" id="articulos" value="<?php echo $x; ?>" />
										<div class="row center-align">
											<button type="submit" value="grabar" id="btn" name="btn" class="btn btn-radius fondo3 waves-effect waves-light">
												<i class="material-icons medium right">arrow_forward</i>
												GUARDAR
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

	    		<?php } elseif($_POST['btn']=='grabar') {
	    			$articulos=$_POST['articulos'];
	    			$usuario=$_POST['usuario'];
	    			$cam=$_POST['cam'];
	    			$fec=$_POST['fec'];
	    			$fecha_creada=date("d/m/Y");
					$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fec);
					$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
					$fechaunixdep=strtotime($fechacambiadadep);
					$q1unix = strtotime('+15 days', $fechaunixdep);
					$q2unix = strtotime('+15 days', $q1unix);
					$q3unix = strtotime('+15 days', $q2unix);
					$q1=gmdate("d/m/Y", $q1unix);
					$q2=gmdate("d/m/Y", $q2unix);
					$q3=gmdate("d/m/Y", $q3unix);

	    			for ($i = 0; $i < $articulos; $i++) {
	    				if(isset($_POST[$i])){
	    					$can=$_POST['can'.$i];
	    					$art_id=$_POST['id'.$i];
			                $query="INSERT INTO  vive_fac ( usuario, cam, art_id, can, fecha_creada, fec, q1, q2, q3 ) VALUES ( '$usuario', '$cam', '$art_id', '$can', '$fecha_creada', '$fec', '$q1', '$q2', '$q3' )";
			                if( $mysqli->query( $query ) ){}
	    				}
	    			}

	    			?>
					<div id="modal1" class="modal">
						<div class="modal-content">
							<h3>Factura Registrada Exitosamente</h3>
							<p>La factura ha sido registrada exitosamente para el usuario <?php echo $usuario; ?></p>
						</div>
						<div class="modal-footer">
							<a href="#!" class="fondo3 btn-radius modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
						</div>
					</div>


					<div class="container margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable">
								<div class="row">
									<form name="importa" method="post" >

										<div class="row">
											<div class="col-xs-12 col-sm-4 col-sm-offset-4">
												<h1 class="center-align">Nueva Factura</h1>

												<div class="input-field col-xs-12">
													<select name="usuario" id="usuario">
														<option value="" disabled selected>Selecciona el Usuario</option>
												        	<?php $todoslosusuarios = get_users();
																foreach ( $todoslosusuarios as $user ) {
																	 $buscar=$user->user_login; ?>
																	 <option value="<?php echo $buscar; ?>"><?php echo $buscar; ?></option>
															<?php } ?>
														<label>Seleccionar</label>
													</select>
												</div>

											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-4 col-sm-offset-4">
												<div class="input-field col-xs-12">
													<select name="cam" id="cam">
														<option value="" disabled selected>Selecciona la Campaña</option>
														<?php $query = "SELECT * from vive_con ORDER BY cam ASC";
														$result = mysqli_query($mysqli, $query);
														if(mysqli_num_rows($result) != 0) {
															while($row = mysqli_fetch_assoc($result)) {
															$cam=$row['cam']; ?>
															<option value="<?php echo $cam; ?>">Campaña #<?php echo $cam; ?></option>
															<?php }
														} ?>
														<label>Seleccionar</label>
													</select>
												</div>
											</div>
										</div>
										<div class="row center-align">
											<button type="submit" value="siguiente" id="btn" name="btn" class="btn btn-radius fondo3 waves-effect waves-light">
												<i class="material-icons medium right">arrow_forward</i>
												SIGUIENTE
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<script>
						jQuery(document).ready(function(){
						    jQuery('.modal').modal();
						});
					</script>
	    		<?php }
	    	} else{ ?>			

		    	<div class="container margintop25 marginbot25">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card-panel z-depth-2 hoverable">
							<div class="row">
								<form name="importa" method="post" >

									<div class="row">
										<div class="col-xs-12 col-sm-4 col-sm-offset-4">
											<h1 class="center-align">Nueva Factura</h1>


											<div class="input-field col-xs-12">
												<input placeholder="Seleccionar gerente" type="text" name="usuario" id="usuario" class="autocomplete">
												<label for="usuario"></label>
									        </div>

										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-4 col-sm-offset-4">
											<div class="input-field col-xs-12">
												<select name="cam" id="cam">
													<option value="" disabled selected>Selecciona la Campaña</option>
													<?php $query = "SELECT * from vive_con ORDER BY cam ASC";
													$result = mysqli_query($mysqli, $query);
													if(mysqli_num_rows($result) != 0) {
														while($row = mysqli_fetch_assoc($result)) {
														$cam=$row['cam']; ?>
														<option value="<?php echo $cam; ?>">Campaña #<?php echo $cam; ?></option>
														<?php }
													} ?>
													<label>Seleccionar</label>
												</select>
											</div>
										</div>
									</div>
									<div class="row center-align">
										<button type="submit" value="siguiente" id="btn" name="btn" class="btn btn-radius fondo3 waves-effect waves-light">
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
	    jQuery('select').material_select();
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
	    jQuery('.datepicker').pickadate({
	    	monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		    selectMonths: true, // Creates a dropdown to control month
		    selectYears: 1, // Creates a dropdown of 15 years to control year
		    format: 'dd/mm/yyyy',
		    //min: '<?php //echo date("d/m/Y"); ?>',
		    today: 'Hoy',
			clear: 'Borrar',
			close: 'Cerrar',
		});
	  });
</script>