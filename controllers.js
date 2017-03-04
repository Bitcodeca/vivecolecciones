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
                url     : 'contact-form.php',
                data    : $.param($scope.formData),
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data){
                console.log(data);
                if (data.success) {
                    $scope.submitButtonDisabled = true;
                    $scope.resultMessage = window.alert("Mensaje Enviado!");
                    $scope.result='';
                } else {
                    $scope.submitButtonDisabled = false;
                    $scope.resultMessage = window.alert("Mensaje No Enviado!");
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

//<div class="input-field col s12">
//    <select>
//      <option value="" disabled selected>Choose your option</option>
//      <option value="1">Option 1</option>
//      <option value="2">Option 2</option>
//      <option value="3">Option 3</option>
//    </select>
//    <label>Materialize Select</label>
//  </div>
                var input = angular.element('<div class="input-field col-xs-12 col-sm-12">' +
                        '<select name="articulo' + scope.inputCounter + '"  id="articulo' + scope.inputCounter + '" ng-model="formData.articulo' + scope.inputCounter + '">' +
                            <?php 
                                $terms = get_terms( array('taxonomy' => 'articulo', 'hide_empty' => false) );
                                
                                foreach ($terms as $term) {
                                    echo "'<option value=";
                                    echo $term->slug;
                                    echo ">Seleccionar Producto</option>'";
                                }
                            ?>
                            '<option value="productos">Seleccionar Producto</option>' +
                            '<option value="productos">Seleccionar Producto</option>' +
                            '<option value="productos">Seleccionar Producto</option>' +
                            '<option value="productos">Seleccionar Producto</option>' +
                        '</select>' +
                     '</div>');
                var compile = $compile(input)(scope);


                var input2 = angular.element('<div class="input-field col-xs-12 col-sm-6">' +
                        '<input type="number" placeholder="Cantidad" name="cantidad' + scope.inputCounter + '"  id="cantidad' + scope.inputCounter + '"  class="inputfield" ng-model="formData.cantidad' + scope.inputCounter + '" min="0">' +
                     '</div>'); 
                var compile2 = $compile(input2)(scope);
                
                var input3 = angular.element('<div class="input-field col-xs-12 col-sm-6">' +
                        '<input type="text" placeholder="Unidad" name="unidad' + scope.inputCounter + '"  id="unidad' + scope.inputCounter + '"  class="inputfield" ng-model="formData.unidad' + scope.inputCounter + '" min="0">' +
                     '</div>'); 
                var compile3 = $compile(input3)(scope);

                //element.append(input0);
                element.append(compile);
                element.append(compile2);
                element.append(compile3);
                scope.inputCounter++;
            });
        }
    }
}]);