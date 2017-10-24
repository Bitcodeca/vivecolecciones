<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    	<?php 
		} 
    	else {
    		if(isset($_POST['btn'])){
    			$usuario=$_POST['usuario'];

				if($_POST['btn']=='grabar') {
		    			$articulos=$_POST['articulos'];
		    			for ($i = 0; $i < $articulos; $i++) {
		    				if(isset($_POST['art'.$i])){
		    					$fecha=date("d/m/Y");
		    					$art=$_POST['col'.$i];
		    					$can=$_POST['can'.$i];
		    					$obs=$_POST['obs'.$i];
		    					$status="pendiente";
						        $stmt = $mysqli->prepare("INSERT INTO  vive_cambio ( usuario, fecha, art, can, obs, status ) VALUES ( ?, ?, ?, ?, ?, ? )");
						        $stmt->bind_param("ssssss", $usuario, $fecha, $art, $can, $obs, $status);
						        $stmt->execute();
						        $stmt->close();
	    					}
		    			}
	    		}
		    	?>
				<div class="container-fluid margintop25 marginbot25">	
			     	<h1 class="center-align">Cambios</h1>
		    		<div class="row">
						<div class="col-md-12">
							<div class="card-panel z-depth-2 hoverable">
								<form role="form" method="post" name="contactform" action="" class="margintop25" >
									<h2>Registrar nuevo cambio</h2>

									<?php
									$x=0;
						        	$query2 = "SELECT DISTINCT art_id FROM vive_fac WHERE usuario='$usuario'";
									$result2 = mysqli_query($mysqli, $query2);
									if(mysqli_num_rows($result2) != 0) { 
										while($row2 = mysqli_fetch_assoc($result2)) {
											$id=$row2['art_id'];

											$query = "SELECT var from vive_var WHERE art=$id";
											$result = mysqli_query($mysqli, $query);
											if(mysqli_num_rows($result) != 0) {
												while($row = mysqli_fetch_assoc($result)) {
													?>
													<div class="row">
														<div class="col-xs-12 col-sm-4 col-md-3 margintop10">
															<h4>Colección</h4>
															<p>
														    <input name="art<?php echo $x; ?>" type="checkbox" id="art<?php echo $x; ?>" />
														    <label for="art<?php echo $x; ?>"><?php echo $row['var']; ?></label>
														    </p>
														</div>
														<div class="col-xs-12 col-sm-2 col-md-2">
															<div class="input-field col-xs-12">
																<h4>Cantidad</h4>
												        		<input type="number" placeholder="Cantidad" name="can<?php echo $x; ?>"  id="can<?php echo $x; ?>">
															</div>
														</div>
														<div class="input-field col-xs-12 col-sm-6 col-md-7">
															<h4>Observación</h4>
										        			<textarea placeholder="Observación" name="obs<?php echo $x; ?>" id="obs<?php echo $x; ?>" class="materialize-textarea"></textarea>
												        </div>
													</div>
													<div class="divider"></div>
													<input type="hidden" name="col<?php echo $x; ?>" id="col<?php echo $x; ?>" value="<?php echo $row['var']; ?>" />
													<?php
													$x++;
												}
											}
										}
									}
									?>
									
									<input type="hidden" name="articulos" id="articulos" value="<?php echo $x; ?>" />
									<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" />
									<div class="row center-align marginbotmenos40">
										<button  type="submit" value="grabar" id="btn" name="btn" class="btn btn-radius fondo3 waves-effect waves-light margintop25">
											<i class="material-icons medium left">&#xE2C3;</i>
											REGISTRAR CAMBIO
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php
    		}
    		else {
	    		?>

			    	<div class="container margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable">
								<div class="row">
									<form name="importa" method="post" >

										<div class="row">
											<div class="col-xs-12 col-sm-4 col-sm-offset-4">
												<h1 class="center-align">Seleccionar gerente</h1>

												<div class="input-field col-xs-12">
													<input placeholder="Seleccionar gerente" type="text" name="usuario" id="usuario" class="autocomplete">
													<label for="usuario"></label>
										        </div>

											</div>
										</div>
										<div class="row center-align">
											<button type="submit" value="buscar" id="btn" name="btn" class="btn fondo3 btn-radius waves-effect waves-light">
												<i class="material-icons medium right">arrow_forward</i>
												BUSCAR
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				<?php
			} ?>
    		<?php 
		}
	}
	else{ ?>
		<h1> ACCESO NEGADO </h1>
		<?php
	}  ?>
	<?php 
}
else {
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit();
} get_footer(); 
 if($user_logged['rol']=='administrator'){ ?>
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
	  });
</script>
<?php }