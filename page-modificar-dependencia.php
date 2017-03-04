<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else {
	    		if(isset($_POST['usuario'])){
	    			$usuario=$_POST['usuario'];
	    			if(isset($_POST['id'])){
	    				$id=$_POST['id'];
	    				$query = "DELETE FROM vive_sub WHERE id=$id";
						if ($mysqli->query( $query ) === TRUE) { }
	    			}
	    		?>
					<div class="container margintop25 marginbot25">	
			    		<div class="row">
							<div class="col-md-12">
								<div class="card-panel z-depth-2 hoverable">
							     	<h1 class="center-align">Modificar Dependencias de <?php echo $usuario; ?></h1>
									<table class="responsive-table highlight striped">
										<tbody>
											<?php
											$query = "SELECT * FROM vive_sub WHERE ger='$usuario'";
											$result = mysqli_query($mysqli, $query);
											if(mysqli_num_rows($result) != 0) {
												while($row = mysqli_fetch_assoc($result)) {
													$ger=$row['sub']; ?>
													<tr>
														<td>
															<h5>
																<?php echo $ger; ?>	
															</h5>
														</td>
														<td>
															<form role="form" method="post" name="contactform" action="" >
																<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" />
																<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
																<button type="submit" value="borrar" class="btn hoverable fondo5 waves-effect waves-light btn-radius secondary-content">
																	Borrar
																</button>
															</form>
														</td>
													</tr>
												<?php }
											}
											?>
										</tbody>
									</table>

								</div>
							</div>
						</div>
					</div>
				<?php
	    		}
	    		else {
	    	?>

			<div class="container margintop25 marginbot25">	
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Modificar Dependencias</h1>

							<div class="row">
								<div class="col-xs-12 col-sm-4 col-sm-offset-4">
									<form name="importa" method="post" >
										<div class="input-field">
											<select name="usuario" id="usuario">
												<option value="" disabled selected>Selecciona el Usuario</option>
													<?php
														$query = "SELECT * FROM vive_sub GROUP BY(ger)";
														$result = mysqli_query($mysqli, $query);
														if(mysqli_num_rows($result) != 0) {
															while($row = mysqli_fetch_assoc($result)) {
																$ger=$row['ger']; ?>
																<option value="<?php echo $ger; ?>"><?php echo $ger; ?></option>
															<?php
															}
														}
													?>
												<label>Seleccionar</label>
											</select>
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
				</div>
			</div>

	    	<?php 
	    	}
		}
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
	  });
</script>