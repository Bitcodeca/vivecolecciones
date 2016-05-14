<?php get_header();
	if( current_user_can('subscriber')) {
		include (TEMPLATEPATH . '/funciones/usuariologged.php'); ?>
		<div class="container">
			<div class="row">
			<?php
				if(isset($_POST['enviar'])) {
					include (TEMPLATEPATH . '/funciones/registrar.php');
					if ($status=='aprobado') {
						 echo '<h1 class="letraverde">¡Gracias! Se ha realizado exitosamente el registro de depósito.</h1>';
					} elseif ($status=='pendiente') {
						  echo '<h1 class="letraamarilla">¡Gracias! Se procesará el registro realizado.</h1>';
					} elseif ($status=='negada') {
						echo '<h1 class="letraroja">Ya ha introducido el mismo registro. Intente con uno diferente.</h1>';
					}
				}
			?>
				<div class="col-md-12 margintop25">
					<h2 class="text-center">Historial de Pagos</h2>
					<div id="Container"><?php include (TEMPLATEPATH . '/funciones/verdepositos.php');?></div>
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
							<span class="finalinventario">Filtrar por Banco: </span>
							<div class="clearfix"></div>
							<a class="filter btn btn-default btnfiltro" data-filter="*">Todos</a>
							<a class="filter btn btn-default btnfiltro" data-filter=".provincial">Provincial</a>
							<a class="filter btn btn-default btnfiltro" data-filter=".banesco">Banesco</a>
							<a class="filter btn btn-default btnfiltro" data-filter=".activo">Banco Activo</a>
							<a class="filter btn btn-default btnfiltro" data-filter=".bicentenario">Banco Bicentenario</a>
							<a class="filter btn btn-default btnfiltro" data-filter=".venezuela">Banco de Venezuela</a>
							<a class="filter btn btn-default btnfiltro" data-filter=".banplus">Banco BanPlus</a>
							<a class="filter btn btn-default btnfiltro" data-filter=".mercantil">Banco Mercantil</a>  
		            </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 margintop25 marginbot25">
					<h2 class="text-center">Registrar Depósito</h2>

					<form name="importa" method="post" action="http://vivecolecciones.com.ve/registrar-pago/" >
                            <div class="col-md-12 margintop25">
								<div class="col-md-2">
									<input placeholder="Fecha"  id="fecha" name="fecha" type="text" class="form-control" required>
								</div>
								<div class="col-md-3">
									<select id="banco" name="banco" style="width: 100%; padding: 8px;" required>
										<option value="" hidden>Seleccionar Banco</option>
										<option value="provincial">Provincial</option>
										<option value="banesco">Banesco</option>
										<option value="activo">Banco Activo</option>
										<option value="bicentenario">Banco Bicentenario</option>
										<option value="venezuela">Banco de Venezuela</option>
										<option value="banplus">Banco BanPlus</option>
										<option value="mercantil">Banco Mercantil</option>
									</select>
								</div>
								<div class="col-md-3">
									<input placeholder="Número de Referencia"  id="referencia" name="referencia" type="text" class="form-control" required>
								</div>
								<div class="col-md-3">
									<div class="input-group">
									  <span class="input-group-addon">Bsf</span>
										<input placeholder="Monto"  id="monto" name="monto" type="number" class="form-control" required>
									</div>
								</div>
									<input value="<?php echo $usuariologged; ?>" id="usuario" name="usuario" type="text" hidden required>
								<div class="col-md-1">
									<input class="btn btn-primary marginauto" type='submit' name='enviar' id="enviar" value="Registrar"/>
								</div>
							</div>
						</form>
				</div>
			</div>
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
		<script>
		  jQuery(function() {
		    jQuery( "#fecha" ).datepicker({
        		dateFormat: 'dd/mm/yy',
        		maxDate: "0d"
    		});
		  });
		  </script>
	<?php }
get_footer(); ?>