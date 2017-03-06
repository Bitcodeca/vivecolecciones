<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else {
	    		if(isset($_POST['pen'])){
	    			if($_POST['pen']=='borrar'){

						$iddep=$_POST['id'];
						$query2 = "DELETE FROM vive_pen WHERE id=$iddep";
						if ($mysqli->query( $query2 ) === TRUE) { ?>
							<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
								<div class="modal-content">
									<h4>DEPÓSITO BORRADO</h4>
								</div>
								<div class="modal-footer">
									<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
								</div>
							</div> 
						<?php }

	    			}elseif($_POST['pen']=='editar'){
	    				$iddep=$_POST['id'];
						$fechadep=$_POST['fecha'];
						$referenciadep=$_POST['referencia'];
						$montodep=$_POST['monto'];
						$bancodep=$_POST['banco'];
						$statusdep=$_POST['status'];
						$camdep=$_POST['cam'];
						$comentariodep=$_POST['comentario'];


						if($statusdep=='aprobado'){
							
							$query = "SELECT * from vive_dep WHERE fecha='$fechadep' AND referencia='$referenciadep' AND monto='$montodep' AND banco='$bancodep' AND usuario='vacio'";
							$result = mysqli_query($mysqli, $query);
							if(mysqli_num_rows($result) != 0) {
								$query2 = "DELETE FROM vive_pen WHERE id=$iddep";
				                if( $mysqli->query( $query2 ) ){
				                	$query="INSERT INTO  vive_dep ( fecha, referencia, monto, banco, status, cam ) VALUES ( '$fechadep', '$referenciadep', '$montodep', '$bancodep', '$statusdep', '$camdep' )";
				            		if( $mysqli->query( $query2 ) ){ ?>
										<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
											<div class="modal-content">
												<h4>DEPÓSITO BORRADO</h4>
											</div>
											<div class="modal-footer">
												<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
											</div>
										</div> 
									<?php }
				                }
							} else { ?>
								<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
									<div class="modal-content">
										<h4>ERROR</h4>
										<h5>No se puede aprobar el depósito si no se encuentra en la base de datos</h5>
									</div>
									<div class="modal-footer">
										<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
									</div>
								</div> 
							<?php
							}
						} else {

							$query2 = "UPDATE vive_pen SET fecha='$fechadep', referencia='$referenciadep', monto='$montodep', banco='$bancodep', status='$statusdep', cam='$camdep', comentario='$comentariodep' WHERE id=$iddep";
							if ($mysqli->query( $query2 ) === TRUE) { ?>
								<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
									<div class="modal-content">
										<h4>DEPÓSITO MODIFICADO</h4>
									</div>
									<div class="modal-footer">
										<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
									</div>
								</div> 
							<?php } else {
								 printf("Error: %s\n", $mysqli->error);
							}
						}
	    			}

	    		} elseif(isset($_POST['dep'])){
	    			if($_POST['dep']=='borrar'){


						$iddep=$_POST['id'];
						$query2 = "DELETE FROM vive_dep WHERE id=$iddep";
						if ($mysqli->query( $query2 ) === TRUE) { ?>
							<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
								<div class="modal-content">
									<h4>DEPÓSITO BORRADO</h4>
								</div>
								<div class="modal-footer">
									<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
								</div>
							</div> 
						<?php }

	    			}elseif($_POST['dep']=='editar'){
	    				$iddep=$_POST['id'];
						$fechadep=$_POST['fecha'];
						$referenciadep=$_POST['referencia'];
						$montodep=$_POST['monto'];
						$bancodep=$_POST['banco'];
						$statusdep=$_POST['status'];
						$camdep=$_POST['cam'];
						$comentariodep=$_POST['comentario'];

						$query2 = "UPDATE vive_dep SET fecha='$fechadep', referencia='$referenciadep', monto='$montodep', banco='$bancodep', status='$statusdep', cam='$camdep', comentario='$comentariodep' WHERE id=$iddep";
						if ($mysqli->query( $query2 ) === TRUE) { ?>
							<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
								<div class="modal-content">
									<h4>DEPÓSITO MODIFICADO</h4>
								</div>
								<div class="modal-footer">
									<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
								</div>
							</div> 
						<?php } else {
							 printf("Error: %s\n", $mysqli->error);
						}
	    			}
	    		}
	    		if(isset($_POST['btn'])){
	    			$buscar_query=array();
	    			$buscar_final='';
	    			$x=0;
	    			if(isset($_POST['usuario']) && !empty($_POST['usuario'])){
	    				$var=" usuario='".$_POST['usuario']."'";
	    				array_push($buscar_query, $var);
	    				$x++;
	    			}
	    			if(isset($_POST['referencia']) && !empty($_POST['referencia'])){
	    				$var=" referencia='".$_POST['referencia']."'";
	    				array_push($buscar_query, $var);
	    				$x++;
	    			}
	    			if(isset($_POST['status']) && !empty($_POST['status'])){
	    				$var=" status='".$_POST['status']."'";
	    				array_push($buscar_query, $var);
	    				$x++;
	    			}
	    			if(isset($_POST['banco']) && !empty($_POST['banco'])){
	    				$var=" banco='".$_POST['banco']."'";
	    				array_push($buscar_query, $var);
	    				$x++;
	    			}
	    			if(isset($_POST['fecha']) && !empty($_POST['fecha'])){
	    				$var=" fecha='".$_POST['fecha']."'";
	    				array_push($buscar_query, $var);
	    				$x++;
	    			}
	    			if(isset($_POST['cam']) && !empty($_POST['cam'])){
	    				$var=" cam='".$_POST['cam']."'";
	    				array_push($buscar_query, $var);
	    				$x++;
	    			}
					if($x!=0){
	    				$y=0;
	    				foreach ($buscar_query as $value) {
	    					if($y==0){
	    						$buscar_final='WHERE '.$value;
	    						$y++;
	    					} else{
	    						$buscar_final=$buscar_final.' AND '.$value;
	    					}
	    				}
	    			}
	    			 ?>
			    	<div class="container-fluid margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable">
								<h1 class="center-align">Depósitos</h1>
								<?php
									if(isset($_POST['usuario'])){
										?>
										<h2 class="center-align"><?php echo $_POST['usuario']; ?></h2>
										<?php
									}
								?>
								<div class="row">
									<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="default">Default</button>
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="myorder:asc">Fechas anteriores</button>
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius active" data-sort="myorder:desc">Fechas recientes</button>
							  	</div>
							  	<div class="row">
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="name:asc">Ordenar por Banco (A-Z)</button>
	    							<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="name:desc">Ordenar por Banco (Z-A)</button>
							  	</div>
							  	<div class="row">
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="cam:asc">Ordenar por campaña (A-Z)</button>
	    							<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="cam:desc">Ordenar por campaña (Z-A)</button>
							  	</div>
					        	<div class="imprimir" id="Container">
									<table class="striped responsive-table">
								        <thead>
								          <tr>
								              <th data-field="id">Status</th>
								              <th data-field="id">Fecha</th>
								              <th data-field="id">Usuario</th>
								              <th data-field="name">Banco</th>
								              <th data-field="price">Referencia</th>
								              <th data-field="price">Monto</th>
								              <th data-field="price">Campaña</th>
								              <th data-field="price">Acción</th>
								          </tr>
								        </thead>

								        <tbody>

											<?php 
											$query = "SELECT * FROM vive_pen ".$buscar_final;
											$result = mysqli_query ($mysqli, $query);
											if(mysqli_num_rows($result) != 0) {
												while ($row = mysqli_fetch_assoc($result)) { 
													if($row['status']=='aprobado'){$clase='fondo3';}elseif($row['status']=='vacio'){$clase='grey lighten-5';}elseif($row['status']=='pendiente'){$clase='yellow';}elseif($row['status']=='negado'){$clase='fondo5';}
													$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $row['fecha']);
													$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
													$fechaunixdep=strtotime($fechacambiadadep);
													?>
													<tr class="mix" data-myorder="<?php echo $fechaunixdep; ?>"  data-name="<?php echo $row['banco']; ?>" data-cam="<?php echo $row['cam']; ?>">
												        <td class="<?php echo $clase; ?>"><?php echo $row['status']; ?></td>
												        <td><?php echo $row['fecha']; ?></td>
												        <td><?php echo $row['usuario']; ?></td>
												        <td><?php echo $row['banco']; ?></td>
												        <td><?php echo $row['referencia']; ?></td>
												        <td>Bsf <?php if (is_numeric($row['monto'])){$valor=formato($row['monto']); echo $valor;}else{echo $row['monto'];} ?></td>
												        <td><?php echo $row['cam']; ?></td>
												        <td>
												        	<a class="btn hoverable fondo3 waves-effect waves-light btn-radius" href="#<?php echo $row['id']; ?>">EDITAR</a>
														</td>
												    </tr>
													<div id="<?php echo $row['id']; ?>" class="modal">
														<form role="form" method="post" name="<?php echo $row['id']; ?>" action="" >
															<div class="modal-content">
																<h4 class="bold">MODIFICAR</h4>
																<div class="input-field col-xs-12">
																	<h4>Fecha</h4>
																	<input type="date" class="datepicker" id="fecha" name="fecha" data-value="<?php echo $row['fecha'];?>">
																</div>
																<div class="input-field col-xs-12">
																	<h4>Usuario</h4>
													        		<input type="text" placeholder="Campaña" name="usuario"  id="usuario"  value="<?php echo $row['usuario'];?>" readonly required>
																</div>
																<div class="input-field col-xs-12">
																	<h4>Banco</h4>

																	<p>
																		<input name="banco" type="radio" id="<?php echo $row['banco']; ?>" value="<?php echo $row['banco']; ?>" checked />
																		<label for="<?php echo $row['banco']; ?>"><?php echo $row['banco']; ?></label>
																	</p>
																	<?php
																		$bancos=bancos();
																		foreach ($bancos as $opcion) {
																			if($opcion!=$row['banco']){ ?>
																				<p>
																					<input name="banco" type="radio" id="<?php echo $opcion; ?>" value="<?php echo $opcion; ?>" />
																					<label for="<?php echo $opcion; ?>"><?php echo $opcion; ?></label>
																				</p>
																			<?php }
																		}
																	?>
																</div>
																<div class="input-field col-xs-12">
																	<h4>Referencia</h4>
													        		<input type="text" placeholder="Campaña" name="referencia"  id="referencia"  value="<?php echo $row['referencia'];?>" required>
																</div>
																<div class="input-field col-xs-12">
																	<h4>Monto</h4>
													        		<input type="text" placeholder="Campaña" name="monto"  id="monto"  value="<?php echo $row['monto'];?>" required>
																</div>
																<div class="input-field col-xs-12">
																	<h4>Campaña</h4>

																	<p>
																		<input name="cam" type="radio" id="<?php echo $row['cam']; ?>" value="<?php echo $row['cam']; ?>" checked />
																		<label for="<?php echo $row['cam']; ?>"><?php echo $row['cam']; ?></label>
																	</p>
																		<?php
																		$usuario=$row['usuario'];
																		$query3 = "SELECT DISTINCT cam from vive_fac WHERE usuario='$usuario' ORDER BY cam ASC";
																		$result3 = mysqli_query($mysqli, $query3);
																		if(mysqli_num_rows($result3) != 0) {
																			while($row3 = mysqli_fetch_assoc($result3)) {
																				$cam=$row3['cam'];
																				if($row['cam']!=$cam){
																					?>
																					<p>
																						<input name="cam" type="radio" id="<?php echo $cam; ?>" value="<?php echo $cam; ?>" />
																						<label for="<?php echo $cam; ?>"><?php echo $cam; ?></label>
																					</p>
																					<?php
																				}
																			}
																		} ?>
																</div>
																<div class="input-field col-xs-12">
																	<h4>Status</h4>

																	<p>
																		<input name="status" type="radio" id="<?php echo $row['status']; ?>" value="<?php echo $row['status']; ?>" checked />
																		<label for="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></label>
																	</p>
																	<?php
																		$status=status();
																		foreach ($status as $opcion) {
																			if($opcion!=$row['status']){ ?>
																				<p> 
																					<input name="status" type="radio" id="<?php echo $opcion; ?>" value="<?php echo $opcion; ?>" />
																					<label for="<?php echo $opcion; ?>"><?php echo $opcion; ?></label>
																				</p>
																			<?php }
																		}
																	?>
																</div>
																<div class="input-field col-xs-12 marginbot25">
																	<h4>Descripción</h4>
													        		<textarea id="descripcion" class="materialize-textarea" length="500"></textarea>
																</div>
															</div>
															<div class="modal-footer">
																	<button  type="submit" name="pen" id="pen" value="borrar" class="btn hoverable fondo5 waves-effect waves-light btn-radius" type="submit">
																		<i class="material-icons left">cancel</i>
																			BORRAR DEPÓSITO
																	</button>
																	<button  type="submit" name="pen" id="pen" value="editar" class="btn hoverable fondo2 waves-effect waves-light btn-radius" type="submit">
																		<i class="material-icons left">mode_edit</i>
																			EDITAR
																	</button>
																	<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
																	<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">CANCELAR</a>
															</div>
														</form>
													</div>
												<?php
												}
											}
											$query = "SELECT * FROM vive_dep ".$buscar_final;
											$result = mysqli_query ($mysqli, $query);
											if(mysqli_num_rows($result) != 0) {
												while ($row = mysqli_fetch_assoc($result)) { 
													if($row['status']=='aprobado'){$clase='fondo3';}elseif($row['status']=='vacio'){$clase='grey lighten-5';}elseif($row['status']=='pendiente'){$clase='yellow';}elseif($row['status']=='negado'){$clase='fondo5';}
													$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $row['fecha']);
													$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
													$fechaunixdep=strtotime($fechacambiadadep);
													?>
													<tr class="mix" data-myorder="<?php echo $fechaunixdep; ?>"  data-name="<?php echo $row['banco']; ?>" data-cam="<?php echo $row['cam']; ?>">
												        <td class="<?php echo $clase; ?>"><?php echo $row['status']; ?></td>
												        <td><?php echo $row['fecha']; ?></td>
												        <td><?php echo $row['usuario']; ?></td>
												        <td><?php echo $row['banco']; ?></td>
												        <td><?php echo $row['referencia']; ?></td>
												        <td>Bsf <?php if (is_numeric($row['monto'])){$valor=formato($row['monto']); echo $valor;}else{echo $row['monto'];} ?></td>
												        <td><?php echo $row['cam']; ?></td>
												        <td>
												        	<a class="btn hoverable fondo3 waves-effect waves-light btn-radius" href="#<?php echo $row['id']; ?>">EDITAR</a>
														</td>
												    </tr>
													<div id="<?php echo $row['id']; ?>" class="modal">
														<form role="form" method="post" name="<?php echo $row['id']; ?>" action="" >
															<div class="modal-content">
																<h4 class="bold">MODIFICAR</h4>
																<div class="input-field col-xs-12">
																	<h4>Fecha</h4>
																	<input type="date" class="datepicker" id="fecha" name="fecha" data-value="<?php echo $row['fecha'];?>">
																</div>
																<div class="input-field col-xs-12">
																	<h4>Usuario</h4>
													        		<input type="text" placeholder="Campaña" name="usuario"  id="usuario"  value="<?php echo $row['usuario'];?>" readonly required>
																</div>
																<div class="input-field col-xs-12">
																	<h4>Banco</h4>

																	<p>
																		<input name="banco" type="radio" id="<?php echo $row['banco']; ?>" value="<?php echo $row['banco']; ?>" checked />
																		<label for="<?php echo $row['banco']; ?>"><?php echo $row['banco']; ?></label>
																	</p>
																	<?php
																		$bancos=bancos();
																		foreach ($bancos as $opcion) {
																			if($opcion!=$row['banco']){ ?>
																				<p>
																					<input name="banco" type="radio" id="<?php echo $opcion; ?>" value="<?php echo $opcion; ?>" />
																					<label for="<?php echo $opcion; ?>"><?php echo $opcion; ?></label>
																				</p>
																			<?php }
																		}
																	?>
																</div>
																<div class="input-field col-xs-12">
																	<h4>Referencia</h4>
													        		<input type="text" placeholder="Campaña" name="referencia"  id="referencia"  value="<?php echo $row['referencia'];?>" required>
																</div>
																<div class="input-field col-xs-12">
																	<h4>Monto</h4>
													        		<input type="text" placeholder="Campaña" name="monto"  id="monto"  value="<?php echo $row['monto'];?>" required>
																</div>
																<div class="input-field col-xs-12">
																	<h4>Campaña</h4>

																	<p>
																		<input name="cam" type="radio" id="<?php echo $row['cam']; ?>" value="<?php echo $row['cam']; ?>" checked />
																		<label for="<?php echo $row['cam']; ?>"><?php echo $row['cam']; ?></label>
																	</p>
																		<?php
																		$usuario=$row['usuario'];
																		$query3 = "SELECT DISTINCT cam from vive_fac WHERE usuario='$usuario' ORDER BY cam ASC";
																		$result3 = mysqli_query($mysqli, $query3);
																		if(mysqli_num_rows($result3) != 0) {
																			while($row3 = mysqli_fetch_assoc($result3)) {
																				$cam=$row3['cam'];
																				if($row['cam']!=$cam){
																					?>
																					<p>
																						<input name="cam" type="radio" id="<?php echo $cam; ?>" value="<?php echo $cam; ?>" />
																						<label for="<?php echo $cam; ?>"><?php echo $cam; ?></label>
																					</p>
																					<?php
																				}
																			}
																		} ?>
																</div>
																<div class="input-field col-xs-12">
																	<h4>Status</h4>

																	<p>
																		<input name="status" type="radio" id="<?php echo $row['status']; ?>" value="<?php echo $row['status']; ?>" checked />
																		<label for="<?php echo $row['status']; ?>"><?php echo $row['status']; ?></label>
																	</p>
																	<?php
																		$status=status();
																		foreach ($status as $opcion) {
																			if($opcion!=$row['status']){ ?>
																				<p> 
																					<input name="status" type="radio" id="<?php echo $opcion; ?>" value="<?php echo $opcion; ?>" />
																					<label for="<?php echo $opcion; ?>"><?php echo $opcion; ?></label>
																				</p>
																			<?php }
																		}
																	?>
																</div>
																<div class="input-field col-xs-12 marginbot25">
																	<h4>Descripción</h4>
													        		<textarea id="descripcion" class="materialize-textarea" length="500"></textarea>
																</div>
															</div>
															<div class="modal-footer">
																	<button  type="submit" name="dep" id="dep" value="borrar" class="btn hoverable fondo5 waves-effect waves-light btn-radius" type="submit">
																		<i class="material-icons left">cancel</i>
																			BORRAR DEPÓSITO
																	</button>
																	<button  type="submit" name="dep" id="dep" value="editar" class="btn hoverable fondo2 waves-effect waves-light btn-radius" type="submit">
																		<i class="material-icons left">mode_edit</i>
																			EDITAR
																	</button>
																	<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
																	<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">CANCELAR</a>
															</div>
														</form>
													</div>
												<?php
												}
											}
											?>
								        </tbody>
								    </table>


					            </div>
					            <div class="row">
					                <div class="pager-list center-align marginbot25 margintop25"></div>
					            </div>
					            <div class="row">
									<button onclick="imprimir()" class="btn hoverable fondo3 waves-effect waves-light btn-radius"><i class="material-icons left">print</i> Imprimir</button>
					            </div>
								<script>
									function imprimir() {
									    window.print();
									}
								</script>
							</div>
						</div>
					</div>

	    		<?php }
	    		else {
	    		?>
				
			    	<div class="container margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable">
								<div class="row">
									<form name="importa" method="post" >

										<div class="row">
											<div class="col-xs-12 col-sm-4 col-sm-offset-4">
												<h1 class="center-align">Buscar Depósito</h1>

												<div class="input-field col-xs-12">
													<h4>Usuario</h4>
													<input placeholder="Seleccionar gerente" type="text" name="usuario" id="usuario" class="autocomplete">
													<label for="usuario"></label>
												</div>
												<div class="input-field col-xs-12">
													<h4>Referencia</h4>
									        		<input type="text" placeholder="Referencia" name="referencia"  id="referencia">
										        </div>
												<div class="input-field col-xs-12">
													<h4>Status</h4>
													<select name="status" id="status">
														<option value="" disabled selected>Selecciona el status</option>
														<option value="vacio">Sin asignar</opcion>
														<?php
															$status=status();
															foreach ($status as $opcion) { ?>
																<option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></opcion>
															<?php
															}
														?>
													</select>
										        </div>
												<div class="input-field col-xs-12">
													<h4>Banco</h4>
													<select name="banco" id="banco">
														<option value="" disabled selected>Selecciona el status</option>
														<?php
															$bancos=bancos();
															foreach ($bancos as $opcion) { ?>
																<option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></opcion>
															<?php
															}
														?>
													</select>
										        </div>
												<div class="input-field col-xs-12">
													<h4>Campaña</h4>
													<select name="cam" id="cam">
														<option value="" disabled selected>Selecciona la campaña</option>
														<?php
														$query3 = "SELECT DISTINCT cam from vive_fac ORDER BY cam ASC";
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
													</select>
										        </div>
												<div class="input-field col-xs-12">
													<h4>Fecha</h4>
													<input type="date" class="datepicker" id="fecha" name="fecha" data-value="<?php echo $row['fecha'];?>">
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
	    jQuery('.collapsible').collapsible();
	    jQuery('.datepicker').pickadate({
	    	monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		    selectMonths: true, // Creates a dropdown to control month
		    selectYears: 0, // Creates a dropdown of 15 years to control year
		    format: 'dd/mm/yyyy',
		    today: 'Hoy',
			clear: 'Borrar',
			close: 'Cerrar',
		});
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
	if( isset($_POST['btn']) || isset($_POST['dep']) || isset($_POST['pen']) ){ ?>
		<script>
			  jQuery(document).ready(function(){
			    jQuery('#<?php echo 'btn'.$iddep; ?>').modal('open');
			  });
		</script>
	<?php
	}
?>