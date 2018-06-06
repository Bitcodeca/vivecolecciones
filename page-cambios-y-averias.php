<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) {
	    	?>
			<h1>ERROR DE CONEXIÓN</h1>
	    	<?php
	    } else { ?>
		    	<div class="container-fluid margintop25 marginbot25">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card-panel z-depth-2 hoverable">
							<h1 class="center-align">Cambios y Averías</h1>
								<div class="row">
									<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="default">Default</button>
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="fecha:asc">Fechas anteriores</button>
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius active" data-sort="fecha:desc">Fechas recientes</button>
							  	</div>
						  	<div class="row">
							  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="name:asc">Ordenar por Nombre (A-Z)</button>
    							<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="name:desc">Ordenar por Nombre (Z-A)</button>
						  	</div>
				        	<div class="imprimir" id="Container">
								<table class="striped responsive-table">
							        <thead>
							          <tr>
							              <th data-field="id">Gerente</th>
							              <th data-field="id">Fecha</th>
							              <th data-field="id">Colección</th>
							              <th data-field="id">Motivo</th>
							              <th data-field="id">Descripción</th>
							              <th data-field="id">Cantidad</th>
							              <th data-field="id">Especificación</th>
							              <th data-field="id">Status</th>
							          </tr>
							        </thead>

							        <tbody>

										<?php 
										$query = "SELECT * FROM vive_cya";
										$result = mysqli_query ($mysqli, $query);
										if(mysqli_num_rows($result) != 0) {
											while ($row = mysqli_fetch_assoc($result)) { 
													$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $row['fec']);
													$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
													$fechaunixdep=strtotime($fechacambiadadep);
												?>
												<tr class="mix" data-name="<?php echo $row['usuario']; ?>" data-fecha="<?php echo $fechaunixdep; ?>">
											        <td><?php echo $row['usuario']; ?></td>
											        <td><?php echo $row['fec']; ?></td>
											        <td><?php echo $row['art']; ?></td>
											        <td><?php echo $row['mot']; ?></td>
											        <td><?php echo $row['des']; ?></td>
											        <td><?php echo $row['can']; ?></td>
											        <td><?php echo $row['esp']; ?></td>
											        <td><?php echo $row['status']; ?></td>
											    </tr>
											<?php
											}
										} else {
											?>
											<h3 class="center-align">No hay cambios o averías registradas</h3>
											<?php
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
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//																			GERENTE																				  //
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
	    	?>
			<div class="container-fluid margintop25 marginbot25">	
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Cambios y Averías</h1>

							<?php
								$stmt = $mysqli->prepare("SELECT id FROM vive_cya_con WHERE usuario=?");
					            $stmt->bind_param("s", $gerente_logged);
					            $stmt->execute();
					            $stmt->store_result();
					            $numberofrows = $stmt->num_rows;
					            if($numberofrows>0){
									?>

									<div ng-controller="ContactController">
										<form ng-submit="submit(contactform)" role="form" method="post" name="contactform" action="" class="margintop25" >
											
											<div class="row">

												<div class="input-field col-xs-12 col-sm-2">
													<h4>Colección</h4>
													<span ng-class="{ 'has-error': contactform.art.$invalid && submitted }">
										        		<input type="text" placeholder="Colección" name="art"  id="art"  class="inputfield" ng-model="formData.art" required>
										        	</span>
										        </div>

												<div class="input-field col-xs-12 col-sm-2">
													<h4>Motivo</h4>
													<span ng-class="{ 'has-error': contactform.mot.$invalid && submitted }">
										        		<input type="text" placeholder="Motivo" name="mot"  id="mot"  class="inputfield" ng-model="formData.mot" required>
										        	</span>
										        </div>

												<div class="input-field col-xs-12 col-sm-3">
													<h4>Descripción</h4>
													<span ng-class="{ 'has-error': contactform.des.$invalid && submitted }">
										        		<input type="text" placeholder="Descripción" name="des"  id="des"  class="inputfield" ng-model="formData.des" required>
										        	</span>
										        </div>

												<div class="input-field col-xs-12 col-sm-2">
													<h4>Cantidad</h4>
													<span ng-class="{ 'has-error': contactform.can.$invalid && submitted }">
										        		<input type="number" placeholder="Cantidad" name="can"  id="can"  class="inputfield" ng-model="formData.can" min="1" required>
										        	</span>
										        </div>

												<div class="input-field col-xs-12 col-sm-3">
													<h4>Especifique</h4>
													<span ng-class="{ 'has-error': contactform.esp.$invalid && submitted }">
										        		<input type="text" placeholder="Especifique" name="esp"  id="esp"  class="inputfield" ng-model="formData.esp" required>
										        	</span>
										        </div>

									        </div>

									        <input type="hidden" name="usuario" id="usuario" ng-model="formData.usuario" ng-init="formData.usuario='<?php echo $gerente_logged; ?>'" />

									        <div class="row">
							                    <div ng-app="myApp" class="">
							                        <div add-input class="center-align">
							                            <button type="button" class="btn btn-radius waves-effect waves-light fondo3" id="agregarproducto"><i class="material-icons left">add</i>Agregar Campo</button>
							                        </div>
							                    </div>
											</div>
											
											<div class="row center-align">
												<button  type="submit" ng-disabled="submitButtonDisabled" class="btn btn-radius fondo3 waves-effect waves-light margintop25" type="submit">
													<i class="material-icons medium left">&#xE2C3;</i>
													REGISTRAR CAMBIO Y AVERÍA
												</button>
											</div>
										<p ng-class="result" style="padding: 15px; margin: 0;">{{ resultMessage }}</p>
										</form>
									</div>
									<?php
								}
								else{
							    	?>
									<h1 class="center-align">No puede ingresar un cambio o avería</h1>
							    	<?php
								}
            					$stmt->close();
							?>

							<div class="divider margintop25"></div>
					     	<h1 class="center-align">Cambios y Averías Registradas</h1>
				        	<div class="imprimir" id="Container">
								<table class="striped responsive-table">
							        <thead>
							          <tr>
							              <th data-field="id">Status</th>
							              <th data-field="id">Fecha</th>
							              <th data-field="name">Colección</th>
							              <th data-field="price">Motivo</th>
							              <th data-field="price">Descripción</th>
							              <th data-field="price">Cantidad</th>
							              <th data-field="price">Especificación</th>
							          </tr>
							        </thead>

							        <tbody>
										<?php
											$stmt = $mysqli->prepare('SELECT fec, art, mot, des, can, esp, status FROM vive_cya WHERE usuario = ?');
											$stmt->bind_param('s', $gerente_logged);
											$stmt->execute();
											$stmt->bind_result($fec, $art, $mot, $des, $can, $esp, $status);
											$stmt->store_result();
										    while ($stmt->fetch()) {
												$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fec);
												$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
												$fechaunixdep=strtotime($fechacambiadadep);
												?>
												<tr class="mix" data-myorder="<?php echo $fechaunixdep; ?>"  data-name="<?php echo $status; ?>">
											        <td><?php echo $status; ?></td>
											        <td><?php echo $fec; ?></td>
											        <td><?php echo $art; ?></td>
											        <td><?php echo $mot; ?></td>
											        <td><?php echo $des; ?></td>
											        <td><?php echo $can; ?></td>
											        <td><?php echo $esp; ?></td>
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
								<div class="row">
									<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="default">Default</button>
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="myorder:asc">Fechas anteriores</button>
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius active" data-sort="myorder:desc">Fechas recientes</button>
							  	</div>
							  	<div class="row">
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="name:asc">Ordenar por Status (A-Z)</button>
	    							<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="name:desc">Ordenar por Status (Z-A)</button>
							  	</div>
						    </div>


						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}  ?>
	<?php
}
else {  
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit(); 
 } get_footer(); ?>
