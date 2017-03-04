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
					     	<h2>Seleccione el archivo a importar</h2>

							<form method="post" action="<?php echo get_bloginfo('template_directory');?>/api/detec.php" enctype="multipart/form-data">
								<div class="file-field input-field">
									<div class="btn hoverable fondo3 waves-effect waves-light btn-radius">
										<span>Archivo</span>
										<input type="file" name="excel" id="excel">
									</div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text" placeholder="Subir archivo" formtarget="_new">
									</div>
								</div>
								<div class="form-group">
									<input class="btn btn-default btn hoverable fondo3 waves-effect waves-light btn-radius " type='submit' name='enviar'  value="Importar"  formtarget="_new"  />
								</div>
							</form>

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