<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else { ?>

			<div class="container margintop25 marginbot25">	
	    		<div class="row">
					<div class="col-md-12" ng-app="contactApp" ng-controller="customersCtrl">
				     	<h1 class="center-align">Centro de Control
				     	<br>
				     	<small>Activación de Permisos</small></h1>
				     	<div class="row">
							<div class="card-panel z-depth-2 hoverable">							
								<h4 class="bold"><i class="material-icons color5 verticalalignbottom">arrow_back</i> Devoluciones</h4>
								<div class="row">
									<div class="input-field col-xs-12">
										<input type="text" id="devoluciones" class="autocomplete">
										<label for="devoluciones"></label>
							        </div>
						        </div>
						        <div class="row">
									<button ng-disabled="devoluciones_AT_Button" ng-click="devoluciones_AT_PUSH()" class="btn hoverable fondo1 waves-effect waves-light btn-radius secondary-content left">
										<i class="material-icons large left">&#xE884;</i>
										Agregar todos
									</button>
									<button ng-disabled="devoluciones_ET_Button" ng-click="devoluciones_ET_PUSH()" class="btn hoverable fondo5 waves-effect waves-light btn-radius secondary-content left">
										<i class="material-icons large left">clear</i>
										Quitar todos
									</button>
									<button ng-disabled="devoluciones_Button" ng-click="devoluciones_PUSH()" class="btn hoverable fondo3 waves-effect waves-light btn-radius secondary-content">
										<i class="material-icons large left">add</i>
										Agregar
									</button>
								</div>
								<div class="row overflowscroll">
									<table class="highlight responsive-table striped">
											<tr ng-repeat="devoluciones in devoluciones_info">
												<td class="right-align paddingtop1 paddingbot0">
													<h5>{{ devoluciones.Usuario }}</h5>
												</td>
												<td class="left-align paddingtop1 paddingbot0">
													<p class="margintop0 marginbot0">
													    <input type="checkbox" id="dev_{{ devoluciones.Id }}" ng-model="devoluciones[$index]" ng-change="devoluciones_DEL(devoluciones.Id)" ng-checked="{{checked}}" />
													    <label for="dev_{{ devoluciones.Id }}"></label>
												    </p>
												</td>
											</tr>
									</table>
								</div>
							</div>
						</div>
				     	<div class="row">
							<div class="card-panel z-depth-2 hoverable">
								<h4 class="bold"><i class="material-icons color5 verticalalignbottom">build</i> Averías</h4>
								<div class="row">
									<div class="input-field col-xs-12">
										<input type="text" id="aver" class="autocomplete">
										<label for="aver"></label>
							        </div>
						        </div>
						        <div class="row">
									<button ng-disabled="AVER_AT_Button" ng-click="AVER_AT_PUSH()" class="btn hoverable fondo1 waves-effect waves-light btn-radius secondary-content left">
										<i class="material-icons large left">&#xE884;</i>
										Agregar todos
									</button>
									<button ng-disabled="AVER_ET_Button" ng-click="AVER_ET_PUSH()" class="btn hoverable fondo5 waves-effect waves-light btn-radius secondary-content left">
										<i class="material-icons large left">clear</i>
										Quitar todos
									</button>
									<button ng-disabled="AVER_Button" ng-click="AVER_PUSH()"  class="btn hoverable fondo3 waves-effect waves-light btn-radius secondary-content">
										<i class="material-icons large left">add</i>
										Agregar
									</button>
								</div>
								<div class="row overflowscroll">
									<table class="highlight responsive-table striped">
										<tbody>
											<tr ng-repeat="aver in aver_info">
												<td class="right-align paddingtop1 paddingbot0">
													<h5>{{ aver.Usuario }}</h5>
												</td>
												<td class="left-align paddingtop1 paddingbot0">
													<p class="margintop0 marginbot0">
													    <input type="checkbox" id="aver_{{ aver.Id }}" ng-model="aver[$index]" ng-change="aver_DEL(aver.Id)" ng-checked="{{checked}}" />
													    <label for="aver_{{ aver.Id }}"></label>
												    </p>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
				     	<div class="row">
							<div class="card-panel z-depth-2 hoverable">
								<h4 class="bold"><i class="material-icons color5 verticalalignbottom">cached</i> Cambios</h4>
								<div class="row">
									<div class="input-field col-xs-12">
										<input type="text" id="camb" class="autocomplete">
										<label for="camb"></label>
							        </div>
						        </div>
						        <div class="row">
									<button ng-disabled="CAMB_AT_Button" ng-click="CAMB_AT_PUSH()" class="btn hoverable fondo1 waves-effect waves-light btn-radius secondary-content left">
										<i class="material-icons large left">&#xE884;</i>
										Agregar todos
									</button>
									<button ng-disabled="CAMB_ET_Button" ng-click="CAMB_ET_PUSH()" class="btn hoverable fondo5 waves-effect waves-light btn-radius secondary-content left">
										<i class="material-icons large left">clear</i>
										Quitar todos
									</button>
									<button ng-disabled="CAMB_Button" ng-click="CAMB_PUSH()"  class="btn hoverable fondo3 waves-effect waves-light btn-radius secondary-content">
										<i class="material-icons large left">add</i>
										Agregar
									</button>
								</div>
								<div class="row overflowscroll">
									<table class="highlight responsive-table striped">
										<tbody>
											<tr ng-repeat="camb in camb_info">
												<td class="right-align paddingtop1 paddingbot0">
													<h5>{{ camb.Usuario }}</h5>
												</td>
												<td class="left-align paddingtop1 paddingbot0">
													<p class="margintop0 marginbot0">
													    <input type="checkbox" id="camb_{{ camb.Id }}" ng-model="camb[$index]" ng-change="camb_DEL(camb.Id)" ng-checked="{{checked}}" />
													    <label for="camb_{{ camb.Id }}"></label>
												    </p>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
				     	<div class="row">
							<div class="card-panel z-depth-2 hoverable">
								<h4 class="bold"><i class="material-icons color5 verticalalignbottom">card_giftcard</i> Premios</h4>
								<div class="row">
									<div class="input-field col-xs-12">
										<input type="text" id="premio" class="autocomplete">
										<label for="premios"></label>
							        </div>
						        </div>
						        <div class="row">
									<button ng-disabled="premio_AT_Button" ng-click="premio_AT_PUSH()" class="btn hoverable fondo1 waves-effect waves-light btn-radius secondary-content left">
										<i class="material-icons large left">&#xE884;</i>
										Agregar todos
									</button>
									<button ng-disabled="premio_ET_Button" ng-click="premio_ET_PUSH()" class="btn hoverable fondo5 waves-effect waves-light btn-radius secondary-content left">
										<i class="material-icons large left">clear</i>
										Quitar todos
									</button>
									<button ng-disabled="premio_Button" ng-click="premio_PUSH()"  class="btn hoverable fondo3 waves-effect waves-light btn-radius secondary-content">
										<i class="material-icons large left">add</i>
										Agregar
									</button>
								</div>
								<div class="row overflowscroll">
									<table class="highlight responsive-table striped">
										<tbody>
											<tr ng-repeat="premio in premio_info">
												<td class="right-align paddingtop1 paddingbot0">
													<h5>{{ premio.Usuario }}</h5>
												</td>
												<td class="left-align paddingtop1 paddingbot0">
													<p class="margintop0 marginbot0">
													    <input type="checkbox" id="premio_{{ premio.Id }}" ng-model="premio[$index]" ng-change="premio_DEL(premio.Id)" ng-checked="{{checked}}" />
													    <label for="premio_{{ premio.Id }}"></label>
												    </p>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
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

////////////////////////////////////////////////////////////////////
//////////////////////  CAMBIO   //////////////////////////////////
//////////////////////////////////////////////////////////////////
		$scope.CAMB_PUSH = function() {
			var camb = jQuery('#camb').val();
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/camb-push.php", {params:{"usuario": camb }})
			.then(function (response) {
				$scope.CAMB_Button = true;
				jQuery('#camb').val('');
				$scope.CAMB_PULL();
				$timeout(function() { $scope.CAMB_Button = false; }, 2000)
			}); 
		}
		$scope.CAMB_AT_PUSH = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/camb-push-AT.php")
			.then(function (response) {
				$scope.CAMB_AT_Button = true;
				$scope.CAMB_PULL();
				$timeout(function() { $scope.CAMB_AT_Button = false; }, 2000)
			}); 
		}
		$scope.CAMB_ET_PUSH = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/camb-push-ET.php")
			.then(function (response) {
				$scope.CAMB_ET_Button = true;
				$scope.CAMB_PULL();
				$timeout(function() { $scope.CAMB_ET_Button = false; }, 2000)
			}); 
		}
		$scope.CAMB_PULL = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/camb-pull.php")
			.then(function (response) {
				$scope.camb_info = response.data.records;
			}); 
		}
		$scope.camb_DEL = function(cambId) {
			var valor = cambId;
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/camb-del.php", {params:{"id": valor }})
			.then(function (response) {
				$scope.CAMB_PULL();
			}); 
		}

