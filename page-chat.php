<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
    require_once 'api/vive-db.php';
    if (mysqli_connect_errno()) { ?> <h1>ERROR DE CONEXIÓN</h1> <?php }
	else {?>
		<style>
			.collection .collection-item.avatar { min-height: 65px; }
			.chat { min-height: 100px; }
			.chatheight { height: 384px; overflow-y: scroll; }
			.bubble{ background-color: #F2F2F2; border-radius: 5px; box-shadow: 0 0 6px #B2B2B2; display: inline-block; padding: 10px 18px; position: relative; vertical-align: top; font-size: 1.2em; }
			.bubble::before {  background-color: #F2F2F2; content: "\00a0"; display: block; height: 16px; position: absolute; top: 11px;
			    transform:             rotate( 29deg ) skew( -35deg );
			        -moz-transform:    rotate( 29deg ) skew( -35deg );
			        -ms-transform:     rotate( 29deg ) skew( -35deg );
			        -o-transform:      rotate( 29deg ) skew( -35deg );
			        -webkit-transform: rotate( 29deg ) skew( -35deg );
			    width:  20px;
			}
			.me { float: left;  margin: 5px 45px 5px 20px; }
			.me::before { box-shadow: -2px 2px 2px 0 rgba( 178, 178, 178, .4 ); left: -9px; }
			.you { float: right; margin: 5px 20px 5px 45px; }
			.you::before { box-shadow: 2px -2px 2px 0 rgba( 178, 178, 178, .4 ); right: -9px; }
		</style>
		<div class="container-fluid">	
    		<div class="row">
				<div class="col-md-12">
					<div class="card-panel z-depth-2 hoverable">


						<div ng-app="contactApp" ng-controller="customersCtrl">

					     	<ul class="collection">
								<li class="collection-item avatar">
									<img src="<?php echo site_url(); ?>/wp-content/plugins/ultimate-member/assets/img/default_avatar.jpg" alt="" id="foto" class="circle">
									<span class="title">{{ Nombre }} {{ Apellido }}</span>
									<p>{{ usuariologged }}</p>
								</li>


								<li class="collection-item chatheight" id="chat">
									<div class="row" ng-repeat="x in names">
										<div class="{{ x.Grid }}">
											<div class="{{ x.Inner }}">
												{{ x.Msn }}
											</div>
										</div>
									</div>
								</li>



								<li class="collection-item">
									<div class="input-field col-xs-8 col-sm-10 col-md-11 chat">
										<textarea id="msn" class="materialize-textarea" length="500"></textarea>
										<label for="msn">Escribir mensaje</label>
									</div>
									<div class="col-xs-4 col-sm-2 col-md-1 right-align">
										<button ng-disabled="submitButtonDisabled" ng-click="pushData()" value="siguiente" id="btn" name="btn" class="btn btn-radius margintop25 fondo3 waves-effect waves-light">
											<i class="material-icons medium">send</i>
										</button>
									</div>
								</li>
							</ul>

							

						</div>

					</div>
				</div>
			</div>
		</div>

    <?php }
	} else {  
		header("Location: http://app.vivecolecciones.com.ve/");
		exit(); 
	} get_footer(); ?>
<script>
 	jQuery(document).ready(function(){
 		jQuery('textarea#msn').characterCounter();
 		jQuery("#chat").animate({ scrollTop: jQuery('#chat').prop("scrollHeight")}, 700);
	});  
</script>
<script>
	app.controller('customersCtrl', function($scope, $http, $timeout, $compile) { 

		$scope.userInfo = function(){ 
			$http.get("<?php site_url(); ?>/wp-content/themes/Vivev2/api/user-info.php", {params:{"usuario": sessionStorage.getItem("sent") }})
			.then(function (response) {
				var jsondata2 = response.data.records2;
				for (var index2 = 0; index2 < jsondata2.length; ++index2) {
				    $scope.Nombre=jsondata2[index2].Nombre;
				    $scope.Apellido=jsondata2[index2].Apellido;
				    if(jsondata2[index2].Fotourl != 'vacio'){
					    var fotourl='<?php echo site_url(); ?>/wp-content/uploads/ultimatemember/'+jsondata2[index2].ID+'/'+jsondata2[index2].Fotourl;
					    jQuery('#foto').attr("src", fotourl);
				    }
				}
			}); 
		};

		$scope.getData = function(){ 
			$http.get("<?php site_url(); ?>/wp-content/themes/Vivev2/api/msn.php", {params:{"usuario": sessionStorage.getItem("sent"), "logged": '<?php echo $user_logged['login']; ?>' }})
			.then(function (response) {
				$scope.names = response.data.records;
			}); 
		};

		$scope.intervalFunction = function(){
			$timeout(function() {
				$scope.getData();
				$scope.intervalFunction();
			}, 10000)
		};

		$scope.pushData = function() {
			var msn = jQuery('#msn').val();
			var usuario = sessionStorage.getItem("sent");
			var logged = '<?php echo $user_logged['login']; ?>';
			$http.get("<?php site_url(); ?>/wp-content/themes/Vivev2/api/msn-input.php", {params:{"usuario": usuario, "logged": logged, "msn": msn }})
			.then(function (response) {
				$scope.submitButtonDisabled = true;
				$scope.getData();
				jQuery('#msn').val('');
				$timeout(function() { $scope.submitButtonDisabled = false; }, 2000)
			}); 
		}

		$scope.userInfo();
		$scope.getData();
		$scope.intervalFunction();
		$scope.usuariologged = sessionStorage.getItem("sent");
	});
</script>