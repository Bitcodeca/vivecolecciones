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
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable">

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
								$stmt = $mysqli->prepare("SELECT SUM(vive_averia.can), 
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
        					<h3 class="center-align bold margintop0 marginbot0"><i class="material-icons color5 verticalalignsub">trending_up</i> Movimientos</h3>
        					<div id="chart1"></div>
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
	        			<h1 class="center-align">Depósitos Problemas con MATCH en la DATA</h1>
        				<div class="card-panel z-depth-2 hoverable">
							<table class="striped responsive-table" ng-app="contactApp" ng-controller="customersCtrl">
						        <thead>
						          <tr>
						              <th data-field="id">Gerente</th>
						              <th data-field="id">Fecha</th>
						              <th data-field="name">Banco</th>
						              <th data-field="price">Referencia</th>
						              <th data-field="price">Monto</th>
						              <th data-field="price">Acción</th>
						          </tr>
						        </thead>
						        <tbody>
									<?php
										$stmt = $mysqli->prepare('SELECT vive_pen.id, 
										 vive_pen.status,
			  						 	 vive_pen.fecha,
										 vive_pen.referencia,
										 vive_pen.monto,
										 vive_pen.banco,
										 vive_pen.cam,
										 vive_pen.usuario,
									 	 vive_dep.id FROM vive_dep JOIN vive_pen ON 
										 vive_pen.referencia = vive_dep.referencia 
										 AND vive_pen.fecha = vive_dep.fecha 
										 AND vive_pen.banco = vive_dep.banco 
										 AND vive_pen.monto = vive_dep.monto
										 AND vive_dep.usuario = "vacio"');
										$stmt->execute();
										$stmt->bind_result($penId, $penStatus, $penFecha, $penReferencia, $penMonto, $penBanco, $penCam, $penUsuario, $depId);
										$stmt->store_result();
									    while ($stmt->fetch()) {
											?>
										    <tr>
										        <td><?php echo $penUsuario; ?></td>
										        <td><?php echo $penFecha; ?></td>
										        <td><?php echo $penBanco; ?></td>
										        <td><?php echo $penReferencia; ?></td>
										        <td>Bsf <?php if (is_numeric($penMonto)){$valor=formato($penMonto); echo $valor;}else{echo $penMonto;} ?></td>
										        <td>
													<button id="btn<?php echo $penId; ?>" class="btn-floating btn hoverable yellow waves-effect waves-light " data-id="<?php echo $penId; ?>" ng-click="APROBAR($event)" ng-disabled="button<?php echo $penId; ?>" >
														<i id="icono<?php echo $penId; ?>" class="material-icons left">done</i>
													</button>
													<input type="hidden" name="penid<?php echo $penId; ?>" id="penid<?php echo $penId; ?>" value="<?php echo $penId; ?>" />
													<input type="hidden" name="usuario<?php echo $penId; ?>" id="usuario<?php echo $penId; ?>" value="<?php echo $penUsuario; ?>" />
													<input type="hidden" name="depid<?php echo $penId; ?>" id="depid<?php echo $penId; ?>" value="<?php echo $depId; ?>" />
												</td>
										    </tr>
											<?php
									    }
										$stmt->close();
									?>
						        </tbody>
						    </table>
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
      google.charts.load('current', {'packages':['bar', 'corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Fecha', 'Monto'],

          <?php
			$stmt = $mysqli->prepare("SELECT sum(vive_dep.monto), vive_dep.fecha FROM vive_dep WHERE vive_dep.usuario=? GROUP BY vive_dep.fecha ORDER BY UNIX_TIMESTAMP(STR_TO_DATE(vive_dep.fecha, '%d/%m/%Y')) ASC");
			$stmt->bind_param('s', $user_logged['login']);
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
			$stmt = $mysqli->prepare("SELECT vive_fac.can, vive_fac.fec, vive_fac.q1, vive_fac.q2, vive_fac.q3, vive_fac.q4, vive_cam.cos from vive_fac JOIN vive_cam ON vive_fac.art_id=vive_cam.id WHERE usuario=?");
			$stmt->bind_param('s', $user_logged['login']);
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


			$stmt = $mysqli->prepare('SELECT cam, gven, pbas, dis, ger, q1, q2, q3 FROM vive_con ORDER BY id ASC LIMIT 1');
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