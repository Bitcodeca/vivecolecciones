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
		    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		    			<h1 class="center-align margintop0">Devoluciones</h1>
			        	<?php


						if(isset($_POST['btn'])){
							$artId=$_POST['id'];
							$query2 = "DELETE FROM vive_dev WHERE id=$artId";
							if ($mysqli->query( $query2 ) === TRUE) {
							}
						}

						$query3 = "SELECT DISTINCT usuario from vive_dev ORDER BY usuario ASC";
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
										              <th data-field="id">Fecha</th>
										              <th data-field="id">Artículo</th>
										              <th data-field="id">Cantidad</th>
										              <th data-field="id">Acción</th>
										          </tr>
										        </thead>

										        <tbody>
												<?php 
												$query = "SELECT * FROM vive_dev WHERE usuario='$usu'";
												$result = mysqli_query ($mysqli, $query);
												if(mysqli_num_rows($result) != 0) {
													while ($row = mysqli_fetch_assoc($result)) {
														$id=$row['id'];
														?>
														<tr>
													        <td><?php echo $row['fec']; ?></td>
													        <td><?php echo $row['art']; ?></td>
													        <td><?php echo $row['can']; ?></td>
													        <td>
													        	<a id="btn" name="btn" class="btn-floating waves-effect waves-light fondo3" href="#modal<?php echo $id; ?>">
													        		<i class="material-icons left">create</i>
																	EDITAR
																</a>
															</td>
													    <div id="modal<?php echo $id; ?>" class="modal">
															<form role="form" method="post" name="form<?php echo $row['id']; ?>" action="" >
															    <div class="modal-content">
															        <h3><?php echo $row['usuario']; ?></h3>
															        <h4><?php echo $row['art']; ?></h4>
															    </div>

																<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />

															    <div class="modal-footer">
																	<button type="submit" name="btn" id="btn" value="editar" class="btn hoverable fondo5 waves-effect waves-light btn-radius" type="submit">
																		<i class="material-icons left">mode_edit</i>
																		BORRAR
																	</button>
																	<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">CANCELAR</a>
															    </div>
														    </form>
														</div>
													    </tr>
													<?php
													}
												} ?>
												</tbody>
											</table>

										</div>
									</li>
									<?php
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
								$stmt = $mysqli->prepare('SELECT SUM(ABS(vive_dev.can)) FROM vive_dev');
								$stmt->execute();
								$stmt->bind_result($total);
							    $stmt->fetch();
								$stmt->close();
							?>
        					<h3>Total: <?php echo $total; ?></h3>
        				 	<div id="devoluciones"></div>
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
	    	?>
			<div class="container margintop25 marginbot25">	
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Devoluciones</h1>

							<?php
								$stmt = $mysqli->prepare("SELECT id FROM vive_dev_con WHERE usuario=?");
					            $stmt->bind_param("s", $gerente_logged);
					            $stmt->execute();
					            $stmt->store_result();
					            $numberofrows = $stmt->num_rows;
					            if($numberofrows>0){
									?>

									<div ng-controller="ContactController">
										<form ng-submit="submit(contactform)" role="form" method="post" name="contactform" action="" class="margintop25" >
											
											<div class="row">

												<div class="input-field col-xs-12 col-sm-6">
													<h4>Colección</h4>
													<span ng-class="{ 'has-error': contactform.art.$invalid && submitted }">
										        		<input type="text" placeholder="Colección" name="art"  id="art"  class="inputfield" ng-model="formData.art" required>
										        	</span>
										        </div>

												<div class="input-field col-xs-12 col-sm-6">
													<h4>Cantidad</h4>
													<span ng-class="{ 'has-error': contactform.can.$invalid && submitted }">
										        		<input type="number" placeholder="Cantidad" name="can"  id="can"  class="inputfield" ng-model="formData.can" min="1" required>
										        	</span>
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
													REGISTRAR DEVOLUCIÓN
												</button>
											</div>
										<p ng-class="result" style="padding: 15px; margin: 0;">{{ resultMessage }}</p>
										</form>
									</div>
									<?php
								}
								else{
							    	?>
									<h1 class="center-align">No puede ingresar una devolución</h1>
							    	<?php
								}
            					$stmt->close();
							?>

							<div class="divider margintop25"></div>
					     	<h1 class="center-align">Devoluciones Registradas</h1>
				        	<div class="imprimir" id="Container">
								<table class="striped responsive-table">
							        <thead>
							          <tr>
							              <th data-field="id">Fecha</th>
							              <th data-field="name">Colección</th>
							              <th data-field="price">Cantidad</th>
							          </tr>
							        </thead>

							        <tbody>
										<?php
											$stmt = $mysqli->prepare('SELECT fec, art, can FROM vive_dev WHERE usuario = ?');
											$stmt->bind_param('s', $gerente_logged);
											$stmt->execute();
											$stmt->bind_result($fec, $art, $can);
											$stmt->store_result();
										    while ($stmt->fetch()) {
												$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fec);
												$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
												$fechaunixdep=strtotime($fechacambiadadep);
												?>
												<tr class="mix" data-myorder="<?php echo $fechaunixdep; ?>" >
											        <td><?php echo $fec; ?></td>
											        <td><?php echo $art; ?></td>
											        <td><?php echo $can; ?></td>
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
		} else {

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
		    ?>


		    	<div class="container-fluid margintop25 marginbot25">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card-panel z-depth-2 hoverable">
							<h1 class="center-align">Devoluciones</h1>
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
							              <th data-field="id">Cantidad</th>
							          </tr>
							        </thead>

							        <tbody>

										<?php 
										$query = "SELECT * FROM vive_dev WHERE usuario IN ('$buscar_gerente')";
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
											        <td><?php echo $row['can']; ?></td>
											    </tr>
											<?php
											}
										} else {
											?>
											<h3 class="center-align">No hay devoluciones registradas</h3>
											<?php
										}
										?>
							        </tbody>
							    </table>


				            </div>
				            <div class="row">
				                <div class="pager-list center-align marginbot25 margintop25"></div>
				            </div>
				            <div class="row marginbotmenos40">
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
				<?php
	    }
    }
} else {  
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
	                url     : '<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/registrar-devolucion.php',
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

						'<div class="input-field col-xs-12 col-sm-6">' +
							'<h4>Colección</h4>' +
				        		'<input type="text" placeholder="Colección" name="art' + scope.inputCounter + '"  id="art' + scope.inputCounter + '"  class="inputfield" ng-model="formData.art' + scope.inputCounter + '" required>' +
				        '</div>' +
						'<div class="input-field col-xs-12 col-sm-6">' +
							'<h4>Cantidad</h4>' +
				        		'<input type="number" placeholder="Cantidad" name="can' + scope.inputCounter + '"  id="can' + scope.inputCounter + '"  class="inputfield" ng-model="formData.can' + scope.inputCounter + '" min="1" required>' +
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
								$stmt = $mysqli->prepare("SELECT SUM(ABS(vive_dev.can)), 
																 vive_dev.art
																 FROM vive_dev 
																 GROUP BY vive_dev.art");
								$stmt->execute();
								$stmt->bind_result($devCan, $devArt);
								$stmt->store_result();
								$total=0;
							    while ($stmt->fetch()) {
							    	echo "['".$devArt."',".$devCan."],";
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

			      var chart = new google.charts.Bar(document.getElementById('devoluciones'));

			      chart.draw(data, options);
			    }

		 </script>
		<?php
	}
?>