////////////////////////////////////////////////////////////////////
//////////////////////  AVERIA   //////////////////////////////////
//////////////////////////////////////////////////////////////////
		$scope.AVER_PUSH = function() {
			var aver = jQuery('#aver').val();
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/aver-push.php", {params:{"usuario": aver }})
			.then(function (response) {
				$scope.AVER_Button = true;
				jQuery('#aver').val('');
				$scope.AVER_PULL();
				$timeout(function() { $scope.AVER_Button = false; }, 2000)
			}); 
		}
		$scope.AVER_AT_PUSH = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/aver-push-AT.php")
			.then(function (response) {
				$scope.AVER_AT_Button = true;
				$scope.AVER_PULL();
				$timeout(function() { $scope.AVER_AT_Button = false; }, 2000)
			}); 
		}
		$scope.AVER_ET_PUSH = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/aver-push-ET.php")
			.then(function (response) {
				$scope.AVER_ET_Button = true;
				$scope.AVER_PULL();
				$timeout(function() { $scope.AVER_ET_Button = false; }, 2000)
			}); 
		}
		$scope.AVER_PULL = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/aver-pull.php")
			.then(function (response) {
				$scope.aver_info = response.data.records;
			}); 
		}
		$scope.aver_DEL = function(averId) {
			var valor = averId;
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/aver-del.php", {params:{"id": valor }})
			.then(function (response) {
				$scope.AVER_PULL();
			}); 
		}