<script>
	jQuery(document).ready(function() {
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

<script>
	app.controller('ContactController', function ($scope, $http, $compile, $element) {
	    $scope.result = 'hidden'
	    $scope.resultMessage;
	    $scope.formData; //formData is an object holding the name, email, subject, and message
	    $scope.submitButtonDisabled = false;
	    $scope.submitted = false; //used so that form errors are shown only after the form has been submitted
	    $scope.submit = function(contactform) {
	        $scope.submitted = true;
	        $scope.submitButtonDisabled = true;
	        if (contactform.$valid) {
	            $http({
	                method  : 'POST',
	                url     : '<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/registrar-cya.php',
	                data    : jQuery.param($scope.formData),
	                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
	            }).success(function(data){
	                console.log(data);
	                if (data.success) {
	                    $scope.submitButtonDisabled = true;
	                    $scope.resultMessage = window.alert(data.message);
	                    $scope.result='';
	                } else {
	                    $scope.submitButtonDisabled = false;
	                    $scope.resultMessage = window.alert(data.message);
	                    $scope.result='bg-danger';
	                }
	            });
	        }
	    }
	    $scope.inputCounter=0;
	});
	app.directive('addInput', ['$compile', function ($compile,$scope) { 
		return {
		    restrict: 'A',
		    link: function (scope, element, attrs) {
		        element.find('button').bind('click', function () {
		            var input = angular.element('<div class="row">' +

						'<div class="input-field col-xs-12 col-sm-2">' +
							'<h4>Colección</h4>' +
				        		'<input type="text" placeholder="Colección" name="art' + scope.inputCounter + '"  id="art' + scope.inputCounter + '"  class="inputfield" ng-model="formData.art' + scope.inputCounter + '" required>' +
				        '</div>' +

						'<div class="input-field col-xs-12 col-sm-2">' +
							'<h4>Motivo</h4>' +
				        		'<input type="text" placeholder="Motivo" name="mot' + scope.inputCounter + '"  id="mot' + scope.inputCounter + '"  class="inputfield" ng-model="formData.mot' + scope.inputCounter + '" required>' +
				        '</div>' +

						'<div class="input-field col-xs-12 col-sm-3">' +
							'<h4>Descripción</h4>' +
				        		'<input type="text" placeholder="Descripción" name="des' + scope.inputCounter + '"  id="des' + scope.inputCounter + '"  class="inputfield" ng-model="formData.des' + scope.inputCounter + '" required>' +
				        '</div>' +

						'<div class="input-field col-xs-12 col-sm-2">' +
							'<h4>Cantidad</h4>' +
				        		'<input type="number" placeholder="Cantidad" name="can' + scope.inputCounter + '"  id="can' + scope.inputCounter + '"  class="inputfield" ng-model="formData.can' + scope.inputCounter + '" min="1" required>' +
				        '</div>' +

						'<div class="input-field col-xs-12 col-sm-3">' +
							'<h4>Especifique</h4>' +
				        		'<input type="text" placeholder="Especifique" name="esp' + scope.inputCounter + '"  id="esp' + scope.inputCounter + '"  class="inputfield" ng-model="formData.esp' + scope.inputCounter + '" required>' +
				        '</div>');
		            var compile = $compile(input)(scope);

		            element.append(compile);
		            scope.inputCounter++;
		            scope.$apply();
		        });
		    }
		}
	}]);
 </script>