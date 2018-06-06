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
													<input type="hidden" name="cam<?php echo $penId; ?>" id="cam<?php echo $penId; ?>" value="<?php echo $penCam; ?>" />
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
	} else{ ?>
		<h1> ACCESO NEGADO </h1>
	<?php	}  ?>
<?php } else {  
		header("Location: http://app.vivecolecciones.com.ve/");
		exit(); 
 } get_footer(); ?>
<script>
	app.controller('customersCtrl', function($scope, $http, $timeout) { 

		$scope.APROBAR = function(e) {
			var id = jQuery(e.currentTarget).attr("data-id");
			var penid = jQuery('#penid'+id).val();
			var usuario = jQuery('#usuario'+id).val();
			var depid = jQuery('#depid'+id).val();
			var pencam = jQuery('#cam'+id).val();
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/comparacionAprobar.php", {params:{"penId": penid, "usuario": usuario, "depId": depid, "penCam": pencam }})
			.then(function (response) {
				jQuery("#btn"+id).removeClass("yellow").addClass("fondo3");
				jQuery('#btn'+id).prop('disabled', true);
			}); 

		}
		
	});
</script>