<?php get_header();
	include (TEMPLATEPATH . '/funciones/usuariologged.php');
	if( current_user_can('administrator')) { ?>
		<div class="container">
			<div class="row margintop25">
				<h2 class="text-center">Reporte de Cambios y Averías</h2>
			</div>
			<div class="clearfix"></div>
		</div>
	<?php } elseif( current_user_can('subscriber')) {
		$cliente=$usuariologged;
		include (TEMPLATEPATH . '/funciones/constantes.php');
		$bot=0;
		if(isset($gerentearray)) {
			if (!empty($gerentearray)) {
				foreach ($gerentearray as $gerente) {
					$variable=$gerente->name;
					if ($variable == $usuariologged) { 
						
						$bot=1; 
						if(isset($_POST['btn'])) {
							include (TEMPLATEPATH . '/funciones/cambios.php'); ?>
							<h1 class="text-center letraverde">¡Gracias! Se procesará la solicitud en la brevedad posible.</h1>
						<?php } ?>
						<div class="row margintop25">
							<h2 class="text-center">Historial de Devoluciones</h2>
							<div class="container fondoazul bordertopnegro borderbotnegro text-center margintop25">
								<div class="row">
									<div class="col-md-1 col-sm-1 col-xs-6">
										<h4>Fecha</h4>
									</div>
									<div class="col-md-1 col-sm-1 col-xs-6">
										<h4>Colección</h4>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<h4>Motivo</h4>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6">
										<h4>Descripción</h4>
									</div>
									<div class="col-md-1 col-sm-1 col-xs-6">
										<h4>Cantidad</h4>
									</div>
									<div class="col-md-1 col-sm-1 col-xs-6">
										<h4>Tipo de Cambio</h4>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<h4>Especificación</h4>
									</div>
									<div class="col-md-1 col-sm-1 col-xs-6">
										<h4>Status</h4>
									</div>
								</div>
							</div>
							<div class="clearfix margintop10"></div>
							<div id="Container"><?php include (TEMPLATEPATH . '/funciones/versolicitudes.php');?></div>
							<div class="container">
			                    <div class="pager-list marginbot10 text-center"></div>
								<div class="row marginbot10">
									<div class="text-center">  
										<span class="finalinventario">Ordernar por: </span>
										<button type="button" class="sort btn btn-default" data-sort="default">Default</button>
									  	<button type="button" class="sort btn btn-default" data-sort="myorder:asc">Anteriores</button>
									  	<button type="button" class="sort btn btn-default active" data-sort="myorder:desc">Recientes</button>
									</div>
					            </div>
					            <div class="text-left">
										<span class="finalinventario">Filtrar por Status: </span>
										<div class="clearfix"></div>
										<a class="filter btn btn-default btnfiltro" data-filter="*">Todos</a>
										<a class="filter btn btn-default btnfiltro" data-filter=".aprobado">Aprobado</a> 
										<a class="filter btn btn-default btnfiltro" data-filter=".pendiente">Pendiente</a>
										<a class="filter btn btn-default btnfiltro" data-filter=".negado">Negado</a>
					            </div>
							</div>
						</div>
						<div class="container">
							<div class="row margintop25">
								<h2 class="text-center">Reporte de Cambios y Averías</h2>
							</div>
							<div class="clearfix"></div>

							<form name="importa<?php echo $iddeposito; ?>" method="post" action="http://vivecolecciones.com.ve/cambios-y-averias/" >
								<div class="row margintop25">
									<div class="col-md-2 col-sm-2 col-xs-6">
										<h4>Colección</h4>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<h4>Motivo</h4>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<h4>Descripción</h4>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<h4>Cantidad</h4>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<h4>Tipo de Cambio</h4>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<h4>Especifique</h4>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="row marginbot25">
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Colección"  id="coleccion1" name="coleccion1" type="text" class="form-control" required>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Motivo"  id="motivo1" name="motivo1" type="text" class="form-control" required>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Descripción"  id="descripcion1" name="descripcion1" type="text" class="form-control" required>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Cantidad"  id="cantidad1" name="cantidad1" type="number" class="form-control" required>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Tipo de Cambio"  id="tipo1" name="tipo1" type="text" class="form-control" required>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Especifique"  id="especifique1" name="especifique1" type="text" class="form-control" required>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="row marginbot25">
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Colección"  id="coleccion2" name="coleccion2" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Motivo"  id="motivo2" name="motivo2" type="text" class="form-control">
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Descripción"  id="descripcion2" name="descripcion2" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Cantidad"  id="cantidad2" name="cantidad2" type="number" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Tipo de Cambio"  id="tipo2" name="tipo2" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Especifique"  id="especifique2" name="especifique2" type="text" class="form-control">
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="row marginbot25">
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Colección"  id="coleccion3" name="coleccion3" type="text" class="form-control">
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Motivo"  id="motivo3" name="motivo3" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Descripción"  id="descripcion3" name="descripcion3" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Cantidad"  id="cantidad3" name="cantidad3" type="number" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Tipo de Cambio"  id="tipo3" name="tipo3" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Especifique"  id="especifique3" name="especifique3" type="text" class="form-control" >
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="row marginbot25">
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Colección"  id="coleccion4" name="coleccion4" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Motivo"  id="motivo4" name="motivo4" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Descripción"  id="descripcion4" name="descripcion4" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Cantidad"  id="cantidad4" name="cantidad4" type="number" class="form-control">
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Tipo de Cambio"  id="tipo4" name="tipo4" type="text" class="form-control">
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Especifique"  id="especifique4" name="especifique4" type="text" class="form-control" >
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="row marginbot25">
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Colección"  id="coleccion5" name="coleccion5" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Motivo"  id="motivo5" name="motivo5" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Descripción"  id="descripcion5" name="descripcion5" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Cantidad"  id="cantidad5" name="cantidad5" type="number" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Tipo de Cambio"  id="tipo5" name="tipo5" type="text" class="form-control" >
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<input placeholder="Especifique"  id="especifique5" name="especifique5" type="text" class="form-control" >
									</div>
								</div>
								<div class="clearfix"></div>
						        <div class="col-md-12 marginbot25 text-center">
									<input class="btn btn-primary btnedc" type="submit" name="btn" id="btn"  value="Enviar" />
						        </div>
						    </form>
						</div>
						<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
						<script>
							var buttonFilter = { $filters: null, $reset: null, groups: [], outputArray: [], outputString: '',
							  init: function(){
							    var self = this;
							    self.$filters = $('#Filters');
							    self.$reset = $('#Reset');
							    self.$container = $('#Container');
							    self.$filters.find('fieldset').each(function(){
							      self.groups.push({ $buttons: $(this).find('.filter'), active: '' });
							    });
							    self.bindHandlers();
							  },
							  bindHandlers: function(){
							    var self = this;
							    self.$filters.on('click', '.filter', function(e){
							      e.preventDefault();
							      var $button = $(this);
							      $button.hasClass('active') ?
							        $button.removeClass('active') :
							        $button.addClass('active').siblings('.filter').removeClass('active');
							      self.parseFilters();
							    });
							    self.$reset.on('click', function(e){
							      e.preventDefault();
							      self.$filters.find('.filter').removeClass('active');
							      self.parseFilters();
							    });
							  },
							  parseFilters: function(){
							    var self = this;
							 	for(var i = 0, group; group = self.groups[i]; i++){
							      group.active = group.$buttons.filter('.active').attr('data-filter') || '';
							    }
							    self.concatenate();
							  },
							  concatenate: function(){
							    var self = this;
							    self.outputString = '';
							    for(var i = 0, group; group = self.groups[i]; i++){ self.outputString += group.active; }
							    !self.outputString.length && (self.outputString = 'all'); 
							    console.log(self.outputString); 
							    if(self.$container.mixItUp('isLoaded')){ self.$container.mixItUp('filter', self.outputString); }
							  }
							};
							jQuery(function(){
							  	buttonFilter.init();
								jQuery('#Container').mixItUp({
									animation: { duration: 200 },
									pagination: { limit: 5, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' }
								});
							});
						</script>
					<?php }



				} if ($bot==0) { ?>
						<div class="container">
							<h1 class="letraroja">El período para registrar cambios y averías ha terminado.</h1>
						</div>
				<?php }
			} else { ?>
				<div class="container">
					<h1 class="letraroja">El período para registrar cambios y averías ha terminado.</h1>
				</div>
			<?php }
		} else { ?>
			<div class="container">
				<h1 class="letraroja">El período para registrar cambios y averías ha terminado.</h1>
			</div>
		<?php }
	}
 get_footer(); ?>