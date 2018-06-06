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
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Nueva Dependencia</h1>
							
							<div ng-controller="ContactController">
								<form ng-submit="submit(contactform)" role="form" method="post" name="contactform" action="" class="margintop25" >

									<div class="row margintop25">
										<div class="col-xs-12 col-sm-5">
											<h4>Gerente</h4>
											<select class="icons" name="ger" id="ger" ng-model="formData.ger" required>
												<option value="" disabled selected>Selecciona el Gerente</option>
										        	<?php
										        		$todoslosusuarios = get_users();
														foreach ( $todoslosusuarios as $user ) {
															$buscar=$user->user_login;
																preg_match('/src="(.*?)"/i', get_avatar( $user->id, 32 ), $fotoxs );
																$foto = $fotoxs[1]; ?>
																<option data-icon="<?php echo $foto; ?>" value="<?php echo $buscar; ?>"><?php echo $buscar; ?></option>
														<?php
														}
													?>
												<label>Seleccionar</label>
											</select>
										</div>

										<div class="col-xs-12 col-sm-2 center-align">
										<h4></h4>
											<i class="material-icons">arrow_forward</i>
										</div>

										<div class="col-xs-12 col-sm-5">
											<h4>Sub Gerente</h4>
											<select class="icons" name="sub" id="sub" ng-model="formData.sub" required>
												<option value="" disabled selected>Selecciona el Subgerente</option>
										        	<?php
										        		$todoslosusuarios = get_users();
														foreach ( $todoslosusuarios as $user ) {
															$buscar=$user->user_login;\
															preg_match('/src="(.*?)"/i', get_avatar( $user->id, 32 ), $fotoxs );
															$foto = $fotoxs[1]; ?>
															<option data-icon="<?php echo $foto; ?>" value="<?php echo $buscar; ?>"><?php echo $buscar; ?></option>
														<?php
														}
													?>
												<label>Seleccionar</label>
											</select>
										</div>
									</div>

									<div class="row center-align">
										<button  type="submit" ng-disabled="submitButtonDisabled" class="btn btn-radius fondo3 waves-effect waves-light margintop25" type="submit">
											<i class="material-icons medium left">group_add</i>
											REGISTRAR DEPENDENCIA
										</button>
									</div>

								</form>
							</div>

							<p ng-class="result" style="padding: 15px; margin: 0;">{{ resultMessage }}</p>

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
	app.controller('ContactController', function ($scope, $http, $compile, $timeout) {
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
	                url     : '<?php site_url(); ?>/wp-content/themes/vivecolecciones-3Q/api/agregar-dependencia.php',
	                data    : jQuery.param($scope.formData),
	                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
	            }).success(function(data){
	                console.log(data);
	                if (data.success) {
	                    $scope.submitButtonDisabled = true;
	                    $scope.resultMessage = window.alert(data.message);
	                    $scope.result='';
	                    $timeout(function() { $scope.submitButtonDisabled = false; }, 2000)
	                } else {
	                    $scope.submitButtonDisabled = false;
	                    $scope.resultMessage = window.alert(data.message);
	                    $scope.result='bg-danger';
	                }
	            });
	        }
	    }
	});
 </script>