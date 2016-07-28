<?php get_header();
	if( current_user_can('subscriber')) { ?>
		<h1 class="letraroja">Acceso Negado</h1>
		<div class="clearfix"></div>
	<?php }
	elseif (current_user_can('administrator')) { ?>
		<div class="clearfix"></div>
	 	<div class="container">
			<div class="col-md-12 margintop50">
		     	<h2>Seleccione el archivo a importar</h2>
		        <form name="importa" method="post" action="<?php echo get_bloginfo('template_directory');?>/funciones/detec.php" enctype="multipart/form-data">
					<div class="form-group">
		                <input class="btn btn-default marginauto" type="file" name="excel" />
					</div>
					<div class="form-group">
						<input class="btn btn-default" type='submit' name='enviar'  value="Importar"  formtarget="_new"  />
					</div>
				</form>
			</div>
		</div>
		<div class="clearfix"></div>
<?php } get_footer(); ?>