<?php get_header();
if( current_user_can('administrator')) { 
	$pagina='inventariogeneral';
	include (TEMPLATEPATH . '/funciones/constantes.php');
	if(isset($_POST['btncya'])) {
		include (TEMPLATEPATH . '/funciones/cambiosyaveriasstatus.php');
	} ?>
	<div class="container"><h1 class="text-left margintop25">Colecciones Actuales</h1></div>
	<div class="container">
	    <div class="row fondoazul text-center margintop25 marginbot25">
			<div class="col-md-2 col-sm-2 col-xs-4"><h4>Cliente</h4></div>
			<div class="col-md-2 col-sm-2 col-xs-4"><h4>Producto</h4></div>
			<div class="col-md-2 col-sm-2 col-xs-4"><h4>Cantidad</h4></div>
			<div class="col-md-3 col-sm-3 col-xs-6"><h4>Precio</h4></div>
			<div class="col-md-3 col-sm-3 col-xs-6"><h4>Precio Total</h4></div>
		</div>
		<?php include (TEMPLATEPATH . '/funciones/loopinventariogeneral.php'); ?>
    </div>
	<div class="clearfix"></div>
	<div class="container"><h1 class="text-left margintop25">Cambios y Averías</h1></div>
	<div class="container fondoazul bordertopnegro borderbotnegro text-center margintop25">
		<div class="row text-center">
			<div class="col-md-1 col-sm-1 col-xs-4">
				<h4>Fecha</h4>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-4">
				<h4>Usuario</h4>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-4">
				<h4>Colección</h4>
			</div>
			<div class="col-md-1 col-sm-2 col-xs-4">
				<h4>Motivo</h4>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-4">
				<h4>Descripción</h4>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-4">
				<h4>Cantidad</h4>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-4">
				<h4>Tipo de Cambio</h4>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-4">
				<h4>Especificación</h4>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-4">
				<h4>Status</h4>
			</div>
		</div>
	</div>
	<div id="Container"><?php include (TEMPLATEPATH . '/funciones/versolicitudes.php');?></div>
    <div class="pager-list marginbot10 text-center"></div>
	<div class="row marginbot10">
		<div class="text-center">  
			<span class="finalinventario">Ordernar por: </span>
			<button type="button" class="sort btn btn-default" data-sort="default">Default</button>
		  	<button type="button" class="sort btn btn-default" data-sort="myorder:asc">Anteriores</button>
		  	<button type="button" class="sort btn btn-default active" data-sort="myorder:desc">Recientes</button>
		</div>
    </div>
	<div class="container marginbot25">
	    <div class="text-left">  
			<a class="filter btn btn-default" id="Reset">Mostrar Todos</a>
			<div class="clearfix"></div>
			<span class="finalinventario">Filtrar por Status: </span>
			<a class="filter btn btn-default btnfiltro" data-filter=".aprobado">Aprobado</a>
			<a class="filter btn btn-default btnfiltro" data-filter=".pendiente">Pendiente</a>
			<a class="filter btn btn-default btnfiltro" data-filter=".negado">Negado</a>
			<div class="clearfix"></div>
			<span class="finalinventario">Filtrar por Usuarios: </span>
	        <?php foreach ( $todoslosusuarios as $user ) {
				echo '<a class="filter btn btn-default btnfiltro" data-filter=".'.$user->user_login.'"> '.$user->user_login.' </a>'; 
			} ?>
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
				pagination: { limit: 5, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
				controls: { toggleFilterButtons: true, toggleLogic: 'and' }
			});
		});
		</script>
		<script>
		jQuery(document).ready(function() {
			jQuery("#Reset").click(function () {
			    jQuery(".btnfiltro").removeClass("active");
			    jQuery("#Reset").removeClass("active");
			});
		});
		</script>
<?php } elseif (current_user_can('subscriber')) { ?>
	<div class="container">
		<h1 class="letraroja">Acceso Negado</h1>
	</div>
<?php }
get_footer(); ?>