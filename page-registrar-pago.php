<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else {  ?>

			    	<div class="container margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable">
								<h1 class="center-align imprimir">Registrar Pago</h1>


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
	    	?>
			<div class="container margintop25 marginbot25" ng-controller="customersCtrl">	
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Registrar Pago</h1>

							<div ng-app="contactApp">
						     	<div class="row margintop25">
							     	<div class="col-xs-12 col-md-2">
										<div class="input-field">
											<h4>Fecha</h4>
											<input type="date" class="datepicker" id="fec" name="fec">
										</div>
							     	</div>
							     	<div class="col-xs-12 col-md-2">
										<h4>Banco</h4>
										<select name="ban" id="ban" required>
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
							     	<div class="col-xs-12 col-md-3">
										<div class="input-field">
											<h4>Referencia</h4>
							        		<input type="number" placeholder="Referencia" name="ref"  id="ref" required>
										</div>
							     	</div>
							     	<div class="col-xs-12 col-md-2">
										<div class="input-field">
											<h4>Monto</h4>
							        		<input type="number" placeholder="Monto" name="mon"  id="mon" required>
										</div>
							     	</div>
							     	<div class="col-xs-12 col-md-3">
										<div class="input-field">
											<h4>Campaña</h4>
											<select name="cam" id="cam" required>
												<option value="" disabled selected>Selecciona la Campaña</option>
												<?php
													$stmt = $mysqli->prepare('SELECT DISTINCT cam FROM vive_fac WHERE usuario = ? ORDER BY cam ASC');
													$stmt->bind_param('s', $gerente_logged);
													$stmt->execute();
													$stmt->bind_result($cam);
													$stmt->store_result();
												    while ($stmt->fetch()) {
														?>
														<option value="<?php echo $cam; ?>">Campaña #<?php echo $cam; ?></option>
														<?php
												    }
													$stmt->close();
												?>
												<label>Seleccionar</label>
											</select>
										</div>
							     	</div>
									<div class="row center-align">
										<button  ng-disabled="reg_Button" ng-click="reg_PUSH()" class="btn btn-radius fondo3 waves-effect waves-light">
											<i class="material-icons medium right">cloud_upload</i>
											REGISTRAR
										</button>
									</div>
						     	</div>
					     	</div>

							<div class="divider margintop25"></div>
					     	<h1 class="center-align">Pagos Aprobados</h1>
				        	<div class="">
								<table class="striped responsive-table">
							        <thead>
							          <tr>
							              <th data-field="id">Fecha</th>
							              <th data-field="name">Banco</th>
							              <th data-field="price">Referencia</th>
							              <th data-field="price">Monto</th>
							              <th data-field="price">Campaña</th>
							          </tr>
							        </thead>

							        <tbody id="Container">
											<tr id="{{ $index }}" class="mix variable" data-myorder="{{ x.Fechaunixdep }}"  data-name="{{ x.Banco }}" data-cam="{{ x.Cam }}" ng-repeat="x in pulldata">
										        <td>{{ x.Fecha }}</td>
										        <td>{{ x.Banco }}</td>
										        <td>{{ x.Referencia }}</td>
										        <td>Bsf {{ x.Monto }}</td>
										        <td>{{ x.Cam }}</td>
										    </tr>
							        </tbody>
							    </table>
					            <div class="row margintop25">
					                <div class="pager-list center-align marginbot25 margintop25"></div>
					            </div>
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
						    </div>

						    <div class="divider"></div>
					     	<h1 class="center-align">Pagos Problemas</h1>
				        	<div class="" id="Container2">
								<table class="striped responsive-table">
							        <thead>
							          <tr>
							              <th data-field="id">Status</th>
							              <th data-field="id">Fecha</th>
							              <th data-field="name">Banco</th>
							              <th data-field="price">Referencia</th>
							              <th data-field="price">Monto</th>
							              <th data-field="price">Campaña</th>
							              <th data-field="price">Comentarios</th>
							          </tr>
							        </thead>

							        <tbody>
										<?php
											$stmt = $mysqli->prepare('SELECT status, fecha, banco, referencia, monto, cam, comentario FROM vive_pen WHERE usuario = ?');
											$stmt->bind_param('s', $gerente_logged);
											$stmt->execute();
											$stmt->bind_result($status, $fecha, $banco, $referencia, $monto, $cam, $comentario);
											$stmt->store_result();
										    while ($stmt->fetch()) {
										    	if($status=='aprobado'){$clase='fondo3';}elseif($status=='vacio'){$clase='grey lighten-5';}elseif($status=='pendiente'){$clase='yellow';}elseif($status=='negado'){$clase='fondo5';}
												$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fecha);
												$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
												$fechaunixdep=strtotime($fechacambiadadep);
												?>
												<tr class="mix" data-myorder="<?php echo $fechaunixdep; ?>"  data-name="<?php echo $banco; ?>" data-cam="<?php echo $cam; ?>">
											    	<td class="<?php echo $clase; ?>"><?php echo $status; ?></td>
											        <td><?php echo $fecha; ?></td>
											        <td><?php echo $banco; ?></td>
											        <td><?php echo $referencia; ?></td>
											        <td>Bsf <?php if (is_numeric($monto)){$valor=formato($monto); echo $valor;}else{echo $monto;} ?></td>
											        <td><?php echo $cam; ?></td>
											        <td><?php echo $comentario; ?></td>
											    </tr>
												<?php
										    }
											$stmt->close();
										?>
							        </tbody>
							    </table>
					            <div class="row margintop25">
					                <div class="pager-list2 center-align marginbot25 margintop25"></div>
					            </div>
								<div class="row">
									<button type="button" class="sort2 btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="default">Default</button>
								  	<button type="button" class="sort2 btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="myorder:asc">Fechas anteriores</button>
								  	<button type="button" class="sort2 btn hoverable fondo3 waves-effect waves-light btn-radius active" data-sort="myorder:desc">Fechas recientes</button>
							  	</div>
							  	<div class="row">
								  	<button type="button" class="sort2 btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="name:asc">Ordenar por Banco (A-Z)</button>
	    							<button type="button" class="sort2 btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="name:desc">Ordenar por Banco (Z-A)</button>
							  	</div>
							  	<div class="row">
								  	<button type="button" class="sort2 btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="cam:asc">Ordenar por campaña (A-Z)</button>
	    							<button type="button" class="sort2 btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="cam:desc">Ordenar por campaña (Z-A)</button>
							  	</div>
							</div>



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
	  });
