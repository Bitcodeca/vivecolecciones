<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?> <h1>ERROR DE CONEXIÓN</h1> <?php }
	    else { ?>
	    <?php }
	    
	}  elseif ($user_logged['rol']=='Gerente') {
		require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php
	    }
	    else {
			$gerente_logged=$user_logged["login"]; ?>
			<div class="container margintop25 marginbot25">	
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable" ng-app="contactApp" ng-controller="customersCtrl">
					     	<h1 class="center-align">Premios</h1>
							<?php
							$stmt = $mysqli->prepare("SELECT nombre, cantidad FROM vive_fac_prem WHERE usuario=?");
				            $stmt->bind_param("s", $gerente_logged);
				            $stmt->execute();
							$stmt->bind_result($nombre, $cantidad);
				            $stmt->store_result();
				            $numberofrows = $stmt->num_rows;
				            if($numberofrows>0){
				            	?>
									<div class="row margintop25">
										<h2>Premios Seleccionados</h2>
										<?php 
										while ($stmt->fetch()) {
											?>
												<h4><?php echo $nombre; ?>: <b><?php echo $cantidad; ?></b></h4>
											<?php
										}
										?>
									</div>
				            	<?php
				            }
				            $stmt->close();
				            ?>
							<form ng-submit="submit(contactform)" role="form" method="post" name="contactform" action="" class="margintop25" >
								<?php
								$stmt = $mysqli->prepare("SELECT id FROM vive_pre_con WHERE usuario=?");
					            $stmt->bind_param("s", $gerente_logged);
					            $stmt->execute();
					            $stmt->store_result();
					            $numberofrows = $stmt->num_rows;
					            if($numberofrows>0){
									$stmt_0 = $mysqli->prepare("SELECT cam, can FROM vive_fac WHERE usuario=?");
						            $stmt_0->bind_param("s", $gerente_logged);
						            $stmt_0->execute();
									$stmt_0->bind_result($cam, $can);
						            $stmt_0->store_result();
						            $numberofrows = $stmt_0->num_rows;
						            if($numberofrows>0){
						            	$totalColecciones=0;
								    	while ($stmt_0->fetch()) {
								    		$totalColecciones=$totalColecciones+$can;
											$campana=$cam;
								    	}
								    	?>
										<h2 class="margintop25 center-align">Total a Reclamar: <b><?php echo $totalColecciones; ?> Premios<b></h2>
										<div class="row margintop25">
										<input type="hidden" name="usuario" id="usuario" ng-model="formData.usuario" ng-init="formData.usuario='<?php echo $gerente_logged; ?>'" />
										<input type="hidden" name="cam" id="cam" ng-model="formData.cam" ng-init="formData.cam='<?php echo $cam; ?>'" />
								    	<?php
										$premio=premiosTipo();
						            	$x=0;
										foreach ($premio as $opcion) {
											?>
											<div class="divider"></div>
											<h3><?php echo $opcion; ?></h3>
											<div class="row">
												<?php
												$stmt_1 = $mysqli->prepare("SELECT id, articulo, tipo, otro FROM vive_pre WHERE cam=? AND tipo=?");
									            $stmt_1->bind_param("ss", $campana, $opcion);
									            $stmt_1->execute();
												$stmt_1->bind_result($id, $premioArticulo, $premioTipo, $premioOtro);
												$stmt_1->store_result();
									            $numberofrows = $stmt_1->num_rows;
									            if($numberofrows>0){
											    	while ($stmt_1->fetch()) {
											    		?>
											    		<div class="col-xs-12 col-sm-4">
															<h4><?php echo $premioArticulo; ?></h4>
															<h4><small><?php echo $premioTipo; if($premioTipo=='Regalo con Aporte'){ echo ' '.$premioOtro; } ?></small></h4>
															<div class="input-field">
														        <input placeholder="Cantidad" id="premio<?php echo $x; ?>" name="premio<?php echo $x; ?>" type="number" min="0" max="<?php echo $totalColecciones; ?>" class="validate" ng-model="formData.premio<?php echo $x; ?>" value='0' ng-init="formData.premio<?php echo $x; ?>=0" ng-change="calcTotal()">
														        <label for="premio<?php echo $x; ?>"></label>
													        </div>
											    		</div>
														<input type="hidden" name="nombre<?php echo $x; ?>" id="nombre<?php echo $x; ?>" ng-model="formData.nombre<?php echo $x; ?>" ng-init="formData.nombre<?php echo $x; ?>='<?php echo $premioArticulo; ?>'" />
											    		<?
											    		$x++;
											    	}
												}
												?>
											</div>
											<?php
											$stmt_1->close();
										}
										?>
										<input type="hidden" name="total" id="total" ng-model="formData.total" ng-init="formData.total='<?php echo $x; ?>'" />
										<!--<div class="row">
								    		<div class="col-xs-12 col-sm-4">
												<h4>Efectivo</h4>
												<div class="input-field">
											        <input placeholder="Cantidad" id="efectivo" name="efectivo" type="number" min="0" max="<?php //echo $totalColecciones; ?>" class="validate" ng-model="formData.efectivo" value='0' ng-init="formData.efectivo=0" ng-change="calcTotal()">
											        <label for="efectivo"></label>
										        </div>
								    		</div>
							    		</div>-->
										<h3 class="margintop25 center-align">Premios restantes: <b>{{porReclamar}}<b></h3>
								        <div class="row center-align">
											<button  type="submit" ng-disabled="submitButtonDisabled" class="btn btn-radius fondo3 waves-effect waves-light margintop25" type="submit">
												<i class="material-icons medium left">add</i>
												REGISTRAR
											</button>
										</div>
										<?php
									}
									$stmt_0->close();

								} else{
									?>
									<h2 class="center-align">No puede modificar los premios</h2>
									<?php
								}
								$stmt->close();
								?>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php 
		}
	}  ?>
