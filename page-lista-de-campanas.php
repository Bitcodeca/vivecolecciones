<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else { ?>

			<div class="container-fluid margintop25 marginbot25">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 		
		    		<div class="row">
						<?php
						$query = "SELECT * from vive_con ORDER BY cam ASC";
						$result = mysqli_query($mysqli, $query);
						if(mysqli_num_rows($result) != 0) {
							while($row = mysqli_fetch_assoc($result)) {
							$cam=$row['cam']; ?>

				        		<div class="col-xs-12 col-sm-4">
			        				<div class="card-panel z-depth-2 hoverable">
			        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">stars</i> Campaña #<?php echo $cam; ?></h3>
			        					<hr />
			        					<div class="row marginbot0">
				        					<div class="col-xs-12">
				        					<?php
												$stmt_ORDER = $mysqli->prepare("SELECT COUNT(DISTINCT usuario) FROM vive_fac WHERE cam=?");
							                    $stmt_ORDER->bind_param('s', $cam);
												$stmt_ORDER->execute();
												$stmt_ORDER->bind_result($gerentes);
							                    $stmt_ORDER->store_result();
							                    $stmt_ORDER->fetch();
							                    $stmt_ORDER->close();
											?>
			        							<h4 class="center-align bold marginbot0 margintop0">Gerentes: <?php echo $gerentes; ?></h4>
				        						<h5>Ganancia Vendedor: <b>Bsf <?php $valor=formato($row['gven']); echo $valor; ?></b></h5>
				        						<h5>Premio Básico: <b>Bsf <?php $valor=formato($row['pbas']); echo $valor; ?></b></h5>
				        						<h5>Distribución: <b>Bsf <?php $valor=formato($row['dis']); echo $valor; ?></b></h5>
				        						<h5>Gerencia: <b>Bsf <?php $valor=formato($row['ger']); echo $valor; ?></b></h5>
				        						<h5>Q1: <b>Bsf <?php $valor=formato($row['q1']); echo $valor; ?></b></h5>
				        						<h5>Q2: <b>Bsf <?php $valor=formato($row['q2']); echo $valor; ?></b></h5>
				        						<h5>Q3: <b>Bsf <?php $valor=formato($row['q3']); echo $valor; ?></b></h5>

											
				        					</div>
			        					</div>
			        					<hr />
			        					<div class="row">
			        						<div class="col-xs-12 center-align">
				        						<a class="waves-effect waves-light btn fondo3 btn-vive-lg hoverable modal-trigger" href="#<?php echo $row['id']; ?>">Ver Artíulos</a>
				        					</div>
			        					</div>
			        					<div class="row">
			        						<div class="col-xs-12 center-align">
				        						<a class="waves-effect waves-light btn fondo3 btn-vive-lg hoverable modal-trigger" href="#P<?php echo $row['id']; ?>">Ver Premios</a>
				        					</div>
			        					</div>
			        					<div class="row marginbot0">
			        						<div class="col-xs-12 center-align">
												<form role="form" method="post" name="contactform" action="/modificar-campana/" >
													<input type="hidden" name="buscar" id="buscar" value="<?php echo $cam; ?>" />
				        							<button type="submit" class="waves-effect waves-light btn fondo5 btn-vive-lg hoverable">Modificar</button>
				        						</form>
				        					</div>
			        					</div>
			        				</div>
								</div>
								<div id="<?php echo $row['id']; ?>" class="modal modal-fixed-footer">
									<div class="modal-content">
										<h3 class="center-align">Artículos en la campaña #<?php echo $cam; ?></h3>
										<table class="highlight responsive-table">
											<thead>
												<tr>
													<th class="bold">Nombre</th>
													<th class="bold">Costo</th>
													<th class="bold">Referencia</th>
												</tr>
											</thead>

											<tbody>
												<?php
												$query2 = "SELECT * from vive_cam WHERE cam='$cam'";
												$result2 = mysqli_query($mysqli, $query2);
												if(mysqli_num_rows($result2) != 0) {
													while($row2 = mysqli_fetch_assoc($result2)) { ?>
														<tr>
															<td><?php echo $row2['art']; ?></td>
															<td>Bsf <?php $valor=formato($row2['cos']); echo $valor; ?></td>
															<td><?php echo $row2['ref']; ?></td>
														</tr>
													<?php }
												} ?>
											</tbody>
										</table>
									</div>
									<div class="modal-footer">
										<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text fondo5 btn-radius">Cerrar</a>
									</div>
								</div>

								<div id="P<?php echo $row['id']; ?>" class="modal modal-fixed-footer">
									<div class="modal-content">
										<h3 class="center-align">Premios en la campaña #<?php echo $cam; ?></h3>
										<table class="highlight responsive-table">
											<thead>
												<tr>
													<th class="bold">Nombre</th>
													<th class="bold">Tipo</th>
													<th class="bold">Otro</th>
												</tr>
											</thead>

											<tbody>
												<?php
												$query2 = "SELECT * from vive_pre WHERE cam='$cam'";
												$result2 = mysqli_query($mysqli, $query2);
												if(mysqli_num_rows($result2) != 0) {
													while($row2 = mysqli_fetch_assoc($result2)) { ?>
														<tr>
															<td><?php echo $row2['articulo']; ?></td>
															<td><?php echo $row2['tipo']; ?></td>
															<td><?php echo $row2['otro']; ?></td>
														</tr>
													<?php }
												} ?>
											</tbody>
										</table>
									</div>
									<div class="modal-footer">
										<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text fondo5 btn-radius">Cerrar</a>
									</div>
								</div>
							<?php }
						} ?>
					</div>
				</div>
			</div>
	    <?php }
	} else{ ?>
		<h1> ACCESO NEGADO </h1>
	<?php	}  ?>
<?php } else {  
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit(); 
 } get_footer(); ?>
<script>
	jQuery(document).ready(function(){
		jQuery('.modal').modal();
	});
</script>