</script>
<script>
	jQuery(document).ready(function() {
	    jQuery('select').material_select();
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
		            pagination: { limit: 15, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
		            selectors: { sort: '.sort', pagersWrapper: '.pager-list' }
		        });
		        jQuery('#Container2').mixItUp({
		        	layout: { display: 'table-row' },
		            animation: { duration: 200 },
		            pagination: { limit: 15, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
		            selectors: { sort: '.sort2', pagersWrapper: '.pager-list2' }
		        });
            } else {
		        jQuery('#Container').mixItUp({
		        	layout: { display: 'inline-block' },
		            animation: { duration: 200 },
		            pagination: { limit: 15, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
		            selectors: { sort: '.sort', pagersWrapper: '.pager-list' }
		        });
		        jQuery('#Container2').mixItUp({
		        	layout: { display: 'inline-block' },
		            animation: { duration: 200 },
		            pagination: { limit: 15, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
		            selectors: { sort: '.sort2', pagersWrapper: '.pager-list2' }
		        });
            } 
        }
        checkWidth();
        jQuery(window).resize(checkWidth);
	  });
</script>
<script>
	app.controller('customersCtrl', function($scope, $http, $timeout) { 

		$scope.reg_PUSH = function() {
			var usuario = '<?php echo $gerente_logged; ?>';
			var fec = jQuery('#fec').val();
			var mon = jQuery('#mon').val();
			var ref = jQuery('#ref').val();
			var ban = jQuery('#ban').val();
			var cam = jQuery('#cam').val();
			$http.get("<?php site_url(); ?>/wp-content/themes/Vivev2/api/registrar-pago.php", {params:{"usuario": usuario, "fec": fec, "mon": mon, "ref": ref, "ban": ban, "cam": cam }})
			.then(function (data) {
                if (data.data.success) {
                    window.alert(data.data.message);
					$scope.reg_PULL();
					jQuery('#ref').val('');
					jQuery('#fec').val('');
					jQuery('#mon').val('');
                } else {
                    window.alert(data.data.message);
                }
				$scope.reg_Button = true;
				$timeout(function() { $scope.reg_Button = false; }, 2000)
			}); 
		}
		
		$scope.reg_PULL = function() {
			var usuario = '<?php echo $gerente_logged; ?>';
			$http.get("<?php site_url(); ?>/wp-content/themes/Vivev2/api/gerente-depositos-pull.php", {params:{"usuario": usuario }})
			.then(function (response) {
				$scope.pulldata = response.data.records;
				var $users = jQuery('.variable');
				jQuery('#Container').mixItUp('append', $users , null);
				jQuery('#Container').mixItUp('sort', 'name:asc');
			}); 
		}

		$scope.reg_PULL();
	});
</script>