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
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Denuncias</h1>


						</div>
					</div>
				</div>
			</div>
	    <?php }
	} elseif ($user_logged['rol']=='Gerente') {
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
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Denuncias</h1>

							<div ng-controller="ContactController">
								<form ng-submit="submit(contactform)" role="form" method="post" name="contactform" action="" class="margintop25" >
									<div class="row marginbot0">
										<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
											<h4>Nombre y Apellido</h4>
											<span ng-class="{ 'has-error': contactform.nombre.$invalid && submitted }">
								        		<input type="text" placeholder="NOMBRE Y APELLIDO" name="nombre"  id="nombre"  class="inputfield" ng-model="formData.nombre" min="0" required>
								        	</span>
								        </div>
							        </div>
									<div class="row marginbot0">
										<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
											<h4>Cédula</h4>
											<span ng-class="{ 'has-error': contactform.cedula.$invalid && submitted }">
								        		<input type="number" placeholder="CÉDULA" name="cedula"  id="cedula"  class="inputfield" ng-model="formData.cedula" min="0" required>
								        	</span>
								        </div>
							        </div>
									<div class="row marginbot0">
										<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
											<h4>Localidad</h4>
											<span ng-class="{ 'has-error': contactform.localidad.$invalid && submitted }">
								        		<input type="text" placeholder="LOCALIDAD" name="localidad"  id="localidad"  class="inputfield" ng-model="formData.localidad" min="0" required>
								        	</span>
								        </div>
							        </div>
									<div class="row marginbot0">
										<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
											<h4>Comentario</h4>
											<span ng-class="{ 'has-error': contactform.comentario.$invalid && submitted }">
								        		<input type="text" placeholder="COMENTARIO" name="comentario"  id="comentario"  class="inputfield" ng-model="formData.comentario" min="0" required>
								        	</span>
								        </div>
							        </div>
									
									<input type="hidden" name="usuario" id="usuario" ng-model="formData.usuario" ng-init="formData.usuario='<?php echo $gerente_logged; ?>'" />
									
									<div class="row center-align">
										<button  type="submit" ng-disabled="submitButtonDisabled" class="btn btn-radius fondo3 waves-effect waves-light margintop25" type="submit">
											<i class="material-icons medium left">&#xE2C3;</i>
											REGISTRAR DENUNCIA
										</button>
									</div>
								</form>
								<p ng-class="result" style="padding: 15px; margin: 0;">{{ resultMessage }}</p>
							</div>
						</div>
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
	app.controller('ContactController', function ($scope, $http, $compile) {
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
	                url     : '<?php site_url(); ?>/wp-content/themes/Vivev2/api/agregar-denuncia.php',
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
</script>