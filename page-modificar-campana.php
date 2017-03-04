<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){

	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
    	<?php } else {
				if(isset($_POST['buscar'])){
				?>
					<div class="container margintop25 marginbot25">
						<div class="col-xs-12">
							<div class="card-panel z-depth-2 hoverable">
								<div class="row">
									<h1 class="center-align">Búsqueda</h1>
								</div>
								<form ng-submit="submit(contactform)" role="form" method="post" name="contactform" action="" class="margintop25" >

								<?php
									
									$s=$_POST['buscar'];
									$query = "SELECT * from vive_con WHERE cam=$s";
									$result = mysqli_query($mysqli, $query);
									if(mysqli_num_rows($result) != 0) {
										while($row = mysqli_fetch_assoc($result)) {
											$id=$row['id']; ?>
											<div class="row marginbot0">
												<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
													<h4>Número de campaña</h4>
									        		<input type="text" placeholder="Campaña" name="cam"  id="cam"  value="<?php echo $row['cam'];?>" readonly required>
										        </div>
									        </div>
											<div class="row marginbot0">
												<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
													<h4>Ganancia de Vendedor</h4>
									        		<input type="text" placeholder="Ganancia de Vendedor" name="gven"  id="gven"  value="<?php echo $row['gven'];?>" required>
										        </div>
									        </div>
											<div class="row marginbot0">
												<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
													<h4>Premio Básico</h4>
									        		<input type="text" placeholder="Premio Básico" name="pbas"  id="pbas" value="<?php echo $row['pbas'];?>" required>
										        </div>
									        </div>
											<div class="row marginbot0">
												<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
													<h4>Distribución</h4>
									        		<input type="text" placeholder="Distribución" name="dis"  id="dis" value="<?php echo $row['dis'];?>" required>
										        </div>
									        </div>
											<div class="row marginbot0">
												<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
													<h4>Gerencia</h4>
									        		<input type="text" placeholder="Gerencia" name="ger"  id="ger" value="<?php echo $row['ger'];?>" required>
										        </div>
									        </div>
											<div class="row marginbot0">
												<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
													<h4>Q1</h4>
									        		<input type="text" placeholder="Q1" name="q1"  id="q1" value="<?php echo $row['q1'];?>" required>
										        </div>
									        </div>
											<div class="row marginbot0">
												<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
													<h4>Q2</h4>
									        		<input type="text" placeholder="Q2" name="q2"  id="q2" value="<?php echo $row['q2'];?>" required>
										        </div>
									        </div>
											<div class="row">
												<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
													<h4>Q3</h4>
									        		<input type="text" placeholder="Q3" name="q3"  id="q3" value="<?php echo $row['q3'];?>" required>
										        </div>
									        </div>
										<?php }
									}
									?>
									<div class="divider"></div>
									<h3>Colecciones</h3>
									<?php
									$x=0;
									$query = "SELECT * from vive_cam WHERE cam=$s";
									$result = mysqli_query($mysqli, $query);
									if(mysqli_num_rows($result) != 0) {
										while($row = mysqli_fetch_assoc($result)) { ?>
											<div class="row marginbot25">
												<div class="input-field col-xs-12 col-sm-4">
													<h5>Nombre</h5>
									        		<input type="text" placeholder="Artículo" name="art<?php echo $x; ?>"  id="art<?php echo $x; ?>" value="<?php echo $row['art'];?>">
										        </div>
												<div class="input-field col-xs-12 col-sm-4">
													<h5>Costo</h5>
									        		<input type="text" placeholder="Costo" name="cos<?php echo $x; ?>"  id="cos<?php echo $x; ?>" value="<?php echo $row['cos'];?>">
										        </div>
												<div class="input-field col-xs-12 col-sm-4">
													<h5>Referencia</h5>
									        		<input type="text" placeholder="Referencia" name="ref<?php echo $x; ?>"  id="ref<?php echo $x; ?>" value="<?php echo $row['ref'];?>">
										        </div>
									        </div>
											<input type="hidden" name="facid<?php echo $x; ?>" id="facid<?php echo $x; ?>" value="<?php echo $row['id']; ?>" />
											<?php
											$x++;
										}
									}
									?>
									<div class="divider"></div>
									<h3>Premios</h3>
									<?php
									$y=0;
									$query = "SELECT * from vive_pre WHERE cam=$s";
									$result = mysqli_query($mysqli, $query);
									if(mysqli_num_rows($result) != 0) {
										while($row = mysqli_fetch_assoc($result)) { ?>
											<div class="row marginbot25">
												<div class="input-field col-xs-12 col-sm-4">
													<h5>Nombre</h5>
									        		<input type="text" placeholder="Artículo" name="part<?php echo $y; ?>"  id="part<?php echo $y; ?>" value="<?php echo $row['articulo'];?>">
										        </div>

								                <div class="input-field col-xs-12 col-sm-4">
													<h5>Tipo</h5>
								                    <select name="ptipo<?php echo $y; ?>"  id="ptipo<?php echo $y; ?>">
														<option value="<?php echo $row['tipo']; ?>"><?php echo $row['tipo']; ?></opcion>
														<?php
															$premio=premiosTipo();
															foreach ($premio as $opcion) {
																if ($opcion!=$row['tipo']) {
																 	?>
																	<option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></opcion>
																 	<?php
																 } ?>
															<?php
															}
														?>
													</select>
								                </div>

												<div class="input-field col-xs-12 col-sm-4">
													<h5>Otro</h5>
									        		<input type="text" placeholder="Referencia" name="potro<?php echo $y; ?>"  id="potro<?php echo $y; ?>" value="<?php echo $row['otro'];?>">
										        </div>
									        </div>
											<input type="hidden" name="preid<?php echo $x; ?>" id="preid<?php echo $x; ?>" value="<?php echo $row['id']; ?>" />
											<?php
											$y++;
										}
									}
								?>
									<input type="hidden" name="articulos" id="articulos" value="<?php echo $x; ?>" />
									<input type="hidden" name="premios" id="premios" value="<?php echo $y; ?>" />
									<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
									<div class="row center-align">
										<button  type="submit" name="btn" id="btn" value="borrar" class="btn btn-radius fondo5 waves-effect waves-light margintop25" type="submit">
										<i class="material-icons medium left">cancel</i>
											BORRAR CAMPAÑA
										</button>
										<button  type="submit" name="btn" id="btn" value="modificar" class="btn btn-radius fondo3 waves-effect waves-light margintop25" type="submit">
											<i class="material-icons medium left">mode_edit</i>
											MODIFICAR CAMPAÑA
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				<?php
				} else {
					if($_POST['btn']=='modificar'){

						$id=$_POST['id'];
						$cam=$_POST['cam'];
						$gven=$_POST['gven'];
						$pbas=$_POST['pbas'];
						$dis=$_POST['dis'];
						$ger=$_POST['ger'];
						$q1=$_POST['q1'];
						$q2=$_POST['q2'];
						$q3=$_POST['q3'];
						$articulos=$_POST['articulos'];
						$premios=$_POST['premios'];

						$query = "UPDATE vive_con SET gven=$gven, pbas=$pbas, dis=$dis, ger=$ger, q1=$q1, q2=$q2, q3=$q3 WHERE id=$id";
						if ($mysqli->query( $query ) === TRUE) { }

						for ($i = 0; $i < $articulos ; $i++) {
							if (!empty($_POST['art'.$i])) {

			                    $art=$_POST['art'.$i];
			                    $cos=$_POST['cos'.$i];
			                    $ref=$_POST['ref'.$i];
			                    $facid=$_POST['facid'.$i];

	                			$query="UPDATE vive_cam SET art='$art', cos='$cos', ref='$ref' WHERE id=$facid";
								
								if ($mysqli->query( $query ) === TRUE) { }

							} else{
			                    $facid=$_POST['facid'.$i];
								$query = "DELETE FROM vive_cam WHERE id=$facid";
								if ($mysqli->query( $query ) === TRUE) { }
							}
						}

						for ($i = 0; $i < $premios ; $i++) {
							if (!empty($_POST['part'.$i])) {

			                    $art=$_POST['part'.$i];
			                    $tipo=$_POST['ptipo'.$i];
			                    $otro=$_POST['potro'.$i];
			                    $preid=$_POST['preid'.$i];

	                			$query="UPDATE vive_pre SET articulo='$art', tipo='$tipo', otro='$otro' WHERE id=$preid";
								
								if ($mysqli->query( $query ) === TRUE) { }

							} else{
			                    $preid=$_POST['preid'.$i];
								$query = "DELETE FROM vive_pre WHERE id=$preid";
								if ($mysqli->query( $query ) === TRUE) { }
							}
						}
					} elseif ($_POST['btn']=='borrar'){
						$id=$_POST['id'];
						$cam=$_POST['cam'];
						$query = "DELETE FROM vive_con WHERE id=$id";
						if ($mysqli->query( $query ) === TRUE) { }
						$query = "DELETE FROM vive_cam WHERE cam=$cam";
						if ($mysqli->query( $query ) === TRUE) { }
						$query = "DELETE FROM vive_pre WHERE cam=$cam";
						if ($mysqli->query( $query ) === TRUE) { }
					}
					?>
					<div class="container margintop25 marginbot25">
						<div class="col-xs-12">
							<div class="card-panel z-depth-2 hoverable">
								<div class="row">
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
											<div class="row center-align marginbotmenos60">
												<button type="submit" class="btn btn-radius fondo3 waves-effect waves-light">
													<i class="material-icons medium left">search</i>
													BUSCAR CAMPAÑA
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
	  });
</script>