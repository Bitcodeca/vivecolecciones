<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else {
	    		if(isset($_POST['btn'])){
	    			$buscar_query=array();
	    			if(isset($_POST['ruta']) && !empty($_POST['ruta'])){
	    				$ruta=$_POST['ruta'];
	    			}
	    			 ?>
			    	<div class="container-fluid margintop25 marginbot25">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card-panel z-depth-2 hoverable">
								<h1 class="center-align">Gerentes</h1>
								<?php
									if(isset($_POST['usuario'])){
										?>
										<h2 class="center-align"><?php echo $_POST['usuario']; ?></h2>
										<?php
									}
								?>
							  	<div class="row">
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="name:asc">Ordenar por Nombre (A-Z)</button>
	    							<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="name:desc">Ordenar por Nombre (Z-A)</button>
							  	</div>
							  	<div class="row">
								  	<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="estado:asc">Ordenar por Estado (A-Z)</button>
	    							<button type="button" class="sort btn hoverable fondo3 waves-effect waves-light btn-radius" data-sort="estado:desc">Ordenar por Estado (Z-A)</button>
							  	</div>
					        	<div class="imprimir" id="Container">
									<table class="striped responsive-table">
								        <thead>
								          <tr>
								              <th data-field="id">Última conexión</th>
								              <th data-field="id">Gerente</th>
								              <th data-field="id">Teléfono</th>
								              <th data-field="id">Cédula</th>
								              <th data-field="id">Estado</th>
								              <th data-field="name">Dirección</th>
								              <th data-field="price">Comentario</th>
								              <th data-field="price">Ruta</th>
								          </tr>
								        </thead>

								        <tbody>

											<?php 
												 $args = array('meta_query'=> array( array( array( 'key' => 'ruta', 'value' => $ruta ) ) ) );

											    $users = get_users( $args );
												foreach ($users as $user) {

													$usuario=$user->user_login;
													$query = "SELECT * FROM vive_usu_inf where usuario='".$usuario."' ";
													$result = mysqli_query ($mysqli, $query);
													if(mysqli_num_rows($result) != 0) {
														while ($row = mysqli_fetch_assoc($result)) { 
															$id=user_by_login($row['usuario']);
												     		$user_last = get_user_meta( $id['id'], '_um_last_login', true );
												     		
															?>
															<tr class="mix" data-name="<?php echo $row['usuario']; ?>" data-estado="<?php echo $row['estado']; ?>" data-ruta="<?php echo str_replace(' ', '', $ruta); ?>">
														        <td><?php echo gmdate("d/m/Y, H:i:s", $user_last); ?></td>
														        <td><?php echo $row['usuario']; ?></td>
														        <td><?php echo $row['telefono']; ?></td>
														        <td><?php echo $row['cedula']; ?></td>
														        <td><?php echo $row['estado']; ?></td>
														        <td><?php echo $row['direccion']; ?></td>
														        <td><?php echo $row['comentario']; ?></td>
														        <td><?php echo $ruta; ?></td>
														    </tr>
														<?php
														}
													}
												}
											?>
								        </tbody>
								    </table>


					            </div>
					            <div class="row">
					                <div class="pager-list center-align marginbot25 margintop25"></div>
					            </div>
					            <div class="row">
									<button onclick="imprimir()" class="btn hoverable fondo3 waves-effect waves-light btn-radius"><i class="material-icons left">print</i> Imprimir</button>
					            </div>
								<script>
									function imprimir() {
									    window.print();
									}
								</script>
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
									<form name="importa" method="post" >

										<div class="row">
											<div class="col-xs-12 col-sm-4 col-sm-offset-4">
												<h1 class="center-align">Buscar Gerentes en Ruta</h1>

												<div class="input-field col-xs-12">
													<h4>Ruta</h4>
									        		<input type="text" placeholder="Ruta" name="ruta"  id="ruta">
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
	    jQuery('select').material_select();
	    jQuery('.collapsible').collapsible();
		function checkWidth() {
            var w = jQuery(window).width();
            if (w>992){
		        jQuery('#Container').mixItUp({
		        	layout: { display: 'table-row' },
		            animation: { duration: 200 },
		            pagination: { limit: 50, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
		            selectors: { sort: '.sort', pagersWrapper: '.pager-list' }
		        });
            } else {
		        jQuery('#Container').mixItUp({
		        	layout: { display: 'inline-block' },
		            animation: { duration: 200 },
		            pagination: { limit: 50, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
		            selectors: { sort: '.sort', pagersWrapper: '.pager-list' }
		        });
            } 
        }
        checkWidth();
        jQuery(window).resize(checkWidth);
	  });
</script>