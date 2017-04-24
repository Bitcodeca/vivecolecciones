<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else {

			if(isset($_POST['btn'])){
			}
			?>
			<div class="container-fluid margintop25 marginbot25">
				<div class="row"> 		
		    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		    			<h1 class="center-align margintop0">Duplicados</h1>
			        	<?php
						$query0 = "SELECT referencia, count(referencia) as duplicado from vive_dep GROUP BY referencia HAVING COUNT(referencia) >=2 ORDER BY 'vive_dep.usuario' ASC";
						$result0 = mysqli_query($mysqli, $query0);
						if(mysqli_num_rows($result0) != 0) { ?>
							<ul class="collapsible popout imprimir" data-collapsible="expandable" ng-app="contactApp" ng-controller="customersCtrl">
								<?php
								while($row0 = mysqli_fetch_assoc($result0)) {
									$ref=$row0['referencia'];
									?>
									<li class="nobreak">
										<div class="collapsible-header paddingtop5 paddingbot5">
											<h3 class="margintop0 marginbot0 marginleft25">
												<?php echo '<b>('.$row0['duplicado'].')</b> '.$row0['referencia']; ?>
											</h3>
										</div>
										<div class="collapsible-body white">

											<table class="striped responsive-table">
										        <thead>
										          <tr>
										              <th data-field="id">Fecha</th>
										              <th data-field="id">Usuario</th>
										              <th data-field="name">Banco</th>
										              <th data-field="price">Referencia</th>
										              <th data-field="price">Monto</th>
										              <th data-field="price">Campaña</th>
										              <th data-field="price">Acción</th>
										          </tr>
										        </thead>

										        <tbody>
												<?php 
												$query1 = "SELECT * FROM vive_dep WHERE referencia='$ref'";
												$result1 = mysqli_query ($mysqli, $query1);
												if(mysqli_num_rows($result1) != 0) {
													while ($row1 = mysqli_fetch_assoc($result1)) {
														$id=$row1['id'];
														?>
														<tr>
													        <td><?php echo $row1['fecha']; ?></td>
													        <td><?php echo $row1['usuario']; ?></td>
													        <td><?php echo $row1['banco']; ?></td>
													        <td><?php echo $row1['referencia']; ?></td>
													        <td>Bsf <?php if (is_numeric($row1['monto'])){$valor=formato($row1['monto']); echo $valor;}else{echo $row1['monto'];} ?></td>
													        <td><?php echo $row1['cam']; ?></td>
													        <td>
																<button id="btn<?php echo $id; ?>" class="btn-floating btn hoverable red waves-effect waves-light " data-id="<?php echo $id; ?>" ng-click="APROBAR($event)" ng-disabled="button<?php echo $id; ?>" >
																	<i id="icono<?php echo $id; ?>" class="material-icons left medium">delete_forever</i>
																</button>
																<input type="hidden" name="depid<?php echo $id; ?>" id="depid<?php echo $id; ?>" value="<?php echo $id; ?>" />
															</td>
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
					<button onclick="expandAll()" class="btn hoverable fondo3 waves-effect waves-light btn-radius"><i class="material-icons left">add</i> Abrir todos</button>
					<button onclick="collapseAll()" class="btn hoverable fondo3 waves-effect waves-light btn-radius"><i class="material-icons left">remove</i> Cerrar todos</button>
	            </div>

				<script>
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
    	?>
			<h1> ACCESO NEGADO </h1>
		<?php
	}  ?>
	<?php
} else {  
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

		$scope.APROBAR = function(e) {
			var id = jQuery(e.currentTarget).attr("data-id");
			var depid = jQuery('#depid'+id).val();
			$http.get("<?php site_url(); ?>/wp-content/themes/Vivev2/api/duplicados.php", {params:{"id": depid }})
			.then(function (response) {
				jQuery("#btn"+id).removeClass("red").addClass("grey");
				jQuery('#btn'+id).prop('disabled', true);
			}); 

		}
		
	});
</script>