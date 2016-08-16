<?php get_header();
if( current_user_can('subscriber')) { ?>
	<h1 class="letraroja">Acceso Negado</h1>
	<div class="clearfix"></div>
<?php }
elseif (current_user_can('administrator')) { ?>
	<div class="container text-center margintop25 marginbot25">
		<?php include (TEMPLATEPATH . '/funciones/usuariologged.php');
			$args=array('post_status' => 'publish', 'order' => 'ASC', 'post_type'=> 'post', 'posts_per_page' => 1); 
			$my_query = new WP_Query($args);
        	if( $my_query->have_posts() ) {
        		$todoslosusuarios = get_users();
	        	?>
      			<h1 class="marginbot10 text-left">Pagos Recibidos</h1>
	            <div class="text-left">
					<form class="controls" id="Filters">
						<div class="row margintop50">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Usuarios: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<fieldset>
								    <select class="form-control" id="Filters" name="Filters">
									    <option value="">Todos</option>
						                <?php $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
										$result = mysqli_query($con, "SELECT DISTINCT cliente FROM historial ORDER BY cliente");
										while ($row = mysqli_fetch_array($result)) {
											echo '<option value=".'.$row['cliente'].'"> '.$row['cliente'].' </option>';
										} ?>
								    </select>
							    </fieldset>
		    				</div>
	    				</div>
						<div class="clearfix"></div>
						<div class="row margintop10">
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
				    <div class="col-md-2 col-sm-2 col-xs-6"><h4>Cliente</h4></div>
				    <div class="col-md-2 col-sm-2 col-xs-6"><h4>Fecha Inicio</h4></div>
				    <div class="col-md-2 col-sm-2 col-xs-6"><h4>Fecha Fin</h4></div>
				    <div class="col-md-3 col-sm-3 col-xs-6"><h4>Monto</h4></div>
				    <div class="col-md-3 col-sm-3 col-xs-12"><h4>Comentario</h4></div>
				</div>
				<div class="clearfix"></div>
				<div id="Container"><?php include (TEMPLATEPATH . '/funciones/historial.php'); ?></div>
                <div class="pager-list marginbot10"></div>
			<?php } else { ?>
				<h3 class="marginbot25">No existen colecciones asignadas</h3>
			<?php } ?>
	</div>
	<div class="clearfix"></div>

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