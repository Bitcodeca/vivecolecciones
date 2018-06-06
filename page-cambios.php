<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else {
			if(isset($_POST['btn'])){
				$varId=$_POST['id'];
				$status=$_POST['status'.$varId];
				$comentario=$_POST['comentario'.$varId];

				$query = "UPDATE vive_cambio SET status='$status', comentario='$comentario' WHERE id='$varId'";
				if ($mysqli->query( $query ) === TRUE) { }
			} elseif ($_POST['borrar']){
				$artId=$_POST['id'];
				$query2 = "DELETE FROM vive_cambio WHERE id=$artId";
				if ($mysqli->query( $query2 ) === TRUE) {
				}

			}
			?>
			<div class="container-fluid margintop25 marginbot25">
				<div class="row"> 		
		    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		    			<h1 class="center-align margintop0">Cambios</h1>
			        	<?php
						$query3 = "SELECT DISTINCT usuario from vive_cambio ORDER BY usuario ASC";
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
										              <th data-field="id">Status</th>
										              <th data-field="id">Fecha</th>
										              <th data-field="id">Artículo</th>
										              <th data-field="id">Cantidad</th>
										              <th data-field="id">Observación</th>
										              <th data-field="id">Comentario</th>
										              <th data-field="id">Acción</th>
										          </tr>
										        </thead>

										        <tbody>
												<?php 
												$query = "SELECT * FROM vive_cambio WHERE usuario='$usu'";
												$result = mysqli_query ($mysqli, $query);
												if(mysqli_num_rows($result) != 0) {
													while ($row = mysqli_fetch_assoc($result)) {
														$id=$row['id'];
														if($row['status']=='pendiente'){$color='yellow';}
														if($row['status']=='aprobado'){$color='fondo3';}
														if($row['status']=='negado'){$color='fondo5';}
														?>
														<tr>
													        <td class="<?php echo $color; ?>"><?php echo $row['status']; ?></td>
													        <td><?php echo $row['fecha']; ?></td>
													        <td><?php echo $row['art']; ?></td>
													        <td><?php echo $row['can']; ?></td>
													        <td><?php echo $row['obs']; ?></td>
													        <td><?php echo $row['comentario']; ?></td>
													        <td>
													        	<a id="btn" name="btn" class="btn-floating waves-effect waves-light fondo3" href="#modal<?php echo $id; ?>">
													        		<i class="material-icons left">create</i>
																	EDITAR
																</a>
															</td>
													    </tr>
													    <div id="modal<?php echo $id; ?>" class="modal">
															<form role="form" method="post" name="form<?php echo $row['id']; ?>" action="" >
															    <div class="modal-content">
															        <h3><?php echo $row['usuario']; ?></h3>
															        <h4><?php echo $row['art']; ?></h4>
															        <div class="col s12">
																	    <p>
																	      <input name="status<?php echo $row['id']; ?>" type="radio" id="statusp<?php echo $row['id']; ?>" value="pendiente" <?php if($row['status']=='pendiente'){echo 'checked';} ?> />
																	      <label for="statusp<?php echo $row['id']; ?>">Pendiente</label>
																	    </p>
																	    <p>
																	      <input name="status<?php echo $row['id']; ?>" type="radio" id="statusa<?php echo $row['id']; ?>" value="aprobado" <?php if($row['status']=='aprobado'){echo 'checked';} ?> />
																	      <label for="statusa<?php echo $row['id']; ?>">Aprobado</label>
																	    </p>
																	    <p>
																	      <input name="status<?php echo $row['id']; ?>" type="radio" id="statusn<?php echo $row['id']; ?>" value="negado" <?php if($row['status']=='negado'){echo 'checked';} ?> />
																	      <label for="statusn<?php echo $row['id']; ?>">Negado</label>
																	    </p>
																    </div>
															        <div class="input-field col s12 marginbot25">
															            <textarea id="comentario<?php echo $row['id']; ?>" name="comentario<?php echo $row['id']; ?>" class="materialize-textarea" data-length="500" required></textarea>
															            <label for="comentario">Comentario</label>
															        </div>
															    </div>

																<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />

															    <div class="modal-footer">
																	<button type="submit" name="borrar" id="borrar" value="borrar" class="btn hoverable fondo5 waves-effect waves-light btn-radius" type="submit">
																		<i class="material-icons left">mode_edit</i>
																		BORRAR
																	</button>
																	<button type="submit" name="btn" id="btn" value="editar" class="btn hoverable fondo2 waves-effect waves-light btn-radius" type="submit">
																		<i class="material-icons left">mode_edit</i>
																		EDITAR
																	</button>
																	<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">CERRAR</a>
															    </div>
														    </form>
														</div>
													<?php
													}
												} ?>
												</tbody>
											</table>

										</div>
									</li> <?php
								} ?>
							</ul> <?php
						} ?>
					</div>
				</div>
				<div class="row">
					<button onclick="imprimir()" class="btn hoverable fondo3 waves-effect waves-light btn-radius"><i class="material-icons left">print</i> Imprimir</button>
	            </div>
	            <div class="row">
					<button onclick="expandAll()" class="btn hoverable fondo3 waves-effect waves-light btn-radius"><i class="material-icons left">add</i> Abrir todos</button>
					<button onclick="collapseAll()" class="btn hoverable fondo3 waves-effect waves-light btn-radius"><i class="material-icons left">remove</i> Cerrar todos</button>
	            </div>
	    		<div class="row">
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable">
							<?php
								$stmt = $mysqli->prepare('SELECT SUM(ABS(vive_cambio.can)) FROM vive_cambio');
								$stmt->execute();
								$stmt->bind_result($total);
							    $stmt->fetch();
								$stmt->close();
							?>
        					<h3>Total: <?php echo $total; ?></h3>
        				 	<div id="cambios"></div>
        				</div>
					</div>
				</div>
				<script>
					function imprimir() {
					    window.print();
					}
					function expandAll(){
					  jQuery(".collapsible-header").addClass("active");
					  jQuery(".collapsible").collapsible({accordion: false});
					}

					function collapseAll(){
					  jQuery(".collapsible-header").removeClass(function(){
					    return "active";
					  });
					  jQuery(".collapsible").collapsible({accordion: true});
					  jQuery(".collapsible").collapsible({accordion: false});
					}
				</script>
			</div>
	    <?php }
	} 
	elseif ($user_logged['rol']=='Gerente') {
		require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) {
	    	?>
			<h1>ERROR DE CONEXIÓN</h1>
	    	<?php
	    }
	    else {
			$gerente_logged=$user_logged["login"];

			if($_POST['btn']=='grabar') {
	    			$articulos=$_POST['articulos'];
	    			echo $articulos;
	    			for ($i = 0; $i < $articulos; $i++) {
	    				if(isset($_POST['art'.$i])){
	    					$fecha=date("d/m/Y");
	    					$usuario=$gerente_logged;
	    					$art=$_POST['col'.$i];
	    					$can=$_POST['can'.$i];
	    					$obs=$_POST['obs'.$i];
					        $stmt = $mysqli->prepare("INSERT INTO  vive_cambio ( usuario, fecha, art, can, obs ) VALUES ( ?, ?, ?, ?, ? )");
					        $stmt->bind_param("sssss", $usuario, $fecha, $art, $can, $obs);
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

							<?php
								$stmt = $mysqli->prepare("SELECT id FROM vive_cambio_con WHERE usuario=?");
					            $stmt->bind_param("s", $gerente_logged);
					            $stmt->execute();
					            $stmt->store_result();
					            $numberofrows = $stmt->num_rows;
					            if($numberofrows>0){
									?>

									<div>
										<form role="form" method="post" name="contactform" action="" class="margintop25" >
											<h2>Registrar nuevo cambio</h2>

											<?php
											$stmt0 = $mysqli->prepare("SELECT DISTINCT cam FROM vive_fac WHERE usuario = ? ORDER BY id DESC");
											$stmt0->bind_param('s', $gerente_logged);
											$stmt0->execute();
											$stmt0->bind_result($query_cam);
											$stmt0->store_result();
											$array_cam=array();
										    while ($stmt0->fetch()) {
										    	array_push($array_cam, $query_cam);
										    }
										    $stmt0->close();

										    $cam=$array_cam[0];
											$x=0;
								        	$query2 = "SELECT DISTINCT art_id FROM vive_fac WHERE usuario='$gerente_logged' AND cam='$cam'";
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
											<div class="row center-align marginbotmenos40">
												<button  type="submit" value="grabar" id="btn" name="btn" class="btn btn-radius fondo3 waves-effect waves-light margintop25">
													<i class="material-icons medium left">&#xE2C3;</i>
													REGISTRAR CAMBIO
												</button>
											</div>
										</form>
									</div>
									<?php
								}
								else{
							    	?>
									<h1 class="center-align">No puede ingresar un cambio</h1>
							    	<?php
								}
            					$stmt->close();
							?>


						</div>
					</div>
				</div>
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h2>Cambios Registrados</h2>
				        	<div class="imprimir" id="Container">
								<table class="striped responsive-table">
							        <thead>
							          <tr>
							              <th data-field="id">Status</th>
							              <th data-field="id">Fecha</th>
							              <th data-field="name">Artículo</th>
							              <th data-field="price">Cantidad</th>
							              <th data-field="price">Observación</th>
							              <th data-field="price">Comentario</th>
							          </tr>
							        </thead>

							        <tbody>
										<?php
											$stmt = $mysqli->prepare('SELECT fecha, art, can, obs, status, comentario FROM vive_cambio WHERE usuario = ?');
											$stmt->bind_param('s', $gerente_logged);
											$stmt->execute();
											$stmt->bind_result($fec, $art, $can, $obs, $status, $comentario);
											$stmt->store_result();
										    while ($stmt->fetch()) {
												$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fec);
												$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
												$fechaunixdep=strtotime($fechacambiadadep);
												if($status=='pendiente'){$color='yellow';}
												if($status=='aprobado'){$color='fondo3';}
												if($status=='negado'){$color='fondo5';}
												?>
												<tr class="mix" data-myorder="<?php echo $fechaunixdep; ?>" >
											        <td class="<?php echo $color; ?>"><?php echo $status; ?></td>
											        <td><?php echo $fec; ?></td>
											        <td><?php echo $art; ?></td>
											        <td><?php echo $can; ?></td>
											        <td><?php echo $obs; ?></td>
											        <td><?php echo $comentario; ?></td>
											    </tr>
												<?php
										    }
											$stmt->close();
										?>
							        </tbody>
							    </table>
					            <div class="row margintop25">
					                <div class="pager-list center-align marginbot25 margintop25"></div>
					            </div>
								<div class="row marginbotmenos40">
									<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="default">Default</button>
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="myorder:asc">Fechas anteriores</button>
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius active" data-sort="myorder:desc">Fechas recientes</button>
							  	</div>
						    </div>


						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}  

	elseif($user_logged['rol']=='Analista'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    	<?php 
	    } 
	    else {
			$gerente_logged=$user_logged['login'];
			$stmt0 = $mysqli->prepare("SELECT gerente FROM vive_analista WHERE analista = ?");
			$stmt0->bind_param('s', $gerente_logged);
			$stmt0->execute();
			$stmt0->bind_result($query_gerente);
			$stmt0->store_result();
			$array_analista=array();
		    while ($stmt0->fetch()) {
		    	array_push($array_analista, $query_gerente);
		    }
		    $stmt0->close();
		    $buscar_gerente = join("','",$array_analista);

if(isset($_POST['btn'])){
				$varId=$_POST['id'];
				$status=$_POST['status'.$varId];
				$comentario=$_POST['comentario'.$varId];

				$query = "UPDATE vive_cambio SET status='$status', comentario='$comentario' WHERE id='$varId'";
				if ($mysqli->query( $query ) === TRUE) { }
			}
			?>
			<div class="container-fluid margintop25 marginbot25">
				<div class="row"> 		
		    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		    			<h1 class="center-align margintop0">Cambios</h1>
			        	<?php
						$query3 = "SELECT DISTINCT usuario from vive_cambio WHERE usuario IN ('$buscar_gerente') ORDER BY usuario ASC";
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
										              <th data-field="id">Status</th>
										              <th data-field="id">Fecha</th>
										              <th data-field="id">Artículo</th>
										              <th data-field="id">Cantidad</th>
										              <th data-field="id">Observación</th>
										              <th data-field="id">Comentario</th>
										              <th data-field="id">Acción</th>
										          </tr>
										        </thead>

										        <tbody>
												<?php 
												$query = "SELECT * FROM vive_cambio WHERE usuario='$usu'";
												$result = mysqli_query ($mysqli, $query);
												if(mysqli_num_rows($result) != 0) {
													while ($row = mysqli_fetch_assoc($result)) {
														$id=$row['id'];
														if($row['status']=='pendiente'){$color='yellow';}
														if($row['status']=='aprobado'){$color='fondo3';}
														if($row['status']=='negado'){$color='fondo5';}
														?>
														<tr>
													        <td class="<?php echo $color; ?>"><?php echo $row['status']; ?></td>
													        <td><?php echo $row['fecha']; ?></td>
													        <td><?php echo $row['art']; ?></td>
													        <td><?php echo $row['can']; ?></td>
													        <td><?php echo $row['obs']; ?></td>
													        <td><?php echo $row['comentario']; ?></td>
													        <td>
													        	<a id="btn" name="btn" class="btn-floating waves-effect waves-light fondo3" href="#modal<?php echo $id; ?>">
													        		<i class="material-icons left">create</i>
																	EDITAR
																</a>
															</td>
													    </tr>
													    <div id="modal<?php echo $id; ?>" class="modal">
															<form role="form" method="post" name="form<?php echo $row['id']; ?>" action="" >
															    <div class="modal-content">
															        <h3><?php echo $row['usuario']; ?></h3>
															        <h4><?php echo $row['art']; ?></h4>
															        <div class="col s12">
																	    <p>
																	      <input name="status<?php echo $row['id']; ?>" type="radio" id="statusp<?php echo $row['id']; ?>" value="pendiente" <?php if($row['status']=='pendiente'){echo 'checked';} ?> />
																	      <label for="statusp<?php echo $row['id']; ?>">Pendiente</label>
																	    </p>
																	    <p>
																	      <input name="status<?php echo $row['id']; ?>" type="radio" id="statusa<?php echo $row['id']; ?>" value="aprobado" <?php if($row['status']=='aprobado'){echo 'checked';} ?> />
																	      <label for="statusa<?php echo $row['id']; ?>">Aprobado</label>
																	    </p>
																	    <p>
																	      <input name="status<?php echo $row['id']; ?>" type="radio" id="statusn<?php echo $row['id']; ?>" value="negado" <?php if($row['status']=='negado'){echo 'checked';} ?> />
																	      <label for="statusn<?php echo $row['id']; ?>">Negado</label>
																	    </p>
																    </div>
															        <div class="input-field col s12 marginbot25">
															            <textarea id="comentario<?php echo $row['id']; ?>" name="comentario<?php echo $row['id']; ?>" class="materialize-textarea" data-length="500" required></textarea>
															            <label for="comentario">Comentario</label>
															        </div>
															    </div>

																<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />

															    <div class="modal-footer">
																	<button type="submit" name="btn" id="btn" value="editar" class="btn hoverable fondo2 waves-effect waves-light btn-radius" type="submit">
																		<i class="material-icons left">mode_edit</i>
																		EDITAR
																	</button>
																	<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">CERRAR</a>
															    </div>
														    </form>
														</div>
													<?php
													}
												} ?>
												</tbody>
											</table>

										</div>
									</li> <?php
								} ?>
							</ul> <?php
						} ?>
					</div>
				</div>
				<div class="row">
					<button onclick="imprimir()" class="btn hoverable fondo3 waves-effect waves-light btn-radius"><i class="material-icons left">print</i> Imprimir</button>
	            </div>
	            <div class="row">
					<button onclick="expandAll()" class="btn hoverable fondo3 waves-effect waves-light btn-radius"><i class="material-icons left">add</i> Abrir todos</button>
					<button onclick="collapseAll()" class="btn hoverable fondo3 waves-effect waves-light btn-radius"><i class="material-icons left">remove</i> Cerrar todos</button>
	            </div>
	    		<div class="row">
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable">
							<?php
								$stmt = $mysqli->prepare("SELECT SUM(ABS(vive_cambio.can)) FROM vive_cambio WHERE usuario IN ('$buscar_gerente')");
								$stmt->execute();
								$stmt->bind_result($total);
							    $stmt->fetch();
								$stmt->close();
							?>
        					<h3>Total: <?php echo $total; ?></h3>
        				 	<div id="cambios"></div>
        				</div>
					</div>
				</div>
				<script>
					function imprimir() {
					    window.print();
					}
					function expandAll(){
					  jQuery(".collapsible-header").addClass("active");
					  jQuery(".collapsible").collapsible({accordion: false});
					}

					function collapseAll(){
					  jQuery(".collapsible-header").removeClass(function(){
					    return "active";
					  });
					  jQuery(".collapsible").collapsible({accordion: true});
					  jQuery(".collapsible").collapsible({accordion: false});
					}
				</script>
			</div>
			<?php
	    }
    }
} else {  
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit(); 
 } get_footer(); ?>
