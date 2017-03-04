<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	 if($user_logged['rol']=='administrator'){ ?>

<div class="container margintop25 marginbot25">
	<div class="col-xs-12 col-sm-12">
		<div class="card-panel z-depth-2 hoverable">
			<h1 class="bold center-align">Agregar Nueva Campaña</h1>

			<div ng-controller="ContactController">
				<form ng-submit="submit(contactform)" role="form" method="post" name="contactform" action="" class="margintop25" >
					<div class="row marginbot0">
						<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
							<h4>Número de campaña</h4>
							<span ng-class="{ 'has-error': contactform.cam.$invalid && submitted }">
				        		<input type="number" placeholder="NÚMERO DE CAMPAÑA" name="cam"  id="cam"  class="inputfield" ng-model="formData.cam" min="0" required>
				        	</span>
				        </div>
			        </div>
					<div class="row marginbot0">
						<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
							<h4>Ganancia de Vendedor</h4>
							<span ng-class="{ 'has-error': contactform.gven.$invalid && submitted }">
				        		<input type="number" placeholder="Ganancia de Vendedor" name="gven"  id="gven"  class="inputfield" ng-model="formData.gven" min="0" required>
				        	</span>
				        </div>
			        </div>
					<div class="row marginbot0">
						<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
							<h4>Premio Básico</h4>
							<span ng-class="{ 'has-error': contactform.pbas.$invalid && submitted }">
				        		<input type="number" placeholder="Premio Básico" name="pbas"  id="pbas"  class="inputfield" ng-model="formData.pbas" min="0" required>
				        	</span>
				        </div>
			        </div>
					<div class="row marginbot0">
						<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
							<h4>Distribución</h4>
							<span ng-class="{ 'has-error': contactform.dis.$invalid && submitted }">
				        		<input type="number" placeholder="Distribución" name="dis"  id="dis"  class="inputfield" ng-model="formData.dis" min="0" required>
				        	</span>
				        </div>
			        </div>
					<div class="row marginbot0">
						<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
							<h4>Gerencia</h4>
							<span ng-class="{ 'has-error': contactform.ger.$invalid && submitted }">
				        		<input type="number" placeholder="Gerencia" name="ger"  id="ger"  class="inputfield" ng-model="formData.ger" min="0" required>
				        	</span>
				        </div>
			        </div>
					<div class="row marginbot0">
						<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
							<h4>Q1</h4>
							<span ng-class="{ 'has-error': contactform.q1.$invalid && submitted }">
				        		<input type="number" placeholder="Q1" name="q1"  id="q1"  class="inputfield" ng-model="formData.q1" min="0" required>
				        	</span>
				        </div>
			        </div>
					<div class="row marginbot0">
						<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
							<h4>Q2</h4>
							<span ng-class="{ 'has-error': contactform.q2.$invalid && submitted }">
				        		<input type="number" placeholder="Q2" name="q2"  id="q2"  class="inputfield" ng-model="formData.q2" min="0" required>
				        	</span>
				        </div>
			        </div>
					<div class="row marginbot0">
						<div class="input-field col-xs-12 col-sm-4 col-sm-offset-4">
							<h4>Q3</h4>
							<span ng-class="{ 'has-error': contactform.q3.$invalid && submitted }">
				        		<input type="number" placeholder="Q3" name="q3"  id="q3"  class="inputfield" ng-model="formData.q3" min="0" required>
				        	</span>
				        </div>
			        </div>
                    <div ng-app="myApp" class="">
                        <div add-input class="center-align">

				      		<div class="row">
		                    	<h3 class="center-align">Artículos {{inputCounter}}</h3>
	                            <button type="button" id="agregarArticulo" class="btn btn-radius waves-effect waves-light fondo3" id="agregarproducto"><i class="material-icons left">add</i>Agregar Artículo</button>
							</div>
							<div class="row">
		                    	<h3 class="center-align">Premios {{premios}}</h3>
	                            <button type="button" id="agregarPremio" class="btn btn-radius waves-effect waves-light fondo3" id="agregarproducto"><i class="material-icons left">add</i>Agregar Premio</button>
	                        </div>
					
						</div>
                    </div>

					<div class="row center-align">
						<button  type="submit" ng-disabled="submitButtonDisabled" class="btn btn-radius fondo3 waves-effect waves-light margintop25" type="submit">
							<i class="material-icons medium left">&#xE2C3;</i>
							REGISTRAR CAMPAÑA
						</button>
					</div>
				</form>
				<p ng-class="result" style="padding: 15px; margin: 0;">{{ resultMessage }}</p>
			</div>

		</div>
	</div>
</div>	

<?php } else { ?> 
	<h1>ACCESO NEGADO</h1>
	<?php } 
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
	                url     : '<?php site_url(); ?>/wp-content/themes/Vivev2/api/agregar-campana.php',
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
	    $scope.premios=0;
	});
	app.directive('addInput', ['$compile', function ($compile,$scope) { 
		return {
		    restrict: 'A',
		    link: function (scope, element, attrs) {
		        element.find('#agregarArticulo').bind('click', function () {
		            var input = angular.element('<div class="input-field col-xs-12 col-sm-12 margintop25">' +
		                    '<span >' +
		                    	'<input type="text" placeholder="NOMBRE DEL ARTÍCULO" name="art' + scope.inputCounter + '"  id="art' + scope.inputCounter + '"  class="inputfield" ng-model="formData.art' + scope.inputCounter + '" min="0" required>' +
		                    '</span>' +
		                 '</div>');
		            var compile = $compile(input)(scope);


		            var input2 = angular.element('<div class="input-field col-xs-12 col-sm-6">' +
		                    '<span >' +
		                    	'<input type="number" placeholder="COSTO" name="cos' + scope.inputCounter + '"  id="cos' + scope.inputCounter + '"  class="inputfield" ng-model="formData.cos' + scope.inputCounter + '" min="0" required>' +
		                    '</span>' +
		                 '</div>'); 
		            var compile2 = $compile(input2)(scope);
		            
		            var input3 = angular.element('<div class="input-field col-xs-12 col-sm-6">' +
		                    '<span >' +
		                    	'<input type="text" placeholder="REFERENCIA" name="ref' + scope.inputCounter + '"  id="ref' + scope.inputCounter + '"  class="inputfield" ng-model="formData.ref' + scope.inputCounter + '" min="0">' +
		                    '</span>' +
		                 '</div>'); 
		            var compile3 = $compile(input3)(scope);

		            element.append(compile);
		            element.append(compile2);
		            element.append(compile3);
		            scope.inputCounter++;
		            scope.$apply();
		        });

		        element.find('#agregarPremio').bind('click', function () {
		            var input = angular.element('<div class="row">' +
			            	'<div class="input-field col-xs-12 col-sm-6">' +
			                    '<span >' +
			                    	'<input type="text" placeholder="NOMBRE DEL PREMIO" name="premio' + scope.premios + '"  id="premio' + scope.premios + '" ng-model="formData.premio' + scope.premios + '" required>' +
			                    '</span>' +
			                '</div>' +
			                '<div class="input-field col-xs-12 col-sm-6">' +
			                    '<select class="browser-default" name="tipo' + scope.premios + '"  id="tipo' + scope.premios + '" ng-model="formData.tipo' + scope.premios + '" required>' +
									'<option value="" disabled selected>Selecciona el tipo de premio</option>' +
									<?php
										$premio=premiosTipo();
										foreach ($premio as $opcion) { ?>
											'<option value="<?php echo $opcion; ?>"><?php echo $opcion; ?></opcion>' +
										<?php
										}
									?>
								'</select>' +
			                '</div>' +
		                '</div>');
		            var compile = $compile(input)(scope);
		            element.append(compile);
		            scope.premios++;
		            scope.$apply();
		        });
		    }
		}
	}]);
 </script>