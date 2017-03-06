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
		        						<?php $query = "SELECT * from vive_con ORDER BY cam ASC";
										$result = mysqli_query($mysqli, $query);
										if(mysqli_num_rows($result) != 0) {
											while($row = mysqli_fetch_assoc($result)) {
											$cam=$row['cam'];

											$sql="SELECT sum(can) as total FROM vive_fac WHERE cam='$cam'";
											$result = mysqli_query($mysqli, $sql);
											$res = $result->fetch_assoc();										
											?>
												<h5>Campaña #<?php echo $cam; ?>: <b><?php echo $res['total']; ?></b></h5>
											<?php }
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
											$result = mysqli_query($mysqli, $sql);
											$res = $result->fetch_assoc();										
											?>
												<h5>Campaña #<?php echo $cam; ?>: <b>Bsf <?php $valor=formato($res['total']); echo $valor; ?></b></h5>
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

		        		<div class="col-xs-12 col-sm-6">
	        				<div class="card-panel z-depth-2 hoverable">
	        					<h2 class="bold center-align"><i class="material-icons color5 verticalalignsub">account_circle</i> Usuarios online</h2>
	        					<?php echo do_shortcode( '[ultimatemember_online]' ); ?>
	        				</div>
						</div>
						<div class="col-xs-12 col-sm-6">
	        				<div class="card-panel z-depth-2 hoverable">
	        					<h2 class="bold center-align"><i class="material-icons color5 verticalalignsub">flag</i>Reportes</h2>
	        					<hr />
	        					<div class="row marginbot0">
		        					<div class="col-xs-12">
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
			        					<h5><i class="material-icons">archive</i> Facturas Cerradas</h5>
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
	        				<div class="card-panel z-depth-2 hoverable">
	        					<h2 class="bold center-align"><i class="material-icons color5 verticalalignsub">date_range</i>Calendario</h2>
	        					<div id="calendar"></div>
	        				</div>
        				</div>
    				</div>

	        		<div class="row">
		        		<div class="col-xs-12">
	        				<div class="card-panel z-depth-2 hoverable" style="overflow-x: scroll;">
	        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">trending_up</i> Movimientos</h3>
	        					<div id="chart1"></div>
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
		?>
		<div class="container-fluid margintop25 marginbot25">	
    		<div class="row">
        		<div class="col-xs-12 col-sm-4">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">shopping_basket</i> Total Colecciones</h3>
						<?php
						$stmt = $mysqli->prepare('SELECT sum(can) as total FROM vive_fac WHERE usuario = ?');
						$stmt->bind_param('s', $user_logged['login']);
						$stmt->execute();
						$stmt->bind_result($var);
						$total_colecciones=0;
					    while ($stmt->fetch()) { 
					    	$total_colecciones=$var; 
					    }
						$stmt->close();
						?>
						<h4 class="center-align"><?php echo $total_colecciones; ?></h4>
					</div>
				</div>
        		<div class="col-xs-12 col-sm-4">
    				<div class="card-panel z-depth-2 hoverable">
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">credit_card</i>Total a Pagar</h3>
						<?php
							$stmt = $mysqli->prepare('SELECT art_id, can FROM vive_fac WHERE usuario = ?');
							$stmt->bind_param('s', $user_logged['login']);
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
							$stmt = $mysqli->prepare('SELECT sum(monto) FROM vive_dep WHERE usuario = ?');
							$stmt->bind_param('s', $user_logged['login']);
							$stmt->execute();
							$stmt->bind_result($total_pagado);
						    $stmt->fetch();
							$stmt->close();
						?>
						<h4 class="center-align">Bsf <?php $valor=formato($total_pagado); echo $valor; ?></h4>
					</div>
				</div>
			</div>
			<?php
				$stmt = $mysqli->prepare('SELECT q1, q2, q3, q4 FROM vive_fac WHERE usuario = ? LIMIT 1');
				$stmt->bind_param('s', $user_logged['login']);
				$stmt->execute();
				$stmt->bind_result($q1, $q2, $q3, $q4);
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
						<h3 class="center-align"><i class="material-icons color5 verticalalignsub">date_range</i> Cierre</h3>
						<h4 class="center-align"><?php echo $q4; ?></h4>
					</div>
				</div>
			</div>
		</div>

		<?php
	}

} else { 
	header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
	exit(); 
 }
 get_footer(); ?>

 
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
				            start  : '2017-".$var['1']."-".$var['0']."'
			    			},";
                    }
                    $stmt_ORDER->close();?>
			        
			    ]
	    });
    });
 </script>
 <?php if($user_logged['rol']=='administrator'){ ?>
 <script>
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawMultSeries);

	function drawMultSeries() {
		var data = new google.visualization.DataTable();
		data.addColumn('timeofday', 'Time of Day');
		data.addColumn('number', 'Motivation Level');
		data.addColumn('number', 'Energy Level');

		data.addRows([
			[{v: [8, 0, 0], f: '8 am'}, 1, .25],
			[{v: [9, 0, 0], f: '9 am'}, 2, .5],
			[{v: [10, 0, 0], f: '10 am'}, 3, 1],
			[{v: [11, 0, 0], f: '11 am'}, 4, 2.25],
			[{v: [12, 0, 0], f: '12 pm'}, 5, 2.25],
			[{v: [13, 0, 0], f: '1 pm'}, 6, 3],
			[{v: [14, 0, 0], f: '2 pm'}, 7, 4],
			[{v: [15, 0, 0], f: '3 pm'}, 8, 5.25],
			[{v: [16, 0, 0], f: '4 pm'}, 9, 7.5],
			[{v: [17, 0, 0], f: '5 pm'}, 10, 10],
		]);

		var options = {
			hAxis: { title: 'Campañas' },
			vAxis: { title: 'Bsf'}
		};

		var chart = new google.visualization.ColumnChart(document.getElementById('chart1'));
		chart.draw(data, options);
    }
 </script>
 <?php } ?>