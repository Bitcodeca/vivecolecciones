<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else {  ?>

			<div class="container-fluid margintop25 marginbot25">
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">FACTURACIÓN</h1>

			    	<div class="container-fluid margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable">
								<h1 class="center-align imprimir">Facturas de <?php echo $usuario; ?></h1>


							</div>
						</div>
					</div>

						</div>
					</div>
				</div>
			</div>
	    <?php }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//																			GERENTE																				  //
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	} elseif ($user_logged['rol']=='Gerente') {
		require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php
	    }
	    else {
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
	    	?>
			<div class="container-fluid margintop25 marginbot25">
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">FACTURACIÓN</h1>

								<?php $query = "SELECT * from vive_con ORDER BY cam ASC";
								$result = mysqli_query($mysqli, $query);
								if(mysqli_num_rows($result) != 0) {
									while($row = mysqli_fetch_assoc($result)) {
										$cam=$row['cam'];
										$gven=$row['gven'];
										$pbas=$row['pbas'];
										$dis=$row['dis'];
										$ger=$row['ger'];
										$q1=$row['q1'];
										$q2=$row['q2'];
										$q3=$row['q3'];
										$query1 = "SELECT * from vive_fac WHERE usuario='$gerente_logged' AND cam='$cam'";
										$result1 = mysqli_query($mysqli, $query1);
										if(mysqli_num_rows($result1) != 0) { ?>
											<ul class="collapsible" data-collapsible="accordion">
												<li>
													<div class="collapsible-header"><h3>Campaña #<?php echo $cam; ?></h3></div>
													<div class="collapsible-body paddingleft15 paddingright15">
														<div class="row">
														<blockquote><h3>Descripción de Colecciones</h3></blockquote>
														<div class="row nobreak">
															<table class="responsive-table striped centered">
															        <thead>
															          <tr class="fondo1 white-text">
																	    <th data-field="producto">Producto</th>
																	    <th data-field="cantidad">Cantidad</th>
																	    <th data-field="costo">Costo</th>
																	    <th data-field="total">Costo Total</th>
															          </tr>
															        </thead>

															        <tbody>

																		<?php
																		$total_colecciones=0;
																		$costo_total=0;
																		$query2 = "SELECT * from vive_fac WHERE usuario='$gerente_logged' AND cam='$cam'";
																		$result2 = mysqli_query($mysqli, $query2);
																		if(mysqli_num_rows($result2) != 0) {
																			while($row2 = mysqli_fetch_assoc($result2)) {
																				$art_id=$row2['art_id'];
																				$query3 = "SELECT * from vive_cam WHERE id='$art_id'";
																				$result3 = mysqli_query($mysqli, $query3);
																				if(mysqli_num_rows($result3) != 0) {
																					while($row3 = mysqli_fetch_assoc($result3)) {
																						$costo=$row3['cos'];
																						$articulo=$row3['art'];
																					}
																				} ?>

																				<tr>
																					<td><?php echo $articulo; ?></td>
																					<td><?php echo $row2['can']; ?></td>
																					<td>Bsf <?php $valor=formato($costo); echo $valor; ?></td>
																					<td>Bsf <?php $costototalart=$costo*$row2['can']; $valor=formato($costototalart); echo $valor; ?></td>
																				</tr>
																			<?php
																				$total_colecciones=$row2['can']+$total_colecciones;
																				$costo_total=$costo_total+$costototalart;
																				$corte_fecha_creada=$row2['fecha_creada'];
																				$corte_q1=$row2['q1'];
																				$corte_q2=$row2['q2'];
																				$corte_q3=$row2['q3'];
																				$corte_q4=$row2['q4'];
																			}
																		} ?>

															        </tbody>
														    </table>
													    </div>
													    <h3 class="underline">Subtotal</h3>
														<div class="row nobreak">
															<table class="responsive-table striped centered">
															        <thead>
															          <tr>
																	    <th data-field="producto">Total colecciones</th>
																	    <th data-field="producto">Costo total</th>
															          </tr>
															        </thead>

															        <tbody>
																          <tr>
																	          <td><?php echo $total_colecciones; ?></td>
																	          <td>Bsf <?php $valor=formato($costo_total); echo $valor; ?></td>
																          </tr>
															        </tbody>
														      </table>
													    </div>
													    <h3 class="underline">Ganancia Vendedor</h3>
														<div class="row nobreak">
															<table class="responsive-table striped centered">
															        <thead>
															          <tr>
																	    <th data-field="producto">Total colecciones</th>
																	    <th data-field="producto">Ganancia</th>
																	    <th data-field="producto">Ganancia total</th>
															          </tr>
															        </thead>

															        <tbody>
																          <tr>
																	          <td><?php echo $total_colecciones; ?></td>
																	          <td>Bsf <?php $valor=formato($gven); echo $valor; ?></td>
																	          <td>Bsf <?php $ganancia_total_gven=$total_colecciones*$gven; $valor=formato($ganancia_total_gven); echo $valor; ?></td>
																          </tr>
															        </tbody>
														      </table>
													      </div>
													    <div class="divider"></div>
													    <h3 class="left-align bold paddingleft15 paddingtop10 paddingbot10 fondo3">Total <small>Bsf <?php $total=$costo_total-$ganancia_total_gven; $valor=formato($total); echo $valor; ?></small></h3>
														<blockquote><h3>Descripción de Pagos</h3></blockquote>
														<div class="row nobreak">
															<table class="responsive-table striped centered">
															        <thead>
															          <tr class="fondo1 white-text">
																	    <th data-field="producto">Descripción</th>
																	    <th data-field="producto">Monto</th>
																	    <th data-field="producto">Cantidad</th>
																	    <th data-field="producto">Sub-total</th>
															          </tr>
															        </thead>

															        <tbody>
																          <tr>
																	          <td class="bold">Total Adeudado</td>
																	          <td>-</td>
																	          <td>-</td>
																	          <td class="bold">Bsf <?php $valor=formato($total); echo $valor; ?></td>
																          </tr>
																         <!-- <tr>
																	          <td>Premios Básico</td>
																	          <td>Bsf <?php $valor=formato($pbas); //echo $valor; ?></td>
																	          <td><?php //echo $total_colecciones; ?></td>
																	          <td>Bsf <?php $total_premio_basico=$pbas*$total_colecciones; $valor=formato($total_premio_basico); //echo $valor; ?></td>
																          </tr>-->
																          <tr>
																	          <td>Distribución</td>
																	          <td>Bsf <?php $valor=formato($dis); echo $valor; ?></td>
																	          <td><?php echo $total_colecciones; ?></td>
																	          <td>Bsf <?php $total_distribucion=$dis*$total_colecciones; $valor=formato($total_distribucion); echo $valor; ?></td>
																          </tr>
																          <tr>
																	          <td>Gerencia</td>
																	          <td>Bsf <?php $valor=formato($ger); echo $valor; ?></td>
																	          <td><?php echo $total_colecciones; ?></td>
																	          <td>Bsf <?php $total_gerencia=$ger*$total_colecciones; $valor=formato($total_gerencia); echo $valor; ?></td>
																          </tr>
															        </tbody>
														      </table>
													    </div>
													    <div class="divider"></div>
													    <h3 class="left-align bold paddingleft15 paddingtop10 paddingbot10 fondo3">Total a cancelar <small>Bsf <?php $total_a_cancelar=$total-$total_distribucion-$total_gerencia; $valor=formato($total_a_cancelar); echo $valor; ?></small></h3>
														<blockquote><h3>Fecha de cortes</h3></blockquote>
														<div class="row center-align nobreak">
															<div class="col-xs-12 col-sm-3">
																<h3>Primer corte:</h3>
																<h4><b><?php echo $corte_q1; ?></b></h4>
															</div>
															<div class="col-xs-12 col-sm-3">
																<h3>Segundo corte:</h3>
																<h4><b><?php echo $corte_q2; ?></b></h4>
															</div>
															<div class="col-xs-12 col-sm-3">
																<h3>Tercer corte:</h3>
																<h4><b><?php echo $corte_q3; ?></b></h4>
															</div>
															<div class="col-xs-12 col-sm-3">
																<h3>Cierre:</h3>
																<h4><b><?php echo $corte_q4; ?></b></h4>
															</div>
													    </div>
												        <?php
												        	$total_a_depositar_quincenal=$total/4;

												        	$depositado_q1=0;
												        	$depositado_q2=0;
												        	$depositado_q3=0;
												        	$depositado_q4=0;
												        	$depositado_total=0;



													        $fechacambiadadep = DateTime::createFromFormat("d/m/Y", $corte_fecha_creada);
															$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
															$fecha_creada_unix=strtotime($fechacambiadadep);

													        $fechacambiadadep = DateTime::createFromFormat("d/m/Y", $corte_q1);
															$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
															$q1_unix=strtotime($fechacambiadadep);

													        $fechacambiadadep = DateTime::createFromFormat("d/m/Y", $corte_q2);
															$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
															$q2_unix=strtotime($fechacambiadadep);

													        $fechacambiadadep = DateTime::createFromFormat("d/m/Y", $corte_q3);
															$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
															$q3_unix=strtotime($fechacambiadadep);

													        $fechacambiadadep = DateTime::createFromFormat("d/m/Y", $corte_q4);
															$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
															$q4_unix=strtotime($fechacambiadadep);


																
														    $orden_cam = array_search($cam, $array_cam);
														    
															if($orden_cam==0){
																$orden='ultima';
															}else{
																$ultimacam_comp=$ordencam-1;
																$buscar_cam=$array_cam[$ultimacam_comp];
																$query4 = "SELECT * from vive_fac WHERE usuario='$gerente_logged' AND cam='$buscar_cam'";
																$result4 = mysqli_query($mysqli, $query4);
																if(mysqli_num_rows($result4) != 0) {
																	while($row4 = mysqli_fetch_assoc($result4)) {
																		$corte_comp=$row4['fecha_creada'];
																    	$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $corte_comp);
																		$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
																		$corte_comp_unix=strtotime($fechacambiadadep);
																		$orden='antigua';
																	}
																}else{
																	$orden='sin_asignar';
																}
															}


															$stmt = $mysqli->prepare('SELECT fecha, monto FROM vive_dep WHERE usuario = ? AND cam = ?');
															$stmt->bind_param('ss', $gerente_logged, $cam);
															$stmt->execute();
															$stmt->bind_result($depFecha, $depMonto);
															$stmt->store_result();
														    while ($stmt->fetch()) {
																$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $depFecha);
																$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
																$fechaunixdep=strtotime($fechacambiadadep);
																if($fechaunixdep>=$fecha_creada_unix && $fechaunixdep<=$q1_unix){
																	$depositado_q1=$depositado_q1+$depMonto;
																	$depositado_total=$depositado_total+$depMonto;
																}elseif($fechaunixdep>$q1_unix && $fechaunixdep<=$q2_unix){
																	$depositado_q2=$depositado_q2+$depMonto;
																	$depositado_total=$depositado_total+$depMonto;
																}elseif($fechaunixdep>$q2_unix && $fechaunixdep<=$q3_unix){
																	$depositado_q3=$depositado_q3+$depMonto;
																	$depositado_total=$depositado_total+$depMonto;
																/*}elseif($fechaunixdep>$q3_unix && $fechaunixdep<=$q4_unix){*/
																}elseif($fechaunixdep>$q3_unix){
																	if($orden=='ultima'){
																		$depositado_q4=$depositado_q4+$depMonto;
																		$depositado_total=$depositado_total+$depMonto;
																	}elseif($orden=='antigua'){
																		if($fechaunixdep>$q3_unix && $fechaunixdep<=$corte_comp_unix){
																			$depositado_q4=$depositado_q4+$depMonto;
																			$depositado_total=$depositado_total+$depMonto;
																		}
																	}else{
																		$depositado_q4=$depositado_q4+$depMonto;
																		$depositado_total=$depositado_total+$depMonto;
																	}
																}
														    }
															$stmt->close();

															$porcentaje_q1=($depositado_q1*$total_colecciones)/$total_a_depositar_quincenal;
															$porcentaje_q2=($depositado_q2*$total_colecciones)/$total_a_depositar_quincenal;
															$porcentaje_q3=($depositado_q3*$total_colecciones)/$total_a_depositar_quincenal;
															$porcentaje_q4=0;

															if($porcentaje_q1>=$total_colecciones){$porcentaje_q1=$total_colecciones;}
															if($porcentaje_q2>=$total_colecciones){$porcentaje_q2=$total_colecciones;}
															if($porcentaje_q3>=$total_colecciones){$porcentaje_q3=$total_colecciones;}
															if($porcentaje_q4>=$total_colecciones){$porcentaje_q4=$total_colecciones;}

															$porcentaje_total=$porcentaje_q1+$porcentaje_q2+$porcentaje_q3+$porcentaje_q4;
															
															$porcentaje_q1=decimales($porcentaje_q1);
															$porcentaje_q2=decimales($porcentaje_q2);
															$porcentaje_q3=decimales($porcentaje_q3);
															$porcentaje_q4=decimales($porcentaje_q4);
															$porcentaje_total=decimales($porcentaje_total);

															$ganancia_q1=$q1*$porcentaje_q1;
															$ganancia_q2=$q2*$porcentaje_q2;
															$ganancia_q3=$q3*$porcentaje_q3;
															$ganancia_q4=0;

															$ganancia_total=$ganancia_q1+$ganancia_q2+$ganancia_q3+$ganancia_q4;

															$deuda_pendiente=$total_a_cancelar-$depositado_total;
														?>
														<blockquote><h3>Premios Quincenales</h3></blockquote>
													    <h3 class="left-align bold paddingleft15 paddingtop10 paddingbot10 fondo3">Total a depositar quincenal <small>Bsf <?php $valor=formato($total_a_depositar_quincenal); echo $valor; ?></small></h3>
														<div class="row nobreak">
															<table class="responsive-table striped centered">
															        <thead>
															          <tr class="fondo1 white-text">
																	    <th>Quincena</th>
																	    <th>Depositado</th>
																	    <th>Quincenales</th>
																	    <th>Premios Bsf</th>
															          </tr>
															        </thead>
															        <tbody>
																          <tr>
																	          <td>Depósito 1era quincena<br>(<?php echo $corte_q1; ?>)</td>
																	          <td>Bsf <?php $valor=formato($depositado_q1); echo $valor; ?></td>
																	          <td><?php echo $porcentaje_q1; ?></td>
																	          <td>Bsf <?php $valor=formato($ganancia_q1); echo $valor; ?></td>
																          </tr>
																          <tr>
																	          <td>Depósito 2da quincena<br>(<?php echo $corte_q2; ?>)</td>
																	          <td>Bsf <?php $valor=formato($depositado_q2); echo $valor; ?></td>
																	          <td><?php echo $porcentaje_q2; ?></td>
																	          <td>Bsf <?php $valor=formato($ganancia_q2); echo $valor; ?></td>
																          </tr>
																          <tr>
																	          <td>Depósito 3ra quincena<br>(<?php echo $corte_q3; ?>)</td>
																	          <td>Bsf <?php $valor=formato($depositado_q3); echo $valor; ?></td>
																	          <td><?php echo $porcentaje_q3; ?></td>
																	          <td>Bsf <?php $valor=formato($ganancia_q3); echo $valor; ?></td>
																          </tr>
																          <tr>
																	          <td>Cuarto cierre<br>(<?php echo $corte_q4; ?>)</td>
																	          <td>Bsf <?php $valor=formato($depositado_q4); echo $valor; ?></td>
																	          <td><?php echo $porcentaje_q4; ?></td>
																	          <td>Bsf <?php $valor=formato($ganancia_q4); echo $valor; ?></td>
																          </tr>
																          <tr>
																	          <td class="bold">Total depositado</td>
																	          <td class="bold">Bsf <?php $valor=formato($depositado_total); echo $valor; ?></td>
																	          <td class="bold"><?php echo $porcentaje_total; ?></td>
																	          <td class="bold">Bsf <?php $valor=formato($ganancia_total); echo $valor; ?></td>
																          </tr>
															        </tbody>
														    </table>
														    </div>
														    <div class="row">
														    	<div class="divider"></div>
														    	<h4 class="left-align">Total deuda <small>Bsf <?php $valor=formato($total_a_cancelar); echo $valor; ?></small></h4>
														    </div>
														    <div class="row">
														    	<h3 class="left-align bold paddingleft15 paddingtop10 paddingbot10 red white-text">Deuda pendiente <small>Bsf <?php $valor=formato($deuda_pendiente); echo $valor; ?></small></h3>
													    	</div>
													    	<?php
													    		if($orden_cam==0){
													    			?>
																	<script>
																		function Grafica() {

																      google.charts.load('current', {'packages':['corechart']});
																      google.charts.setOnLoadCallback(drawChart);
																      function drawChart() {

																        var data = google.visualization.arrayToDataTable([
																          ['Estado', 'Cantidad'],
																          ['Deuda',  <?php echo $deuda_pendiente; ?>],
																          ['Pagado', <?php echo $depositado_total; ?>]
																        ]);

																        var options = {
																        	slices: {
																	            0: { color: '#ff5252' },
																	            1: { color: '#13B88D' }
																	        },
																					chartArea:{width:'100%',height:'100%'},
																        };

																        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

																        chart.draw(data, options);

																			};
																		}
																	</script>
																	<div class="row">
																		<div class="col-xs-12">
																			<div id="piechart"></div>
																		</div>
																	</div>
																	<?php
																}
															?>
														</div>
													</div>
												</li>
											</ul>
										<?php
										} else { ?>
											<ul class="collapsible" data-collapsible="accordion">
												<li>
													<div class="collapsible-header"><h3>Campaña #<?php echo $cam; ?></h3></div>
													<div class="collapsible-body paddingleft15 paddingright15">
														<h1>No posee colecciones asignadas</h1>
													</div>
												</li>
											</ul>
										<?php }
									}
								} ?>

						</div>
					</div>
				</div>
			</div>
			<?php
		}
	} ?>
<?php
} else {
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit();
 } get_footer(); ?>
<script>
	jQuery(document).ready(function() {
	    jQuery('.collapsible').collapsible();
			Grafica();
	  });
</script>
