<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	$gerente_logged=$user_logged["login"];
	require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php
	    }
	    else {
	    	if(isset($_POST['btn'])){
	    		if(isset($_POST['telefono']) && isset($_POST['cedula']) && isset($_POST['nacimiento']) && isset($_POST['estado']) && isset($_POST['direccion']) && isset($_POST['comentario']) ){
	    			if(!empty($_POST['telefono']) && !empty($_POST['cedula']) && !empty($_POST['nacimiento']) && !empty($_POST['estado']) && !empty($_POST['direccion']) && !empty($_POST['comentario']) ){

		    			$telefono=$_POST['telefono'];
		    			$cedula=$_POST['cedula'];
		    			$nacimiento=$_POST['nacimiento'];
		    			$estado=$_POST['estado'];
		    			$direccion=$_POST['direccion'];
		    			$comentario=$_POST['comentario'];


	                    $stmt_ORDER = $mysqli->prepare("SELECT id FROM vive_usu_inf WHERE usuario=?");
	                    $stmt_ORDER->bind_param('s', $gerente_logged);
	                    $stmt_ORDER->execute();
	                    $stmt_ORDER->store_result();
	                    if($stmt_ORDER->num_rows > 0){
	                        $stmt_2 = $mysqli->prepare("UPDATE vive_usu_inf SET telefono=?, cedula=?, estado=?, direccion=?, comentario=?, nacimiento=? WHERE usuario=?");
	                        $stmt_2->bind_param("sssssss", $telefono, $cedula, $estado, $direccion, $comentario, $nacimiento, $gerente_logged);
	                        $stmt_2->execute();
				            $stmt_2->close();
	                    }
	                    else{
			    			$stmt = $mysqli->prepare("INSERT INTO vive_usu_inf ( usuario, telefono, cedula, estado, direccion, comentario, nacimiento ) VALUES ( ?, ?, ?, ?, ?, ?, ? )");
				            $stmt->bind_param("sssssss", $gerente_logged, $telefono, $cedula, $estado, $direccion, $comentario, $nacimiento);
				            $stmt->execute();
				            $stmt->close();
	                    }
	                    $stmt_ORDER->close();

		        	}
	    		}
	    	}
	     	?>
			<style>
			.picker__select--month, .picker__select--year {display: block; }
			.um-profile-nav {display: none;}
			.um-col-alt {display: none;}
			.um-profile.um-editing { padding-bottom: 0px; margin-bottom: 0px!important; }
			.um-meta-text { display: none; }
			.collection {overflow: auto;}
			</style>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
							<?php
							echo do_shortcode( '[ultimatemember form_id=9]' );
		                    $stmt_ORDER = $mysqli->prepare("SELECT id, telefono, cedula, estado, direccion, comentario, nacimiento FROM vive_usu_inf WHERE usuario=?");
		                    $stmt_ORDER->bind_param('s', $gerente_logged);
		                    $stmt_ORDER->execute();
		                    $stmt_ORDER->bind_result($id, $telefono, $cedula, $estado, $direccion, $comentario, $nacimiento);
		                    $stmt_ORDER->store_result();
		                    $nuevo=$stmt_ORDER->num_rows;
		                    //if($nuevo > 0){
		                    	$stmt_ORDER->fetch();
		                    	?>
		                    	<ul class="collection with-header">
							        <li class="collection-header"><h3 class="bold"><i class="material-icons color1 left">person</i> <?php echo $gerente_logged; ?></h3></li>
							        <li class="collection-item"><h4><i class="material-icons color1 left">phone</i> <?php echo $telefono; ?></h4></li>
							        <li class="collection-item"><h4><i class="material-icons color1 left">branding_watermark</i> <?php echo $cedula; ?></h4></li>
							        <li class="collection-item"><h4><i class="material-icons color1 left">date_range</i> <?php echo $nacimiento; ?></h4></li>
							        <li class="collection-item"><h4><i class="material-icons color1 left">location_on</i> <?php echo $estado; ?></h4></li>
							        <li class="collection-item"><h4><i class="material-icons color1 left">location_on</i> <?php echo $direccion; ?></h4></li>
							        <li class="collection-item"><h4><i class="material-icons color1 left">content_paste</i> <?php echo $comentario; ?></h4></li>
							    </ul>
							    <a class="waves-effect waves-light btn btn-radius fondo2 right hoverable" href="#modal1"><i class="material-icons left">create</i> ACTUALIZAR</a>
							    <div id="modal1" class="modal">
									<form name="importa" method="post" >

									    <div class="modal-content">

										    <ul class="collection with-header">
										        <li class="collection-header">
										        	<h3 class="bold"><i class="material-icons color1 left">person</i> <?php echo $gerente_logged; ?></h3>
									        	</li>
										        <li class="collection-item">
													<div class="input-field">
														<i class="material-icons color1 prefix">phone</i>
														<input id="telefono" name="telefono" type="number" class="validate" value="<?php echo $telefono; ?>" required>
														<label for="telefoo">Teléfono</label>
													</div>
										        </li>
										        <li class="collection-item">
													<div class="input-field">
														<i class="material-icons color1 prefix">branding_watermark</i>
														<input id="cedula" name="cedula" type="number" class="validate" value="<?php echo $cedula; ?>" required>
														<label for="cedula">Cédula</label>
													</div>
										        </li>
										        <li class="collection-item">
													<div class="input-field">
														<i class="material-icons color1 prefix">date_range</i>
														<input id="nacimiento" name="nacimiento" type="date" class="datepicker"  data-value="<?php echo $nacimiento; ?>" required>
														<label for="nacimiento">Fecha de nacimiento</label>
													</div>
										        </li>
										        <li class="collection-item">
													<div class="input-field">
														<i class="material-icons color1 prefix">location_on</i>
														<select name="estado" id="estado" required>
															<option value="" disabled selected>Selecciona el estado</option>
															<?php
																$estado=estado();
																foreach ($estado as $opcion) { ?>
																	<option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></opcion>
																<?php
																}
															?>
														</select>
														<label for="estado">Estado</label>
													</div>
										        </li>
										        <li class="collection-item">
													<div class="input-field">
														<i class="material-icons color1 prefix">location_on</i>
														<input id="direccion" name="direccion" type="text" class="validate" value="<?php echo $direccion; ?>" required>
														<label for="direccion">Dirección</label>
													</div>
										        </li>
										        <li class="collection-item">
										        	<div class="input-field">
														<i class="material-icons color1 prefix">mode_edit</i>
														<textarea id="comentario" name="comentario" class="materialize-textarea" required><?php echo $comentario; ?></textarea>
														<label for="comentario">Comentarios</label>
													</div>
										        </li>
										    </ul>

									    </div>
									    <div class="modal-footer">
									  		<a href="#!" class="btn btn-radius fondo5 hoverable modal-action modal-close waves-effect waves-green">CANCELAR</a>
									  		<button type="submit" value="modificar" name="btn" id="btn" class="btn btn-radius fondo3 hoverable waves-effect waves-green">MODIFICAR</a>
									    </div>

								    </form>
								</div>
		                    	<?php
		                   // }
		                    //else{
		                    	?>
		                    	<!--
								 <div id="modal1" class="modal">
									<form name="importa" method="post" >

									    <div class="modal-content">
											<h1 class="center-align">Ingresar Datos Personales</h1>
										    <ul class="collection with-header">
										        <li class="collection-header">
										        	<h3 class="bold"><?php //echo $user_logged['nombre'].' '.$user_logged['apellido']; ?></h3>
									        	</li>
										        <li class="collection-item">
										        	<h4 class="bold"><i class="material-icons color1 left">person</i> <?php //echo $gerente_logged; ?></h4>
									        	</li>
										        <li class="collection-item">
													<div class="input-field">
														<i class="material-icons color1 prefix">phone</i>
														<input id="telefono" name="telefono" type="number" class="validate" required>
														<label for="telefoo">Teléfono</label>
													</div>
										        </li>
										        <li class="collection-item">
													<div class="input-field">
														<i class="material-icons color1 prefix">branding_watermark</i>
														<input id="cedula" name="cedula" type="number" class="validate" required>
														<label for="cedula">Cédula</label>
													</div>
										        </li>
										        <li class="collection-item">
													<div class="input-field">
														<i class="material-icons color1 prefix">date_range</i>
														<input id="nacimiento" name="nacimiento" type="date" class="datepicker" required>
														<label for="nacimiento">Fecha de nacimiento</label>
													</div>
										        </li>
										        <li class="collection-item">
													<div class="input-field">
														<i class="material-icons color1 prefix">location_on</i>
														<select name="estado" id="estado" required>
															<option value="" disabled selected>Selecciona el estado</option>
															<?php
																$estado=estado();
																foreach ($estado as $opcion) { ?>
																	<option value="<?php //echo $opcion; ?>"><?php //echo $opcion; ?></opcion>
																<?php
																}
															?>
														</select>
														<label for="estado">Estado</label>
													</div>
										        </li>
										        <li class="collection-item">
													<div class="input-field">
														<i class="material-icons color1 prefix">location_on</i>
														<input id="direccion" name="direccion" type="text" class="validate" required>
														<label for="direccion">Dirección</label>
													</div>
										        </li>
										        <li class="collection-item">
										        	<div class="input-field">
														<i class="material-icons color1 prefix">mode_edit</i>
														<textarea id="comentario" name="comentario" class="materialize-textarea" required></textarea>
														<label for="comentario">Comentarios</label>
													</div>
										        </li>
										    </ul>

									    </div>
									    <div class="modal-footer">
									  		<button type="submit" value="modificar" name="btn" id="btn" class="btn btn-radius fondo3 hoverable modal-action modal-close waves-effect waves-green">MODIFICAR</a>
									    </div>

								    </form>
								</div>-->
		                    	<?php
		                    //}
		                    $stmt_ORDER->close();
		                    $mysqli->close();
							?>
						</div>
					</div>
				</div>
			</div>


		<?php
	}
} else {
		header("Location: ".site_url());
		exit();
 } get_footer(); ?>
<script>
	jQuery(document).ready(function(){
		jQuery('select').material_select();
		jQuery('.datepicker').pickadate({
		    selectMonths: true, // Creates a dropdown to control month
		    selectYears: 100, // Creates a dropdown of 15 years to control year
	    	monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		    format: 'dd/mm/yyyy',
		    today: 'Hoy',
			clear: 'Borrar',
			close: 'Cerrar',
		    max: '31/12/1999',
		});
		<?php
			//if($nuevo==0){
				?>
				/*
				jQuery('.modal').modal({ dismissible: false	});
				jQuery('#modal1').modal('open');
				*/
				<?php
			//} else{
				?>
	    		jQuery('.modal').modal();
	    		<?php
			//}
		?>
	});
</script>