<?php } else {  
		header("Location: http://app.vivecolecciones.com.ve/");
		exit(); 
 } get_footer(); ?>
<script>
	app.controller('customersCtrl', function($scope, $http, $timeout) { 

		var premiosDif = <?php echo $x; ?>;
		var totalColecciones = <?php echo $totalColecciones; ?>;
		var restante = 0;

		$scope.calcTotal = function() {
			restante = <?php echo $totalColecciones; ?>;
			for (var i = 0; i < premiosDif; i++) {
				var cya = jQuery('#premio'+i).val();
				restante = restante-cya;
			}
			//var efectivo = jQuery('#efectivo').val();
			//restante=restante-efectivo;
			$scope.porReclamar=restante;
		}

		$scope.porReclamar=totalColecciones;
		$scope.calcTotal();



	    $scope.submit = function(contactform) {
	        $scope.submitted = true;
	        if (contactform.$valid) {
	        	if ($scope.porReclamar==0){
	        		$scope.submitButtonDisabled = true;
		            $http({
		                method  : 'POST',
		                url     : '<?php site_url(); ?>/wp-content/themes/Vivev2/api/registrar-premios.php',
		                data    : jQuery.param($scope.formData),
		                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
		            }).success(function(data){
		                console.log(data);
		                if (data.success) {
		                    $scope.submitButtonDisabled = true;
		                    $scope.resultMessage = window.alert(data.message);
		                    $scope.result='';
		                    location.reload();
		                } else {
		                    $scope.submitButtonDisabled = false;
		                    $scope.resultMessage = window.alert(data.message);
		                    $scope.result='bg-danger';
		                }
		            });
	        	}
	        	if($scope.porReclamar>0){
	        		window.alert("Por favor, utilice todos sus Premios \n "+$scope.porReclamar+" Restantes");
	        	}
	        	if($scope.porReclamar<0){
	        		window.alert("Por favor, utilice todos sus Premios \n Se ha sobrepasado por "+$scope.porReclamar+"");
	        	}

	        }
	    }


	});
</script>