////////////////////////////////////////////////////////////////////
//////////////////////  PREMIO   //////////////////////////////////
//////////////////////////////////////////////////////////////////
		$scope.premio_PUSH = function() {
			var premio = jQuery('#premio').val();
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/premio-push.php", {params:{"usuario": premio }})
			.then(function (response) {
				$scope.premio_Button = true;
				jQuery('#premio').val('');
				$scope.premio_PULL();
				$timeout(function() { $scope.premio_Button = false; }, 2000)
			}); 
		}
		$scope.premio_AT_PUSH = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/premio-push-AT.php")
			.then(function (response) {
				$scope.premio_AT_Button = true;
				$scope.premio_PULL();
				$timeout(function() { $scope.premio_AT_Button = false; }, 2000)
			}); 
		}
		$scope.premio_ET_PUSH = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/premio-push-ET.php")
			.then(function (response) {
				$scope.premio_ET_Button = true;
				$scope.premio_PULL();
				$timeout(function() { $scope.premio_ET_Button = false; }, 2000)
			}); 
		}
		$scope.premio_PULL = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/premio-pull.php")
			.then(function (response) {
				$scope.premio_info = response.data.records;
			}); 
		}
		$scope.premio_DEL = function(devId) {
			var valor = devId;
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/premio-del.php", {params:{"id": valor }})
			.then(function (response) {
				$scope.premio_PULL();
			}); 
		}

////////////////////////////////////////////////////////////////////
//////////////////////  DEVOLU   //////////////////////////////////
//////////////////////////////////////////////////////////////////
		$scope.devoluciones_PUSH = function() {
			var devoluciones = jQuery('#devoluciones').val();
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/devoluciones-push.php", {params:{"usuario": devoluciones }})
			.then(function (response) {
				$scope.devoluciones_Button = true;
				jQuery('#devoluciones').val('');
				$scope.devoluciones_PULL();
				$timeout(function() { $scope.devoluciones_Button = false; }, 2000)
			}); 
		}
		$scope.devoluciones_AT_PUSH = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/devoluciones-push-AT.php")
			.then(function (response) {
				$scope.devoluciones_AT_Button = true;
				$scope.devoluciones_PULL();
				$timeout(function() { $scope.devoluciones_AT_Button = false; }, 2000)
			}); 
		}
		$scope.devoluciones_ET_PUSH = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/devoluciones-push-ET.php")
			.then(function (response) {
				$scope.devoluciones_ET_Button = true;
				$scope.devoluciones_PULL();
				$timeout(function() { $scope.devoluciones_ET_Button = false; }, 2000)
			}); 
		}
		$scope.devoluciones_PULL = function() {
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/devoluciones-pull.php")
			.then(function (response) {
				$scope.devoluciones_info = response.data.records;
			}); 
		}

		$scope.devoluciones_DEL = function(devId) {
			var valor = devId;
			$http.get("<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/devoluciones-del.php", {params:{"id": valor }})
			.then(function (response) {
				$scope.devoluciones_PULL();
			}); 
		}
		
		$scope.checked =true;
		$scope.CAMB_PULL();
		$scope.AVER_PULL();
		$scope.devoluciones_PULL();
		$scope.premio_PULL();
	});
</script>