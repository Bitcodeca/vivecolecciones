<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else { ?>

			<div class="container-fluid margintop25 marginbot25">
				<div class="row"> 		
		    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		    			<h1 class="center-align margintop0">Devoluciones</h1>
			        	<?php
						$query3 = "SELECT DISTINCT usuario from vive_dev ORDER BY usuario ASC";
						$result3 = mysqli_query($mysqli, $query3);
						if(mysqli_num_rows($result3) != 0) { ?>
							<ul class="collapsible popout imprimir" data-collapsible="expandable">
								<?php
								while($row3 = mysqli_fetch_assoc($result3)) {
									$usu=$row3['usuario'];
									$info=user_by_login($usu);
									?>
									<li class="nobreak">
										<div class="collapsible-header paddingtop5 paddingbot5">
											<h3 class="margintop0 marginbot0 marginleft25"><img src="<?php echo $info['avatarxs']; ?>" class="circle" height="48px" width="auto"> <?php echo $usu; ?></h3>
										</div>
										<div class="collapsible-body white">

											<table class="striped responsive-table">
										        <thead>
										          <tr>
										              <th data-field="id">Fecha</th>
										              <th data-field="id">Artículo</th>
										              <th data-field="id">Cantidad</th>
										          </tr>
										        </thead>

										        <tbody>
												<?php 
												$query = "SELECT * FROM vive_dev WHERE usuario='$usu'";
												$result = mysqli_query ($mysqli, $query);
												if(mysqli_num_rows($result) != 0) {
													while ($row = mysqli_fetch_assoc($result)) {
														$id=$row['id'];
														if($row['status']=='pendiente'){$color='yellow';}
														if($row['status']=='aprobado'){$color='fondo3';}
														if($row['status']=='negado'){$color='fondo5';}
														?>
														<tr>
													        <td><?php echo $row['fec']; ?></td>
													        <td><?php echo $row['art']; ?></td>
													        <td><?php echo $row['can']; ?></td>
													    </tr>
													<?php
													}
												} ?>
												</tbody>
											</table>

										</div>
									</li>
									<?php
								} ?>
							</ul> <?php
						} ?>
					</div>
				</div>


	    		<div class="row">
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable">
        					<?php
        					//MUESTRA TODAS LAS VARIACIONES DISPONIBLES
								$stmt0 = $mysqli->prepare("SELECT vive_var.var, vive_var.art, vive_var.cam, vive_cam.art FROM vive_var JOIN vive_cam ON vive_var.art=vive_cam.id WHERE vive_var.cam='20172' ORDER BY vive_var.art");
								$stmt0->execute();
								$stmt0->bind_result($varvar, $varart, $varcam, $camart);
								$stmt0->store_result();
								$array_cam=array();
							    while ($stmt0->fetch()) {
							    	echo $camart.' '.$varcam.' '.$varvar.'<br>';
							    }
							    $stmt0->close();
        					?>
        				</div>
    				</div>
				</div>
	    		<div class="row">
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable">

							<?php
							//MUESTRA TODAS LAS COLECCIONES EN CADA CAMPA;A
								$stmt0 = $mysqli->prepare("SELECT DISTINCT cam FROM vive_con");
								$stmt0->execute();
								$stmt0->bind_result($cam);
								$stmt0->store_result();
							    while ($stmt0->fetch()) {
									$stmt = $mysqli->prepare("SELECT sum(vive_fac.can), 
										 							 vive_cam.art,
										 							 vive_cam.cos 
										 							 FROM vive_fac JOIN vive_cam 
										 							 ON vive_fac.art_id=vive_cam.id 
																	 AND vive_cam.cam='$cam' 
																	 GROUP BY vive_fac.art_id");
									$stmt->execute();
									$stmt->bind_result($facCan, $camArt, $camCos);
									$stmt->store_result();
									$costo=0;
								    while ($stmt->fetch()) {
								    	$costo=$facCan*$camCos + $costo;
								    	?>
								    	<p> <?php echo $camArt.' Colecciones:'.$facCan; ?></p>
								    	<?
									}
									$stmt->close();
									?>
									<h5>Campaña #<?php echo $cam; ?>: <b>Bsf <?php $valor=formato($costo); echo $valor; ?></b></h5>
									<?php
								}
								$stmt0->close();
								?>
        				</div>
					</div>
				</div>
	    		<div class="row">
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable">
							<?php
							//ARROJA TODAS LAS AVERIAS REGISTRADAS CON SU VARIACION Y ARTICULO
								$stmt = $mysqli->prepare("SELECT SUM(ABS(vive_averia.can)), 
																 vive_var.art, 
																 vive_cam.art, 
																 vive_var.var 
																 FROM vive_averia 
																 JOIN vive_var ON vive_averia.art=vive_var.var 
																 JOIN vive_cam ON vive_var.art=vive_cam.id 
																 GROUP BY vive_var.art");
								$stmt->execute();
								$stmt->bind_result($averiaCan, $varArt, $camArt, $varVar);
								$stmt->store_result();
								$costo=0;
							    while ($stmt->fetch()) {
							    	$costo=$facCan*$camCos + $costo;
							    	?>
							    	<p> <?php echo 'Coleccion:'. $camArt.' Variacion:'.$varVar.' Cantidad: '.abs($averiaCan); ?></p>
							    	<?
								}
								$stmt->close();
							?>
        				</div>
					</div>
				</div>

        		<div class="row">
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable" style="overflow-x: scroll;">
        					
								<?php
								//ARROJA TODOS LOS PREMIOS SELECCIONADOS POR CADA CAMPA;A
								$stmt0 = $mysqli->prepare("SELECT DISTINCT cam FROM vive_con");
								$stmt0->execute();
								$stmt0->bind_result($cam);
								$stmt0->store_result();
							    while ($stmt0->fetch()) {
									$stmt = $mysqli->prepare("SELECT sum(vive_fac_prem.cantidad), 
										 							 vive_fac_prem.nombre
										 							 FROM vive_fac_prem 
																	 GROUP BY vive_fac_prem.nombre");
									$stmt->execute();
									$stmt->bind_result($premioCan, $premioNombre);
									$stmt->store_result();
									$costo=0;
								    while ($stmt->fetch()) {
								    	?>
								    	<p> <?php echo $premioNombre.' Colecciones:'.$premioCan; ?></p>
								    	<?
									}
									$stmt->close();
								}
								$stmt0->close();
								?>
        				</div>
					</div>
				</div>


	    		<div class="row">
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable">
        				<!-- ARROJA UN GRAFICO DE TODOS LOS PREMIOS EN LA BASE DE DATOS -->
        				 	<div id="premios"></div>
        				</div>
					</div>
				</div>
			</div>
	    <?php }
	} else{
	    require_once 'api/vive-db.php'; ?>
		

        		<div class="row">
	        		<div class="col-xs-12 col-sm-12 col-md-7">
        				<div class="card-panel z-depth-2 hoverable" style="overflow-x: scroll;">
        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">trending_up</i> Ingresos Diarios</h3>
							<div id="columnchart_material"></div>
        				</div>
					</div>
	        		<div class="col-xs-12 col-sm-12 col-md-5">
        				<div class="card-panel z-depth-2 hoverable" style="overflow-x: scroll;">
        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">trending_up</i> Ingresos Diarios</h3>
							<div id="chart2"></div>
        				</div>
					</div>
				</div>
	<?php	}  ?>
<?php } else {  
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit(); 
 } get_footer(); ?>

 <script>
    google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawBasic);
	function drawBasic() {

	      var data = google.visualization.arrayToDataTable([
			    	['Premio', 'Cantidad total'],

			<?php
			$stmt0 = $mysqli->prepare("SELECT DISTINCT cam FROM vive_con");
			$stmt0->execute();
			$stmt0->bind_result($cam);
			$stmt0->store_result();
		    while ($stmt0->fetch()) {
				$stmt = $mysqli->prepare("SELECT sum(vive_fac_prem.cantidad), 
					 							 vive_fac_prem.nombre
					 							 FROM vive_fac_prem 
												 GROUP BY vive_fac_prem.nombre");
				$stmt->execute();
				$stmt->bind_result($premioCan, $premioNombre);
				$stmt->store_result();
				$total=0;
			    while ($stmt->fetch()) {
			    	echo "['".$premioNombre."',".$premioCan."],";
			    	$total++;
				}
				$stmt->close();
			}
			$stmt0->close();
			?>
	      ]);

	      var options = {
	        hAxis: {
	          minValue: 0
	        },
	        bars: 'horizontal',
	        height: <?php echo $total*50; ?>,
	      };

	      var chart = new google.charts.Bar(document.getElementById('premios'));

	      chart.draw(data, options);
	    }

 </script>