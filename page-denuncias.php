<?php get_header();
	if( current_user_can('subscriber')) {
		include (TEMPLATEPATH . '/funciones/usuariologged.php'); ?>
		<div class="container">
			<div class="row">
			<?php
				if(isset($_POST['enviar'])) {
					include (TEMPLATEPATH . '/funciones/registrardenuncia.php');
					if ($status=='aprobado') { ?>
						<div class="modal fade" id="myModal"  tabindex="-1" role="dialog">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        <h4 class="modal-title letraroja text-center">ATENCIÓN</h4>
								      </div>
								      <div class="modal-body">
								        <h1 class="letraverde text-center">Se ha registrado la denuncia.</h1>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								      </div>
								    </div><!-- /.modal-content -->
								  </div><!-- /.modal-dialog -->
								</div><!-- /.modal -->
								<script>
									jQuery(document).ready(function() {
										$('#myModal').modal('show'); 
									});
								</script>
								<?php
					} elseif ($status=='negada') { ?>
						<div class="modal fade" id="myModal"  tabindex="-1" role="dialog">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        <h4 class="modal-title letraroja text-center">ATENCIÓN</h4>
								      </div>
								      <div class="modal-body">
								        <h1 class="letraverde text-center">Ya esta persona ha sido denunciada.</h1>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								      </div>
								    </div><!-- /.modal-content -->
								  </div><!-- /.modal-dialog -->
								</div><!-- /.modal -->
								<script>
									jQuery(document).ready(function() {
										$('#myModal').modal('show'); 
									});
								</script>
								<?php
					} 
				}
			?>
			</div>	
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center">Registrar Denuncia</h2>
					<blockquote class="borderrojo panel-footer">
						<p>Esta sección es netamente informativa de uso interno para facilitar a personas prestadas a estafas por incumplimiento de pagos.</p>
					</blockquote>
				</div>
			</div>
			<div class="row">
				<div class="margintop25 marginbot25">
					<form name="importa" method="post" action="http://vivecolecciones.com.ve/denuncias/" >
                        <div class="margintop25">
							<div class="col-md-12">
								<label>Fecha</label>
								<input value="<?php echo date("d/m/Y"); ?>" id="fecha" name="fecha" type="text" class="form-control" readonly>
							</div>
							<div class="col-md-12">
								<label>Nombre y apellido</label>
								<input placeholder="Nombre y apellido"  id="nombre" name="nombre" type="text" class="form-control" required>
							</div>
							<div class="col-md-12">
								<label>Cédula</label>
								<input placeholder="Cédula"  id="cedula" name="cedula" type="number" class="form-control">
							</div>
							<div class="col-md-12">
								<label>Localidad</label>
								<input placeholder="localidad"  id="localidad" name="localidad" type="text" class="form-control" required>
							</div>
							<div class="col-md-12">
								<label>Comentario</label>
                				<textarea id="message" name="message" class="form-control" rows="10" style="resize: vertical;" placeholder="Comentario"  required></textarea>
							</div>
								<input value="<?php echo $usuariologged; ?>" id="cliente" name="cliente" type="text" hidden required>
							<div class="col-md-12 margintop25 marginbot25 text-center">
								<input class="btn btn-primary marginauto" type='submit' name='enviar' id="enviar" value="Denunciar"/>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<?php } elseif( current_user_can('administrator')) { ?>
			<div class="container">
      			<h1 class="marginbot10 text-left">Denuncias</h1>
	            <div class="text-left">
					<form class="controls" id="Filters">
						<div class="clearfix"></div>
						<div class="row margintop50">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Ordernar por: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<button type="button" class="sort btn btn-default" data-sort="default">Default</button>
							  	<button type="button" class="sort btn btn-default" data-sort="myorder:asc">Anteriores</button>
							  	<button type="button" class="sort btn btn-default active" data-sort="myorder:desc">Recientes</button>
							</div>
			            </div>
					</form>
	            </div>
                <div class="pager-list margintop10 marginbot10"></div>
	      		<div class="inventario margintop25">
					<div class="col-md-2 col-sm-2 col-xs-6"> 
						<h4>Fecha</h4>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-6"> 
						<h4>Gerente</h4>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-6"> 
						<h4>Localidad</h4>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12"> 
						<h4>Denunciado</h4>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<h4>Cédula</h4>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<h4>Observación</h4>
					</div>
				</div>
				<div class="clearfix"></div>
				<div id="Container"><?php include (TEMPLATEPATH . '/funciones/denuncias.php'); ?></div>
                <div class="pager-list marginbot10"></div>
            </div>
            <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
	var dropdownFilter = {
	  $filters: null,
	  $reset: null,
	  groups: [],
	  outputArray: [],
	  outputString: '',
	  
	  init: function(){
	    var self = this;
	    self.$filters = $('#Filters');
	    self.$reset = $('#Reset');
	    self.$container = $('#Container');
	    self.$filters.find('fieldset').each(function(){
	      self.groups.push({
	        $dropdown: $(this).find('select'),
	        active: ''
	      });
	    });
	    
	    self.bindHandlers();
	  },
	  bindHandlers: function(){
	    var self = this;
	    self.$filters.on('change', 'select', function(e){
	      e.preventDefault();
	      
	      self.parseFilters();
	    });
	    self.$reset.on('click', function(e){
	      e.preventDefault();
	      
	      self.$filters.find('select').val('');
	      
	      self.parseFilters();
	    });
	  },
	  parseFilters: function(){
	    var self = this;
	    for(var i = 0, group; group = self.groups[i]; i++){
	      group.active = group.$dropdown.val();
	    }
	    
	    self.concatenate();
	  },
	  concatenate: function(){
	    var self = this;
	    
	    self.outputString = '';
	    
	    for(var i = 0, group; group = self.groups[i]; i++){
	      self.outputString += group.active;
	    }
	    !self.outputString.length && (self.outputString = 'all'); 
		  if(self.$container.mixItUp('isLoaded')){
	    	self.$container.mixItUp('filter', self.outputString);
		  }
	  }
	};
	$(function(){ dropdownFilter.init();
	    jQuery('#Container').mixItUp({
			animation: { duration: 200 },
			pagination: { limit: 50, loop: false, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a><h4>Siguiente</h4></a>' },
			controls: { toggleFilterButtons: true, toggleLogic: 'and' },
			load: { sort: 'myorder:desc' }
	  });    
	});
</script>
	<?php }
get_footer(); ?>