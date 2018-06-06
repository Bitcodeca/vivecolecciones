<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else { ?>

			<div class="container-fluid margintop25 marginbot25" ng-app="contactApp" ng-controller="customersCtrl">

		    	<h1 class="center-align margintop0">PREMIOS</h1>
	    		<div class="row">
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable">
							<div class="row">
								<div class="input-field col s12">
									<input type="text" id="gerente" class="autocomplete" ng-model="gerente" ng-change="PREMIO_QUERY()" >
									<label for="gerente">GERENTE</label>
						        </div>
					        </div>
        					<?php
								$stmt0 = $mysqli->prepare("SELECT DISTINCT cam FROM vive_cam ORDER BY cam DESC");
								$stmt0->execute();
								$stmt0->bind_result($cam);
								$stmt0->store_result();
								$array_cam=array();
								?>
						  		<div class="row margintop50">
						  			<div class="input-field col s12">
								    	<select id="campanas" ng-model="campanas" ng-change="PREMIO_QUERY()" >
								    		<option value="" disabled selected>Todas</option>
									  		<?php
										    while ($stmt0->fetch()) {
										    	?>  
											      <option value="<?php echo $cam; ?>">Campaña #<?php echo $cam; ?></option>
											  	<?php
										    }
											?>
								    	</select>
								    	<label>SELECCIONAR CAMPAÑA</label>
								    </div>
						  		</div>
						  		<?php
							    $stmt0->close();

								$stmt0 = $mysqli->prepare("SELECT DISTINCT tipo FROM vive_pre ORDER BY tipo DESC");
								$stmt0->execute();
								$stmt0->bind_result($tipo);
								$stmt0->store_result();
								$array_cam=array();
								?>
						  		<div class="row margintop50">
						  			<div class="input-field col s6">
								    	<select id="tipos" ng-model="tipos" ng-change="PREMIO_QUERY()" >
								    		<option value="" disabled selected>Todos</option>
									  		<?php
										    while ($stmt0->fetch()) {
										    	?>
											      <option value="<?php echo $tipo; ?>"><?php echo $tipo; ?></option>
											  	<?php
										    }
											?>
								    	</select>
								    	<label>SELECCIONAR TIPO DE PREMIO</label>
								    </div>
						  		<?php
							    $stmt0->close();


							    
							    $stmt1 = $mysqli->prepare("SELECT DISTINCT cam FROM vive_con");
								$stmt1->execute();
								$stmt1->bind_result($cam);
								$stmt1->store_result();
								?>
						  			<div class="input-field col s6">
								    	<select id="articulos" ng-model="articulos" ng-change="PREMIO_QUERY()" >
								    		<option value="" disabled selected>Todos</option>
									  		<?php
											while ($stmt1->fetch()) {
												?>
      											<optgroup label="Campaña #<?php echo $cam; ?>">
												<?php
												$stmt0 = $mysqli->prepare("SELECT DISTINCT articulo FROM vive_pre WHERE cam='$cam' ORDER BY tipo DESC");
												$stmt0->execute();
												$stmt0->bind_result($articulos);
												$stmt0->store_result();
														    while ($stmt0->fetch()) {
														    	?>
															      <option value="<?php echo $articulos; ?>"><?php echo $articulos; ?></option>
															  	<?php
														    }
											    $stmt0->close();
											    ?>
											    </optgroup>
											    <?php
											}
											?>
								    	</select>
								    	<label>SELECCIONAR ARTICULO</label>
								    </div>
						  		</div>
						  		<?php
							    $stmt1->close();


        					?>
        					 
        				</div>
    				</div>
				</div>
	    		<div class="row">
	        		<div class="col-xs-12">
        				<div class="card-panel z-depth-2 hoverable">
								<div class="row">
									<table class="highlight responsive-table striped">
								        <thead>
								          <tr>
								              <th class="center-align">Campaña</th>
								              <th class="center-align">Gerente</th>
								              <th class="center-align">Premio</th>
								              <th class="center-align">Tipo</th>
								              <th class="center-align">Cantidad</th>
								              <th class="center-align">Editar</th>
								          </tr>
								        </thead>
										<tbody>
											<tr ng-repeat="preinf in premio_info">
												<td class="center-align paddingtop1 paddingbot0">
													<h5>{{ preinf.cam }}</h5>
												</td>
												<td class="center-align paddingtop1 paddingbot0">
													<h5>{{ preinf.usuario }}</h5>
												</td>
												<td class="center-align paddingtop1 paddingbot0">
													<h5>{{ preinf.nombre }}</h5>
												</td>
												<td class="center-align paddingtop1 paddingbot0">
													<h5>{{ preinf.tipo }}</h5>
												</td>
												<td class="center-align paddingtop1 paddingbot0">
													<h5>{{ preinf.cantidad }}</h5>
												</td>
												<td class="center-align paddingtop1 paddingbot0">
													<h5 ng-click="modificar(preinf.id)" style="cursor: pointer;"><i class="material-icons">edit</i></h5>
												</td>
											</tr>
										</tbody>
									</table>
									<h1 class="right-align">Total <span class="bolder" id="premtotal"></span></h1>
								</div>
        				</div>
    				</div>
				</div>
	    	<div id="modal1" class="modal">
			    <div class="modal-content">
			      <h2>MODIFICAR PREMIO</h2>
			      	<input type="hidden" id="idModificar" ng-model="idModificar" value="" >

			          <label for="usuario">GERENTE</label>
			        <div class="input-field col s12">
			          <input id="usuarioModificar" ng-model="usuarioModificar" value="" >
			        </div>
			      	
			          <label for="cam">CAMPAÑA</label>
			        <div class="input-field col s12">
			      	<input id="camModificar" ng-model="camModificar" value="" >
			        </div>

			        <label for="nombre">ARTICULO</label>
			        <div class="input-field col s12">
			      	<input id="nombreModificar" ng-model="nombreModificar" value="" >
			        </div>

			          <label for="cantidad">CANTIDAD</label>
			        <div class="input-field col s12">
			      	<input id="cantidadModificar" ng-model="cantidadModificar" value="" >
			        </div>
			    </div>
			    <div class="modal-footer">
			      <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat yellow" ng-click="modificar_premio()">MODIFICAR</button>
			      <button href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">CANCELAR</button>
			    </div>
			</div>
	    	</div>
	    <?php }
	} else{ ?>
	<?php	}  ?>
