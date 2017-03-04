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
				     	<h1 class="center-align">Agregar nueva colección</h1>
				     	<div class="row">
							<div class="card-panel z-depth-2 hoverable">							
								<div class="row">
									<div class="input-field col-xs-3">
										<div class="input-field col s12">
										    <select id="cam">
										        <option value="" disabled selected>Seleccionar campaña</option>
												<?php $query = "SELECT * from vive_con ORDER BY cam ASC";
												$result = mysqli_query($mysqli, $query);
												if(mysqli_num_rows($result) != 0) {
													while($row = mysqli_fetch_assoc($result)) {
													$cam=$row['cam']; ?>
													<option value="<?php echo $cam; ?>">Campaña #<?php echo $cam; ?></option>
													<?php }
												} ?>
										    </select>
										</div>
							        </div>
									<div class="input-field col-xs-3 paddingtop10">
										<input type="text" id="nombre" placeholder="Nombre" class="validate">
										<label for="nombre"></label>
							        </div>
									<div class="input-field col-xs-3 paddingtop10">
										<input type="number" id="costo" placeholder="Costo" class="validate">
										<label for="costo"></label>
							        </div>
									<div class="input-field col-xs-3 paddingtop10">
										<input type="text" id="ref" placeholder="Referencia" class="validate">
										<label for="ref"></label>
							        </div>
						        </div>
						        <div class="row marginbotmenos40">
									<button ng-disabled="agregar_Button" ng-click="AGREGAR()" class="btn hoverable fondo3 waves-effect waves-light btn-radius secondary-content">
										<i class="material-icons large left">add</i>
										Agregar
									</button>
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
		jQuery('select').material_select();
	  });
</script>
<script>
	app.controller('customersCtrl', function($scope, $http, $timeout) { 

		$scope.AGREGAR = function() {
			var cam = jQuery('#cam').val();
			var nombre = jQuery('#nombre').val();
			var costo = jQuery('#costo').val();
			var ref = jQuery('#ref').val();
			$http.get("<?php site_url(); ?>/wp-content/themes/Vivev2/api/coleccion-push.php", {params:{"cam": cam, "art": nombre, "cos": costo, "ref": ref }})
			.then(function (response) {
				$scope.agregar_Button = true;
				jQuery('#nombre').val('');
				jQuery('#costo').val('');
				jQuery('#ref').val('');
	            $scope.resultMessage = window.alert('Colección Agregada');
				$timeout(function() { $scope.agregar_Button = false; }, 2000)
			}); 
		}

	});
</script>