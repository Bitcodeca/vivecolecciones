<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){

	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
    	<?php } else {
				if(isset($_POST['buscar'])){

					if($_POST['btn']=='agregar'){

						$cam=$_POST['buscar'];
						$art=$_POST['art'];
						$var=$_POST['var'];

						$stmt2 = $mysqli->prepare('SELECT id FROM vive_cam WHERE art = ? AND cam = ?');
						$stmt2->bind_param('ss', $art, $cam);
						$stmt2->execute();
						$stmt2->bind_result($art_id);
						$stmt2->store_result();
						$stmt2->fetch();

            			$query="INSERT INTO  vive_var ( cam, art, var ) VALUES ( '$cam', '$art_id', '$var' )";
						if ($mysqli->query( $query ) === TRUE) { }

					} elseif ($_POST['btn']=='borrar'){
						$id=$_POST['id'];
						$query = "DELETE FROM vive_var WHERE id=$id";
						if ($mysqli->query( $query ) === TRUE) { }
					}

					?>
						<div class="container margintop25 marginbot25">
							<div class="col-xs-12">
								<div class="card-panel z-depth-2 hoverable">
									<div class="row">
										<h1 class="center-align">Campaña #<?php echo $_POST['buscar']; ?></h1>
									</div>
									<?php
										$s=$_POST['buscar'];
										$query = "SELECT * from vive_var WHERE cam=$s";
										$result = mysqli_query($mysqli, $query);
										if(mysqli_num_rows($result) != 0) {
											?>
											<table class="striped responsive-table">
										        <thead>
										          <tr>
										              <th class="paddingtop5 paddingbot5">Campaña</th>
										              <th class="paddingtop5 paddingbot5">Artículo</th>
										              <th class="paddingtop5 paddingbot5">Variación</th>
										              <th class="paddingtop5 paddingbot5">Acción</th>
										          </tr>
										        </thead>

										        <tbody>
													<?php
													while($row = mysqli_fetch_assoc($result)) {
														$id=$row['id'];
														$art_id=$row['art'];
														$stmt2 = $mysqli->prepare('SELECT art FROM vive_cam WHERE id = ?');
														$stmt2->bind_param('s', $art_id);
														$stmt2->execute();
														$stmt2->bind_result($art);
														$stmt2->store_result();
														$stmt2->fetch();
														?>
														<tr data-name="<?php echo $row['usuario']; ?>" data-estado="<?php echo $row['estado']; ?>">
													        <td class="paddingtop5 paddingbot5"><?php echo $row['cam']; ?></td>
													        <td class="paddingtop5 paddingbot5"><?php echo $art; ?></td>
													        <td class="paddingtop5 paddingbot5"><?php echo $row['var']; ?></td>
													        <td class="paddingtop5 paddingbot5">
																<form role="form" method="post" name="<?php echo $id; ?>" action="" >
																	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
																	<input type="hidden" name="buscar" id="buscar" value="<?php echo $_POST['buscar']; ?>" />
																	<button type="subtmit" id="btn" name="btn" value="borrar" class="btn-floating waves-effect waves-light fondo3">
																		<i class="material-icons left">close</i>
																		BORRAR
																	</button>
																</form>
													        </td>
													    </tr>
														<?php
													}
													?>
										        </tbody>
										    </table>
											<?php
										} else {
											?>
											<h1>No se encontró ninguna variación registrada</h1>
											<?php
										}
									?>
									<div class="row center-align marginbotmenos40">
										<a class="waves-effect waves-light btn fondo2 btn-radius" href="#modal1"><i class="material-icons left">add</i> Agregar Nueva Variación</a>
									</div>

									<div id="modal1" class="modal modal-fixed-footer">
										<form role="form" method="post" action="" >
											<div class="modal-content">
												<h4>Agregar Variación</h4>
												<div class="col-xs-12 col-sm-6 input-field">

													<input placeholder="Seleccionar colección" type="text" name="art" id="art" class="autocomplete">
													<label for="art"></label>

												</div>
												<div class="col-xs-12 col-sm-6 paddingtop10">
													<input type="text" placeholder="NOMBRE DE LA VARIACIÓN" name="var"  id="var" required>
												</div>
											</div>
											<div class="modal-footer">
												<button  type="submit" name="btn" id="btn" value="agregar" class="btn hoverable fondo2 waves-effect waves-light btn-radius" type="submit">
													<i class="material-icons left">add</i>
													AGREGAR
												</button>
												<input type="hidden" name="buscar" id="buscar" value="<?php echo $_POST['buscar']; ?>" />
												<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">CANCELAR</a>
											</div>
										</form>
									</div>
        


								</div>
							</div>
						</div>
					<?php
				} else {
					?>
					<div class="container margintop25 marginbot25">
						<div class="col-xs-12">
							<div class="card-panel z-depth-2 hoverable">
								<div class="row marginbot0">
									<div class="col-xs-12 col-sm-4 col-sm-offset-4">
										<h1 class="center-align">Seleccionar Campaña</h1>

										<form name="importa" method="post" >
											<div class="row">
												<div class="input-field col-xs-12">
													<select name="buscar" id="buscar">
														<option value="" disabled selected>Selecciona la campaña</option>
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
											<div class="row center-align marginbotmenos40">
												<button type="submit" class="btn btn-radius fondo3 waves-effect waves-light">
													<i class="material-icons medium left">search</i>
													BUSCAR VARIACIONES
												</button>
											</div>
										</form>

									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					}
			}
		} else{
			?>
			<h1>ACCESO NEGADO</h1>
			<?php
		} ?>
<?php } else {
		header("Location: http://app.vivecolecciones.com.ve/");
		exit(); 
 } get_footer(); ?>
<script>
	jQuery(document).ready(function() {
	    jQuery('select').material_select();
	    jQuery('.modal').modal();

		<?php
			if(isset($_POST['buscar'])){
				?>
				jQuery('input.autocomplete').autocomplete({
					data: {
						<?php
							$s=$_POST['buscar'];
							$query = "SELECT * from vive_cam WHERE cam=$s";
							$result = mysqli_query($mysqli, $query);
							if(mysqli_num_rows($result) != 0) {
								while($row = mysqli_fetch_assoc($result)) {
									$art=$row['art'];
									?>
							  			"<?php echo $art; ?>": null,
									<?php
								}
							}
						?>
					}
				});
				<?php
			}
		?>
	  });
</script>