<script>
	jQuery(document).ready(function() {
	    jQuery('select').material_select();
	    jQuery('textarea').characterCounter();
		function checkWidth() {
            var w = jQuery(window).width();
            if (w>992){
		        jQuery('#Container').mixItUp({
		        	layout: { display: 'table-row' },
		            animation: { duration: 200 },
		            pagination: { limit: 12, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
		            selectors: { sort: '.sort', pagersWrapper: '.pager-list' }
		        });
            } else {
		        jQuery('#Container').mixItUp({
		        	layout: { display: 'inline-block' },
		            animation: { duration: 200 },
		            pagination: { limit: 12, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
		            selectors: { sort: '.sort', pagersWrapper: '.pager-list' }
		        });
            } 
        }
        checkWidth();
        jQuery(window).resize(checkWidth);
	  });
</script>
<?php
	if($user_logged['rol']=='administrator'){
		?>
		 <script>
		    google.charts.load('current', {packages: ['corechart', 'bar']});
			google.charts.setOnLoadCallback(drawBasic);
			function drawBasic() {

			      var data = google.visualization.arrayToDataTable([
					    	['Artículo', 'Cantidad total'],

							<?php
								$stmt = $mysqli->prepare("SELECT SUM(ABS(vive_cambio.can)), 
																 vive_var.art, 
																 vive_cam.art, 
																 vive_var.var 
																 FROM vive_cambio 
																 JOIN vive_var ON vive_cambio.art=vive_var.var 
																 JOIN vive_cam ON vive_var.art=vive_cam.id 
																 GROUP BY vive_var.art");
								$stmt->execute();
								$stmt->bind_result($averiaCan, $varArt, $camArt, $varVar);
								$stmt->store_result();
								$total=0;
							    while ($stmt->fetch()) {
							    	echo "['".$varVar."',".$averiaCan."],";
							    	$total++;
								}
								$stmt->close();
							?>
			      ]);

			      var options = {
			        hAxis: {
			          minValue: 0
			        },
			        bars: 'horizontal',
			        height: <?php echo $total*50; ?>,
			      };

			      var chart = new google.charts.Bar(document.getElementById('cambios'));

			      chart.draw(data, options);
			    }

		 </script>
		<?php
	}
?>