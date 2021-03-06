<?php get_header(); 
if ( is_user_logged_in() ) {
	$user_logged=user_logged();


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//																		ADMINISTRADOR																			  //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if($user_logged['rol']=='administrator'){
		require_once 'api/vive-db.php'; ?>
    
		<div class="container-fluid margintop25 marginbot25">
			<div class="">
	        	<div class="">        		
	        		<div class="row">
		        		<div class="col-xs-12 col-sm-4">
	        				<div class="card-panel z-depth-2 hoverable">
	        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">content_paste</i> Campañas</h3>
	        					<hr />
	        					<div class="row marginbot0">
		        					<div class="col-xs-12">
		        						<?php
		        							$sql="SELECT sum(can) as total FROM vive_fac";
											$result = mysqli_query($mysqli, $sql);
											$res = $result->fetch_assoc();	
		        						?>
	        							<h4 class="center-align bold marginbot0 margintop0">Total Colecciones: <?php echo $res['total']; ?></h4>
		        						<?php
		        						$query = "SELECT * from vive_con ORDER BY cam ASC";
										$result = mysqli_query($mysqli, $query);
										if(mysqli_num_rows($result) != 0) {
											while($row = mysqli_fetch_assoc($result)) {
												$cam=$row['cam'];
												$sql="SELECT sum(can) as total FROM vive_fac WHERE cam='$cam'";
												$result2 = mysqli_query($mysqli, $sql);
												while($res = mysqli_fetch_assoc($result2)) {									
												?>
													<h5>Campaña #<?php echo $cam; ?>: <b><?php echo $res['total']; ?></b></h5>
											<?php }
											}
										} ?>

		        					</div>
	        					</div>
	        					<hr />
	        					<div class="row marginbot0">
	        						<div class="col-xs-12 center-align marginbotmenos40">
		        						<a class="waves-effect waves-light btn fondo5 btn-vive-lg hoverable" href="/buscar-factura/">Buscar Factura</a>
		        					</div>
	        					</div>
	        				</div>
						</div>
		        		<div class="col-xs-12 col-sm-4">
	        				<div class="card-panel z-depth-2 hoverable">
	        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">monetization_on</i> Total Invertido</h3>
	        					<hr />
	        					<div class="row marginbot0">
		        					<div class="col-xs-12">
		        						<?php
		        						$query = "SELECT * from vive_cam ORDER BY cam ASC";
										$result = mysqli_query($mysqli, $query);
										if(mysqli_num_rows($result) != 0) {
											while($row = mysqli_fetch_assoc($result)) {
												${$row['cam'].'art'.$row['id']}=$row['cos'];
											}
										}
										$query = "SELECT * from vive_con ORDER BY cam ASC";
										$result = mysqli_query($mysqli, $query);
										if(mysqli_num_rows($result) != 0) {
											$costo_total=0;
											while($row = mysqli_fetch_assoc($result)) {
												$cam=$row['cam'];
												${'costo'.$cam}=0;
				        						$query2 = "SELECT * from vive_fac WHERE cam='$cam'";
												$result2 = mysqli_query($mysqli, $query2);
												if(mysqli_num_rows($result2) != 0) {
													while($row2 = mysqli_fetch_assoc($result2)) {
														${'costo'.$cam}=$row2['can']*${$row2['cam'].'art'.$row2['art_id']}+${'costo'.$cam};
													}
													$costo_total=$costo_total+${'costo'.$cam};
												}
												?>
												<?php
											}
										}
										?>
	        							<h4 class="center-align bold marginbot0 margintop0">Total: <b>Bsf <?php $valor=formato($costo_total); echo $valor; ?></b></h4>
	        							<?php
		        						$query = "SELECT * from vive_con ORDER BY cam ASC";
										$result = mysqli_query($mysqli, $query);
										if(mysqli_num_rows($result) != 0) {
											while($row = mysqli_fetch_assoc($result)) {
												$cam=$row['cam'];
												?>
												<h5>Campaña #<?php echo $row['cam']; ?>: <b>Bsf <?php $valor=formato(${'costo'.$cam}); echo $valor; ?></b></h5>
												<?php
											}
										}
										?>
		        					</div>
	        					</div>
	        					<hr />
	        					<div class="row marginbot0">
	        						<div class="col-xs-12 center-align marginbotmenos40">
		        						<a class="waves-effect waves-light btn fondo5 btn-vive-lg hoverable" href="/lista-de-campanas/">Ver Campañas</a>
		        					</div>
	        					</div>
	        				</div>
						</div>
		        		<div class="col-xs-12 col-sm-4">
	        				<div class="card-panel z-depth-2 hoverable">
	        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">check_circle</i> Total aprobado</h3>
	        					<hr />
	        					<div class="row marginbot0">
		        					<div class="col-xs-12">
		        						<?php
		        							$sql="SELECT sum(monto) as total FROM vive_dep WHERE NOT status='vacio'";
											$result = mysqli_query($mysqli, $sql);
											$res = $result->fetch_assoc();	
											$totalaprobado=$res['total'];
		        						?>
	        							<h4 class="center-align bold marginbot0 margintop0">Total: Bsf <?php $valor=formato($totalaprobado); echo $valor; ?></h4>

		        						<?php $query = "SELECT * from vive_con ORDER BY cam ASC";
										$result = mysqli_query($mysqli, $query);
										if(mysqli_num_rows($result) != 0) {
											while($row = mysqli_fetch_assoc($result)) {
											$cam=$row['cam'];

											$sql="SELECT sum(monto) as total FROM vive_dep WHERE cam='$cam' AND  NOT status='vacio'";
											$result2 = mysqli_query($mysqli, $sql);
											$res = $result2->fetch_assoc();			
											if(empty($res['total'])){$resultado=0;}else{$resultado=$res['total'];}							
											?>
												<h5>Campaña #<?php echo $cam; ?>: <b>Bsf <?php $valor=formato($resultado); echo $valor; ?></b></h5>
											<?php }
										} ?>
		        					</div>
	        					</div>
	        					<hr />
	        					<div class="row marginbot0">
	        						<div class="col-xs-12 center-align marginbotmenos40">
		        						<a class="waves-effect waves-light btn fondo5 btn-vive-lg hoverable" href="/buscar-deposito/">Buscar Depósitos</a>
		        					</div>
	        					</div>
	        				</div>
						</div>
					</div>

					<div class="row">

		        		<div class="col-xs-12 col-sm-4">
		        			<div class="row">
		        				<div class="card-panel z-depth-2 hoverable">
		        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">pause_circle_filled</i> Depósitos no asignados</h3>
		        					<hr />
		        					<div class="row marginbot0">
			        					<div class="col-xs-12">
			        						<?php
			        							$sql="SELECT sum(monto) as total FROM vive_dep WHERE status='vacio'";
												$result = mysqli_query($mysqli, $sql);
												$res = $result->fetch_assoc();	
												$totalaprobado=$res['total'];
			        						?>
		        							<h4 class="center-align bold marginbot0 margintop0">Total: Bsf <?php $valor=formato($totalaprobado); echo $valor; ?></h4>
			        					</div>
		        					</div>
		        					<hr />
		        					<div class="row marginbot0">
		        						<div class="col-xs-12 center-align marginbotmenos40">
			        						<a class="waves-effect waves-light btn fondo5 btn-vive-lg hoverable" href="/depositos-sin-asignar/">Buscar Depósitos</a>
			        					</div>
		        					</div>
		        				</div>
	        				</div>
			        		<div class="row">
		        				<div class="card-panel z-depth-2 hoverable">
		        					<h3 class="bold center-align margintop0"><i class="material-icons color5 verticalalignsub">account_circle</i> Usuarios online</h3>
		        					<?php echo do_shortcode( '[ultimatemember_online]' ); ?>
		        				</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-8">
	        				<div class="card-panel z-depth-2 hoverable">
	        					<h2 class="bold center-align"><i class="material-icons color5 verticalalignsub">flag</i>Reportes</h2>
	        					<hr />
	        					<div class="row marginbot0">
		        					<div class="col-xs-12 reportes">
		        						<?php
		        						$usercount = count_users();
										$total_usuarios = $usercount['total_users'];
	        							if ($result = $mysqli->query("SELECT id FROM vive_dep WHERE status<>'vacio'")) {
	        								$num_dep = mysqli_num_rows($result);
	        							}	
	        							if ($result = $mysqli->query("SELECT id FROM vive_dep WHERE status='vacio'")) {
	        								$num_vacio = mysqli_num_rows($result);
	        							}	
	        							if ($result = $mysqli->query("SELECT * FROM vive_pen WHERE status='pendiente'")) {
	        								$num_pen = mysqli_num_rows($result);
	        							}
	        							if ($result = $mysqli->query("SELECT * FROM vive_pen WHERE status='negado'")) {
	        								$num_neg = mysqli_num_rows($result);
	        							}
	        							if ($result = $mysqli->query("SELECT * FROM vive_msn")) {
	        								$msn = mysqli_num_rows($result);
	        							}
	        							if ($result = $mysqli->query("SELECT * FROM vive_cambio")) {
	        								$aver = mysqli_num_rows($result);
	        							}
	        							if ($result = $mysqli->query("SELECT * FROM vive_averia")) {
	        								$camb = mysqli_num_rows($result);
	        							}
	        							if ($result = $mysqli->query("SELECT * FROM vive_dev")) {
	        								$dev = mysqli_num_rows($result);
	        							}
	        							if ($result = $mysqli->query("SELECT * FROM vive_den")) {
	        								$den = mysqli_num_rows($result);
	        							}
										?>
			        					<h5><i class="material-icons">account_circle</i> Usuarios Registrados: <b><?php echo $total_usuarios; ?></b></h5>
			        					<h5><i class="material-icons">check_circle</i> Depósitos Aprobados: <b><?php echo $num_dep; ?></b></h5>
			        					<h5><i class="material-icons">error</i> Depósitos Problemas: <b><?php echo $num_pen; ?></b></h5>
			        					<h5><i class="material-icons">cancel</i> Depósitos Negados: <b><?php echo $num_neg; ?></b></h5>
			        					<h5><i class="material-icons">panorama_fish_eye</i> Depósitos Sin Asignar: <b><?php echo $num_vacio; ?></b></h5>
			        					<h5><i class="material-icons">cached</i> Cambios: <b><?php echo $camb; ?></b></h5>
			        					<h5><i class="material-icons">build</i> Averías: <b><?php echo $aver; ?></b></h5>
			        					<h5><i class="material-icons">arrow_back</i> Devoluciones: <b><?php echo $dev; ?></b></h5>
			        					<h5><i class="material-icons">do_not_disturb</i> Denuncias: <b><?php echo $den; ?></b></h5>
			        					<h5><i class="material-icons">message</i> Mensajes Enviados: <b><?php echo $msn; ?></b></h5>
	        						</div>
	        					</div>
	        				</div>
						</div>

					</div>


        			<div class="row">
		        		<div class="col-xs-12 col-sm-6">
	        				<div class="card-panel z-depth-2 hoverable">
	        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">message</i> Chat</h3>
								<div id="chatChart"></div>
	        				</div>
						</div>
		        		<div class="col-xs-12 col-sm-6">
	        				<div class="card-panel z-depth-2 hoverable">
	        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">trending_up</i> Administración</h3>
								<div id="chatChart2"></div>
	        				</div>
						</div>
					</div>
					<div class="row">
		        		<div class="col-xs-12">
	        				<div class="card-panel z-depth-2 hoverable" style="overflow-x: scroll;">
	        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">trending_up</i> Ingresos Diarios</h3>
								<div id="columnchart_material"></div>
	        				</div>
						</div>
					</div>
	        		<div class="row">
		        		<div class="col-xs-12">
	        				<div class="card-panel z-depth-2 hoverable">
	        					<h2 class="bold center-align"><i class="material-icons color5 verticalalignsub">date_range</i>Calendario</h2>
	        					<div id="calendar"></div>
	        				</div>
        				</div>
    				</div>


				</div>
			</div>
		</div>


		<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//																			GERENTE																				  //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	} elseif ($user_logged['rol']=='Gerente') {
		require_once 'api/vive-db.php';
		$gerente_logged=$user_logged["login"];
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
	    $ultima_cam=$array_cam[0];
		?>
		<div class="container-fluid margintop25 marginbot25">	
    		<div class="row">
        		<div class="col-xs-12 col-sm-4">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">shopping_basket</i> Total Colecciones</h3>
						<?php
						/*$stmt2 = $mysqli->prepare('SELECT cam from vive_fac WHERE usuario = ? ORDER BY cam DESC');
						$stmt2->bind_param('s', $user_logged['login']);
						$stmt2->execute();
						$stmt2->bind_result($var2);
					    while ($stmt2->fetch()) { 
							$buscar=$var2;
							echo $buscar;*/
							$stmt = $mysqli->prepare("SELECT sum(can) as total FROM vive_fac WHERE usuario = ? AND cam = ?");
							$stmt->bind_param("ss", $user_logged['login'], $ultima_cam);
							$stmt->execute();
							$stmt->bind_result($var);
							$total_colecciones=0;
						    while ($stmt->fetch()) { 
						    	$total_colecciones=$var; 
						    }
							$stmt->close();/*
					    }
						$stmt2->close();*/
						?>
						<h4 class="center-align"><?php echo $total_colecciones; ?></h4>
					</div>
				</div>
        		<div class="col-xs-12 col-sm-4">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">credit_card</i>Total a Pagar</h3>
						<?php
							$stmt = $mysqli->prepare('SELECT art_id, can FROM vive_fac WHERE usuario = ? AND cam = ?');
							$stmt->bind_param('ss', $user_logged['login'], $ultima_cam);
							$stmt->execute();
							$stmt->bind_result($art_id, $can);
							$stmt->store_result();
							$total_pagar=0;
						    while ($stmt->fetch()) {
						    	$buscar=$art_id;
						    	$stmt_ORDER = $mysqli->prepare('SELECT cos FROM vive_cam WHERE id = ?');
								$stmt_ORDER->bind_param('i', $buscar);
								$stmt_ORDER->execute();
								$stmt_ORDER->bind_result($cos);
								$stmt_ORDER->store_result();
								while($stmt_ORDER->fetch()){
						        	$sum=$cos*$can;
						        	$total_pagar=$total_pagar+$sum;
								}
								$stmt_ORDER->close();
						    }
							$stmt->close();
						?>
						<h4 class="center-align">Bsf <?php $valor=formato($total_pagar); echo $valor; ?></h4>
					</div>
				</div>
        		<div class="col-xs-12 col-sm-4">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">done_all</i> Total Pagado</h3>
						<?php
							$stmt = $mysqli->prepare('SELECT sum(monto) FROM vive_dep WHERE usuario = ? AND cam = ?');
							$stmt->bind_param('ss', $user_logged['login'], $ultima_cam);
							$stmt->execute();
							$stmt->bind_result($total_pagado);
						    $stmt->fetch();
							$stmt->close();
						?>
						<h4 class="center-align">Bsf <?php if(!empty($total_pagado)){$valor=formato($total_pagado); echo $valor;}else{echo '0,00';} ?></h4>
					</div>
				</div>
			</div>
			<?php
				$stmt = $mysqli->prepare('SELECT q1, q2, q3, q4, q5, q6 FROM vive_fac WHERE usuario = ? AND cam = ? LIMIT 1');
				$stmt->bind_param('ss', $user_logged['login'], $ultima_cam);
				$stmt->execute();
				$stmt->bind_result($q1, $q2, $q3, $q4, $q5, $q6);
			    $stmt->fetch();
				$stmt->close();
	    	?>
			<div class="row">
        		<div class="col-xs-12 col-sm-3">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">date_range</i> Primera Cuota</h3>
						<h4 class="center-align"><?php echo $q1; ?></h4>
					</div>
				</div>
        		<div class="col-xs-12 col-sm-3">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">date_range</i> Segunda Cuota</h3>
						<h4 class="center-align"><?php echo $q2; ?></h4>
					</div>
				</div>
        		<div class="col-xs-12 col-sm-3">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">date_range</i> Tercera Cuota</h3>
						<h4 class="center-align"><?php echo $q3; ?></h4>
					</div>
				</div>
        		<div class="col-xs-12 col-sm-3">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">date_range</i> Cuarta Cuota</h3>
						<h4 class="center-align"><?php echo $q4; ?></h4>
					</div>
				</div>
        		<div class="col-xs-12 col-sm-3">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">date_range</i> Quinta Cuota</h3>
						<h4 class="center-align"><?php echo $q5; ?></h4>
					</div>
				</div>
        		<div class="col-xs-12 col-sm-3">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">date_range</i> Cierre</h3>
						<h4 class="center-align"><?php echo $q6; ?></h4>
					</div>
				</div>
			</div>

        		<div class="row">
	        		<div class="col-xs-12 col-sm-12 col-md-7">
        				<div class="card-panel z-depth-2 hoverable" style="overflow-x: scroll;">
        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">trending_up</i> Depósitos Realizados</h3>
							<div id="columnchart_material"></div>
        				</div>
					</div>
	        		<div class="col-xs-12 col-sm-12 col-md-5">
        				<div class="card-panel z-depth-2 hoverable" style="overflow-x: scroll;">
        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">payment</i> Factura</h3>
							<div id="chart2"></div>
        				</div>
					</div>
				</div>
		</div>

		<?php
	} 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//																		ANALISTA																			  //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	elseif($user_logged['rol']=='Analista'){
		require_once 'api/vive-db.php'; 
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
	    $cantidad_gerente=count($array_analista);
	    if($cantidad_gerente>=1){
	    	$buscar_gerente = join("','",$array_analista);
	    	?>

			<div class="container-fluid margintop25 marginbot25">
				<div class="">
		        	<div class="">        		
		        		<div class="row">
		        			<h1></h1>
			        		<div class="col-xs-12 col-sm-4">
		        				<div class="card-panel z-depth-2 hoverable">
		        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">content_paste</i> Campañas</h3>
		        					<hr />
		        					<div class="row marginbot0">
			        					<div class="col-xs-12">
			        						<?php
			        							$sql="SELECT sum(can) as total FROM vive_fac WHERE usuario IN ('$buscar_gerente')";
												$result = mysqli_query($mysqli, $sql);
												$res = $result->fetch_assoc();	
			        						?>
		        							<h4 class="center-align bold marginbot0 margintop0">Total Colecciones: <?php echo $res['total']; ?></h4>
			        						<?php
			        						$query = "SELECT * from vive_con ORDER BY cam ASC";
											$result = mysqli_query($mysqli, $query);
											if(mysqli_num_rows($result) != 0) {
												while($row = mysqli_fetch_assoc($result)) {
													$cam=$row['cam'];
													$sql="SELECT sum(can) as total FROM vive_fac WHERE cam='$cam' AND  usuario IN ('$buscar_gerente')";
													$result2 = mysqli_query($mysqli, $sql);
													while($res = mysqli_fetch_assoc($result2)) {									
													?>
														<h5>Campaña #<?php echo $cam; ?>: <b><?php echo $res['total']; ?></b></h5>
												<?php }
												}
											} ?>

			        					</div>
		        					</div>
		        					<hr />
		        					<div class="row marginbot0">
		        						<div class="col-xs-12 center-align marginbotmenos40">
			        						<a class="waves-effect waves-light btn fondo5 btn-vive-lg hoverable" href="/buscar-factura/">Buscar Factura</a>
			        					</div>
		        					</div>
		        				</div>
							</div>
			        		<div class="col-xs-12 col-sm-4">
		        				<div class="card-panel z-depth-2 hoverable">
		        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">monetization_on</i> Total Invertido</h3>
		        					<hr />
		        					<div class="row marginbot0">
			        					<div class="col-xs-12">
			        						<?php
			        						$query = "SELECT * from vive_cam ORDER BY cam ASC";
											$result = mysqli_query($mysqli, $query);
											if(mysqli_num_rows($result) != 0) {
												while($row = mysqli_fetch_assoc($result)) {
													${$row['cam'].'art'.$row['id']}=$row['cos'];
												}
											}
											$query = "SELECT * from vive_con ORDER BY cam ASC";
											$result = mysqli_query($mysqli, $query);
											if(mysqli_num_rows($result) != 0) {
												$costo_total=0;
												while($row = mysqli_fetch_assoc($result)) {
													$cam=$row['cam'];
													${'costo'.$cam}=0;
					        						$query2 = "SELECT * from vive_fac WHERE cam='$cam' AND  usuario IN ('$buscar_gerente')";
													$result2 = mysqli_query($mysqli, $query2);
													if(mysqli_num_rows($result2) != 0) {
														while($row2 = mysqli_fetch_assoc($result2)) {
															${'costo'.$cam}=$row2['can']*${$row2['cam'].'art'.$row2['art_id']}+${'costo'.$cam};
														}
														$costo_total=$costo_total+${'costo'.$cam};
													}
													?>
													<?php
												}
											}
											?>
		        							<h4 class="center-align bold marginbot0 margintop0">Total: <b>Bsf <?php $valor=formato($costo_total); echo $valor; ?></b></h4>
		        							<?php
			        						$query = "SELECT * from vive_con ORDER BY cam ASC";
											$result = mysqli_query($mysqli, $query);
											if(mysqli_num_rows($result) != 0) {
												while($row = mysqli_fetch_assoc($result)) {
													$cam=$row['cam'];
													?>
													<h5>Campaña #<?php echo $row['cam']; ?>: <b>Bsf <?php $valor=formato(${'costo'.$cam}); echo $valor; ?></b></h5>
													<?php
												}
											}
											?>
			        					</div>
		        					</div>
		        					<hr />
		        					<div class="row marginbot0">
		        						<div class="col-xs-12 center-align marginbotmenos40">
			        						<a class="waves-effect waves-light btn fondo5 btn-vive-lg hoverable" href="/lista-de-campanas/">Ver Campañas</a>
			        					</div>
		        					</div>
		        				</div>
							</div>
			        		<div class="col-xs-12 col-sm-4">
		        				<div class="card-panel z-depth-2 hoverable">
		        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">check_circle</i> Total aprobado</h3>
		        					<hr />
		        					<div class="row marginbot0">
			        					<div class="col-xs-12">
			        						<?php
			        							$sql="SELECT sum(monto) as total FROM vive_dep WHERE NOT status='vacio' AND  usuario IN ('$buscar_gerente')";
												$result = mysqli_query($mysqli, $sql);
												$res = $result->fetch_assoc();	
												if (!empty($res['total'])){$totalaprobado=$res['total'];}else{$totalaprobado=0;}
												
			        						?>
		        							<h4 class="center-align bold marginbot0 margintop0">Total: Bsf <?php $valor=formato($totalaprobado); echo $valor; ?></h4>

			        						<?php $query = "SELECT * from vive_con ORDER BY cam ASC";
											$result = mysqli_query($mysqli, $query);
											if(mysqli_num_rows($result) != 0) {
												while($row = mysqli_fetch_assoc($result)) {
												$cam=$row['cam'];

												$sql="SELECT sum(monto) as total FROM vive_dep WHERE cam='$cam' AND  NOT status='vacio' AND  usuario IN ('$buscar_gerente')";
												$result2 = mysqli_query($mysqli, $sql);
												$res = $result2->fetch_assoc();			
												if(empty($res['total'])){$resultado=0;}else{$resultado=$res['total'];}							
												?>
													<h5>Campaña #<?php echo $cam; ?>: <b>Bsf <?php $valor=formato($resultado); echo $valor; ?></b></h5>
												<?php }
											} ?>
			        					</div>
		        					</div>
		        					<hr />
		        					<div class="row marginbot0">
		        						<div class="col-xs-12 center-align marginbotmenos40">
			        						<a class="waves-effect waves-light btn fondo5 btn-vive-lg hoverable" href="/buscar-deposito/">Buscar Depósitos</a>
			        					</div>
		        					</div>
		        				</div>
							</div>
						</div>

						<div class="row">

			        		<div class="col-xs-12 col-sm-4">
			        			<div class="row">
			        				<div class="card-panel z-depth-2 hoverable">
			        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">pause_circle_filled</i> Depósitos no asignados</h3>
			        					<hr />
			        					<div class="row marginbot0">
				        					<div class="col-xs-12">
				        						<?php
				        							$sql="SELECT sum(monto) as total FROM vive_dep WHERE status='vacio' AND  usuario IN ('$buscar_gerente')";
													$result = mysqli_query($mysqli, $sql);
													$res = $result->fetch_assoc();
													if (!empty($res['total'])){$totalaprobado=$res['total'];}else{$totalaprobado=0;}
				        						?>
			        							<h4 class="center-align bold marginbot0 margintop0">Total: Bsf <?php $valor=formato($totalaprobado); echo $valor; ?></h4>
				        					</div>
			        					</div>
			        					<hr />
			        					<div class="row marginbot0">
			        						<div class="col-xs-12 center-align marginbotmenos40">
				        						<a class="waves-effect waves-light btn fondo5 btn-vive-lg hoverable" href="/depositos-sin-asignar/">Buscar Depósitos</a>
				        					</div>
			        					</div>
			        				</div>
		        				</div>
				        		<div class="row">
			        				<div class="card-panel z-depth-2 hoverable">
			        					<h3 class="bold center-align margintop0"><i class="material-icons color5 verticalalignsub">account_circle</i> Usuarios online</h3>
			        					<?php echo do_shortcode( '[ultimatemember_online]' ); ?>
			        				</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-8">
		        				<div class="card-panel z-depth-2 hoverable">
		        					<h2 class="bold center-align"><i class="material-icons color5 verticalalignsub">flag</i>Reportes</h2>
		        					<hr />
		        					<div class="row marginbot0">
			        					<div class="col-xs-12 reportes">
			        						<?php
			        						$usercount = count_users();
											$total_usuarios = $usercount['total_users'];
		        							if ($result = $mysqli->query("SELECT id FROM vive_dep WHERE status<>'vacio' AND  usuario IN ('$buscar_gerente')")) {
		        								$num_dep = mysqli_num_rows($result);
		        							}	
		        							if ($result = $mysqli->query("SELECT id FROM vive_dep WHERE status='vacio' AND  usuario IN ('$buscar_gerente')")) {
		        								$num_vacio = mysqli_num_rows($result);
		        							}	
		        							if ($result = $mysqli->query("SELECT * FROM vive_pen WHERE status='pendiente' AND  usuario IN ('$buscar_gerente')")) {
		        								$num_pen = mysqli_num_rows($result);
		        							}
		        							if ($result = $mysqli->query("SELECT * FROM vive_pen WHERE status='negado' AND  usuario IN ('$buscar_gerente')")) {
		        								$num_neg = mysqli_num_rows($result);
		        							}
		        							if ($result = $mysqli->query("SELECT * FROM vive_msn")) {
		        								$msn = mysqli_num_rows($result);
		        							}
		        							if ($result = $mysqli->query("SELECT * FROM vive_cambio WHERE  usuario IN ('$buscar_gerente')")) {
		        								$aver = mysqli_num_rows($result);
		        							}
		        							if ($result = $mysqli->query("SELECT * FROM vive_averia WHERE  usuario IN ('$buscar_gerente')")) {
		        								$camb = mysqli_num_rows($result);
		        							}
		        							if ($result = $mysqli->query("SELECT * FROM vive_dev WHERE  usuario IN ('$buscar_gerente')")) {
		        								$dev = mysqli_num_rows($result);
		        							}
		        							if ($result = $mysqli->query("SELECT * FROM vive_den")) {
		        								$den = mysqli_num_rows($result);
		        							}
											?>
				        					<h5><i class="material-icons">account_circle</i> Usuarios Registrados: <b><?php echo $total_usuarios; ?></b></h5>
				        					<h5><i class="material-icons">check_circle</i> Depósitos Aprobados: <b><?php echo $num_dep; ?></b></h5>
				        					<h5><i class="material-icons">error</i> Depósitos Problemas: <b><?php echo $num_pen; ?></b></h5>
				        					<h5><i class="material-icons">cancel</i> Depósitos Negados: <b><?php echo $num_neg; ?></b></h5>
				        					<h5><i class="material-icons">panorama_fish_eye</i> Depósitos Sin Asignar: <b><?php echo $num_vacio; ?></b></h5>
				        					<h5><i class="material-icons">cached</i> Cambios: <b><?php echo $camb; ?></b></h5>
				        					<h5><i class="material-icons">build</i> Averías: <b><?php echo $aver; ?></b></h5>
				        					<h5><i class="material-icons">arrow_back</i> Devoluciones: <b><?php echo $dev; ?></b></h5>
				        					<h5><i class="material-icons">do_not_disturb</i> Denuncias: <b><?php echo $den; ?></b></h5>
				        					<h5><i class="material-icons">message</i> Mensajes Enviados: <b><?php echo $msn; ?></b></h5>
		        						</div>
		        					</div>
		        				</div>
							</div>

						</div>
						<div class="row">
			        		<div class="col-xs-12">
		        				<div class="card-panel z-depth-2 hoverable" style="overflow-x: scroll;">
		        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">trending_up</i> Ingresos Diarios</h3>
									<div id="columnchart_material"></div>
		        				</div>
							</div>
						</div>
		        		<div class="row">
			        		<div class="col-xs-12">
		        				<div class="card-panel z-depth-2 hoverable">
		        					<h2 class="bold center-align"><i class="material-icons color5 verticalalignsub">date_range</i>Calendario</h2>
		        					<div id="calendar"></div>
		        				</div>
	        				</div>
	    				</div>


					</div>
				</div>
			</div>

	    	<?php
	    }
	    else{
			?>

			<div class="container-fluid margintop25 marginbot25">     		
        		<div class="row">
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable">
        					<h1>No posee gerentes asignados</h1>
        				</div>
    				</div>
				</div>
			</div>
			
			<?php
		}
	}

} else { 
	header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
	exit(); 
 }
 get_footer(); ?>

 
 <?php if($user_logged['rol']=='administrator'){ ?>
 <script>
     jQuery(document).ready(function(){
		jQuery('#calendar').fullCalendar({
		    header: {
		        left: 'today',
		        center: 'title',
		        right: 'listYear month prev,next'
		    },
			dayNamesShort:['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			monthNames:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			events: [
	        		<?php
	        		$stmt_ORDER = $mysqli->prepare("SELECT nacimiento, usuario FROM vive_usu_inf");
                    $stmt_ORDER->execute();
                    $stmt_ORDER->bind_result($nacimiento, $usuario);
                    $stmt_ORDER->store_result();
                    while($stmt_ORDER->fetch()){
                    	$var=explode("/",$nacimiento);
                    	echo "{
                    		title  : '".$usuario."',
				            start  : '".date('Y')."-".$var['1']."-".$var['0']."'
			    			},";
                    	echo "{
                    		title  : '".$usuario."',
				            start  : '".date('Y', strtotime('+1 year'))."-".$var['1']."-".$var['0']."'
			    			},";
                    }
                    $stmt_ORDER->close();?>
			        
			    ]
	    });
    });
 </script>
 <script>
      google.charts.load('current', {'packages':['bar', 'corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Fecha', 'Monto'],

          <?php
			$stmt = $mysqli->prepare("SELECT sum(vive_dep.monto), vive_dep.fecha FROM vive_dep GROUP BY vive_dep.fecha ORDER BY UNIX_TIMESTAMP(STR_TO_DATE(vive_dep.fecha, '%d/%m/%Y')) ASC");
			$stmt->execute();
			$stmt->bind_result($monto, $fecha);
			$stmt->store_result();
		    while ($stmt->fetch()) {
				echo "['".$fecha."', ".$monto."],";
		    }
			$stmt->close();
			?>
        ]);
        var options = {
        	legend: { position: "none" },
            series: { 0: { axis: 'Bsf' }, },
            axes: { y: {  Bsf: {label: 'Bsf'}, } }
        };
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, options);
      }

      google.charts.setOnLoadCallback(drawpie);

	  function drawpie() {

	      var data = new google.visualization.DataTable();
	      data.addColumn('string', 'Status');
	      data.addColumn('number', '# mensajes');
	      data.addRows([
          <?php
			$stmt = $mysqli->prepare("SELECT SUM(if(vive_msn.visto = 'N', 1, 0)) AS no, SUM(if(vive_msn.visto = 'Y', 1, 0)) AS yes FROM vive_msn");
			$stmt->execute();
			$stmt->bind_result($no, $si);
			$stmt->store_result();
		    $stmt->fetch();
			echo "['Mensajes leidos', ".$si."],";
			echo "['Mensajes no leidos', ".$no."],";
			$stmt->close();
			?>
	      ]);

	      var options = {
          	//legend: 'none'
	      };

	      var chart = new google.visualization.PieChart(document.getElementById('chatChart'));
	      chart.draw(data, options);
	  }

      google.charts.setOnLoadCallback(drawpie2);

	  function drawpie2() {

	      var data = new google.visualization.DataTable();
	      data.addColumn('string', 'Status');
	      data.addColumn('number', '# mensajes');
	      data.addRows([
          <?php
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
				$total_colecciones=0;
			    while ($stmt->fetch()) {
			    	$costo=$facCan*$camCos + $costo;
			    	$total_colecciones=$total_colecciones+$facCan;
				}
				$stmt->close();

				$stmt = $mysqli->prepare('SELECT cam, gven, pbas, dis, ger, q1, q2, q3 FROM vive_con ORDER BY id ASC LIMIT 1');
				$stmt->execute();
				$stmt->bind_result($can, $gven, $pbas, $dis, $ger, $q1, $q2, $q3);
				$stmt->store_result();
			    $stmt->fetch();
			    $ganancia_total_gven=$total_colecciones*$gven;
				$total_distribucion=$dis*$total_colecciones;
				$total_gerencia=$ger*$total_colecciones;
				$stmt->close();
				
				$total_a_cancelar=$costo-$total_distribucion-$total_gerencia-$ganancia_total_gven;


				$stmt = $mysqli->prepare('SELECT fecha, monto FROM vive_dep WHERE cam = ?');
				$stmt->bind_param('s', $cam);
				$stmt->execute();
				$stmt->bind_result($depFecha, $depMonto);
				$stmt->store_result();
	          	$depositado=0;
			    while ($stmt->fetch()) { $depositado=$depMonto+$depositado; }
				$stmt->close();

				$restante=$total_a_cancelar-$depositado;

				echo "['Depositado', ".$depositado."],";
				echo "['Restante', ".$restante."],";


			}
			$stmt0->close();
			?>
	      ]);

	      var options = {
          	//legend: 'none'
	      };

	      var chart = new google.visualization.PieChart(document.getElementById('chatChart2'));
	      chart.draw(data, options);
	  }
 </script>
 <?php } ?>


 <?php if($user_logged['rol']=='Gerente'){ ?>
 <script>
      google.charts.load('current', {'packages':['bar', 'corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Fecha', 'Monto'],

          <?php
			$stmt = $mysqli->prepare("SELECT sum(vive_dep.monto), vive_dep.fecha FROM vive_dep WHERE vive_dep.usuario=? AND vive_dep.cam=? GROUP BY vive_dep.fecha ORDER BY UNIX_TIMESTAMP(STR_TO_DATE(vive_dep.fecha, '%d/%m/%Y')) ASC");
			$stmt->bind_param('ss', $user_logged['login'], $ultima_cam);
			$stmt->execute();
			$stmt->bind_result($monto, $fecha);
			$stmt->store_result();
		    while ($stmt->fetch()) { echo "['".$fecha."', ".$monto."],"; }
			$stmt->close();
			?>
        ]);
        var options = {
        	vAxis: {format: 'decimal' },
            series: { 0: { axis: 'Bsf' }, },
            axes: { y: {  Bsf: {label: 'Bsf'}, } },
        };
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, options);
      }
      google.charts.setOnLoadCallback(drawpie);

	  function drawpie() {

	      var data = new google.visualization.DataTable();
	      data.addColumn('string', 'Status');
	      data.addColumn('number', '# mensajes');
	      data.addRows([
          <?php
			$stmt = $mysqli->prepare("SELECT vive_fac.can, vive_fac.fec, vive_fac.q1, vive_fac.q2, vive_fac.q3, vive_fac.q4, vive_cam.cos from vive_fac JOIN vive_cam ON vive_fac.art_id=vive_cam.id WHERE usuario=? AND cam=?");
			$stmt->bind_param('ss', $user_logged['login'], $ultima_cam);
			$stmt->execute();
			$stmt->bind_result($facCan, $facFec, $facQ1, $facQ2, $facQ3, $facQ4, $camCosto);
			$stmt->store_result();
          	$total=0; $total_colecciones=0;
		    while ($stmt->fetch()) { $total_colecciones=$total_colecciones+$facCan; $total=$facCan*$camCosto+$total; }
			$stmt->close();

			$stmt = $mysqli->prepare('SELECT fecha, monto FROM vive_dep WHERE usuario = ?');
			$stmt->bind_param('s', $user_logged['login']);
			$stmt->execute();
			$stmt->bind_result($depFecha, $depMonto);
			$stmt->store_result();
          	$depositado=0;
		    while ($stmt->fetch()) { $depositado=$depMonto+$depositado; }
			$stmt->close();


			$stmt = $mysqli->prepare('SELECT cam, gven, pbas, dis, ger, q1, q2, q3 FROM vive_con WHERE cam=? ORDER BY id ASC LIMIT 1');
			$stmt->bind_param('s', $ultima_cam);
			$stmt->execute();
			$stmt->bind_result($can, $gven, $pbas, $dis, $ger, $q1, $q2, $q3);
			$stmt->store_result();
		    $stmt->fetch();
		    $ganancia_total_gven=$total_colecciones*$gven;
			$total_distribucion=$dis*$total_colecciones;
			$total_gerencia=$ger*$total_colecciones;
			$stmt->close();

			$total_a_cancelar=$total-$total_distribucion-$total_gerencia-$ganancia_total_gven;
			$restante=$total_a_cancelar-$depositado;

			echo "['Aprobado', ".$depositado."],";
			echo "['Deuda', ".$restante."],";
			?>
	      ]);

	      var options = {
          	//legend: 'none'
	      };

	      var chart = new google.visualization.PieChart(document.getElementById('chart2'));
	      chart.draw(data, options);
	  }
 </script>
 <?php } ?>

 <?php if($user_logged['rol']=='Analista'){ ?>
 <script>
     jQuery(document).ready(function(){
		jQuery('#calendar').fullCalendar({
		    header: {
		        left: 'today',
		        center: 'title',
		        right: 'listYear month prev,next'
		    },
			dayNamesShort:['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			monthNames:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			events: [
	        		<?php
	        		$stmt_ORDER = $mysqli->prepare("SELECT nacimiento, usuario FROM vive_usu_inf WHERE  usuario IN ('$buscar_gerente')");
                    $stmt_ORDER->execute();
                    $stmt_ORDER->bind_result($nacimiento, $usuario);
                    $stmt_ORDER->store_result();
                    while($stmt_ORDER->fetch()){
                    	$var=explode("/",$nacimiento);
                    	echo "{
                    		title  : '".$usuario."',
				            start  : '".date('Y')."-".$var['1']."-".$var['0']."'
			    			},";
                    	echo "{
                    		title  : '".$usuario."',
				            start  : '".date('Y', strtotime('+1 year'))."-".$var['1']."-".$var['0']."'
			    			},";
                    }
                    $stmt_ORDER->close();?>
			        
			    ]
	    });
    });
 </script>
 <script>
      google.charts.load('current', {'packages':['bar', 'corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Fecha', 'Monto'],

          <?php
			$stmt = $mysqli->prepare("SELECT sum(vive_dep.monto), vive_dep.fecha FROM vive_dep WHERE  usuario IN ('$buscar_gerente') GROUP BY vive_dep.fecha ORDER BY UNIX_TIMESTAMP(STR_TO_DATE(vive_dep.fecha, '%d/%m/%Y')) ASC");
			$stmt->execute();
			$stmt->bind_result($monto, $fecha);
			$stmt->store_result();
		    while ($stmt->fetch()) {
				echo "['".$fecha."', ".$monto."],";
		    }
			$stmt->close();
			?>
        ]);
        var options = {
        	legend: { position: "none" },
            series: { 0: { axis: 'Bsf' }, },
            axes: { y: {  Bsf: {label: 'Bsf'}, } }
        };
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, options);
      }

 </script>
 <?php } ?>