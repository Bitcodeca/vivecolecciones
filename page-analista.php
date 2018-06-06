<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else {
	    		if(isset($_POST['btn'])){
	    			$analista=$_POST['usuario']; ?>
			    	<div class="container-fluid margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable" ng-app="contactApp" ng-controller="customersCtrl">

								<h1><?php echo $analista; ?></h1>
						     	<div class="row">						
									<h4 class="bold"><i class="material-icons color5 verticalalignbottom">&#xE7FF;</i> Asignación de usuarios</h4>
									<div class="row">
										<div class="input-field col-xs-12">
											<input type="text" id="analista" class="autocomplete gerente">
											<label for="analista"></label>
								        </div>
							        </div>
							        <div class="row">
										<button ng-disabled="analista_Button" ng-click="analista_PUSH()" class="btn hoverable fondo3 waves-effect waves-light btn-radius secondary-content">
											<i class="material-icons large left">add</i>
											Agregar
										</button>
									</div>
									<div class="row overflowscroll">
										<table class="highlight responsive-table striped">
												<tr ng-repeat="analista in analista_info">
													<td class="right-align paddingtop1 paddingbot0">
														<h5>{{ analista.Gerente }}</h5>
													</td>
													<td class="left-align paddingtop1 paddingbot0">
														<p class="margintop0 marginbot0">
														    <input type="checkbox" id="dev_{{ analista.Id }}" ng-model="analista[$index]" ng-change="analista_DEL(analista.Id)" ng-checked="{{checked}}" />
														    <label for="dev_{{ analista.Id }}"></label>
													    </p>
													</td>
												</tr>
										</table>
									</div>
								</div>

							</div>
						</div>
					</div>

	    		<?php }
	    		else {
	    		?>

			    	<div class="container margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable">
								<div class="row">
									<form name="importa" method="post" action="?" >

										<div class="row">
											<div class="col-xs-12 col-sm-4 col-sm-offset-4">
												<h1 class="center-align">Seleccionar Analista</h1>

												<div class="input-field col-xs-12">
													<input placeholder="Seleccionar gerente" type="text" name="usuario" id="usuario" class="autocomplete analista">
													<label for="usuario"></label>
										        </div>

											</div>
										</div>
										<div class="row center-align">
											<button type="submit" value="buscar" id="btn" name="btn" class="btn fondo3 btn-radius waves-effect waves-light">
												<i class="material-icons medium right">arrow_forward</i>
												BUSCAR
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				<?php
				} ?>
	    <?php }
	} else{ ?>
		<h1> ACCESO NEGADO </h1>
	<?php	}  ?>
<?php } else {
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit();
 } get_footer(); ?>
<script>
	jQuery(document).ready(function() {
		jQuery('input.analista').autocomplete({
			data: {
				<?php
					$rol='Analista';
					$devoluciones=usuarioPorRol($rol);
					foreach ($devoluciones as $value) {
					?>
			  			"<?php echo $value['login']; ?>": '<?php echo $value['avatarxs']; ?>',
					<?php
					}
				?>
			}
		});
		jQuery('input.gerente').autocomplete({
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
	    jQuery('.collapsible').collapsible();
	  });
</script>
<?php
	if(isset($_POST['btn'])){
		?>
		<script>
			app.controller('customersCtrl', function($scope, $http, $timeout) { 
		////////////////////////////////////////////////////////////////////
		//////////////////////  ANALISTA   ////////////////////////////////
		//////////////////////////////////////////////////////////////////
				$scope.analista_PUSH = function() {
					var analista = '<?php echo $analista; ?>';
					var gerente = jQuery('#analista').val();
					console.log(analista);
					console.log(gerente);
					$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/analista-push.php", {params:{"analista": analista, "gerente": gerente }})
					.then(function (response) {
						$scope.analista_Button = true;
						jQuery('#analista').val('');
						$scope.analista_PULL();
						$timeout(function() { $scope.analista_Button = false; }, 2000)
					}); 
				}
				$scope.analista_PULL = function() {
					var analista = '<?php echo $analista; ?>';
					$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/analista-pull.php", {params:{"analista": analista }})
					.then(function (response) {
						$scope.analista_info = response.data.records;
					}); 
				}

				$scope.analista_DEL = function(devId) {
					var valor = devId;
					$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/analista-del.php", {params:{"id": valor }})
					.then(function (response) {
						$scope.analista_PULL();
					}); 
				}
				
				$scope.checked =true;
				$scope.analista_PULL();
			});
		</script>
		<?php
	}
?>