<?php } else {  
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit(); 
 } get_footer(); ?>
<script>
	jQuery(document).ready(function() {
		jQuery('select').material_select();
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
	  });
</script>
<script>
	app.controller('customersCtrl', function($scope, $http, $timeout) { 

		$scope.PREMIO_QUERY = function() {
			var ger = jQuery('#gerente').val();
			var cam = jQuery('#campanas').val();
			var tip = jQuery('#tipos').val();
			var art = jQuery('#articulos').val();
			var queryA = [];

			if(ger!='' || cam!=null || tip!=null || art!=null){
				if (ger!='') { queryA.push(" vive_fac_prem.usuario='"+ger+"' "); }
				if (cam!=null) { queryA.push(" vive_fac_prem.cam='"+cam+"' "); }
				if (tip!=null) { queryA.push(" vive_pre.tipo='"+tip+"' "); }
				if (art!=null) { queryA.push(" vive_pre.articulo='"+art+"' "); }
		    	var query = "WHERE " + queryA.join(' AND ');
			} else {
				var query = " ";
			}

			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/premios_query.php", {params:{"query": query }})
			.then(function (response) {
				$scope.premio_info = response.data.records;
				document.getElementById("premtotal").innerHTML = response.data.total;
			}); 
		}

		$scope.modificar = function(param) {
			jQuery('#modal1').modal('open');

			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/premios_modif.php", {params:{"id": param }})
			.then(function (response) {
				$scope.idModificar=response.data.records[0].id;
				$scope.usuarioModificar=response.data.records[0].usuario;
			    $scope.camModificar=response.data.records[0].cam;
			    $scope.nombreModificar=response.data.records[0].nombre;
			    $scope.cantidadModificar=response.data.records[0].cantidad;
			});
		}

		$scope.modificar_premio = function() {
			
				
				var query = "usuario='"+ $scope.usuarioModificar +"', cam='"+ $scope.camModificar +"', nombre='"+ $scope.nombreModificar +"', cantidad='"+ $scope.cantidadModificar +"' WHERE id="+ $scope.idModificar;
				
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/premios_modif_update.php", {params:{"query": query }})
			.then(function (response) {
				$scope.PREMIO_QUERY();
			});

		}

		$scope.PREMIO_QUERY();
	});
</script>