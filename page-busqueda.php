<?php get_header();
if( current_user_can('subscriber')) { ?>
	<h1 class="letraroja">Acceso Negado</h1>
	<div class="clearfix"></div>
<?php }
elseif (current_user_can('administrator')) { ?>
	<div class="container text-center margintop25 marginbot25">
		<?php include (TEMPLATEPATH . '/funciones/usuariologged.php');
			$args=array('post_status' => 'publish', 'order' => 'ASC', 'post_type'=> 'post', 'posts_per_page' => 1); $my_query = new WP_Query($args);
        	if( $my_query->have_posts() ) {
        		$todoslosusuarios = get_users();
				if(isset($_POST['btn'])) {
					include (TEMPLATEPATH . '/funciones/cambiodestatus.php');
				}
	        	?>
      			<h1 class="marginbot10 text-left">Pagos Recibidos</h1>
		            <div class="text-left">
						<div class="clearfix"></div>
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Status: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<a class="filter btn btn-default btnfiltro" data-filter=".aprobado">Aprobado</a>
								<a class="filter btn btn-default btnfiltro" data-filter=".pendiente">Pendiente</a>
								<a class="filter btn btn-default btnfiltro" data-filter=".negada">Negado</a>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Usuarios: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
				                <?php 
				                $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
								$result = mysqli_query($con, "SELECT DISTINCT cliente FROM registro");
								while ($row = mysqli_fetch_array($result)) {
									echo '<a class="filter btn btn-default btnfiltro" data-filter=".'.$row['cliente'].'"> '.$row['cliente'].' </a>';
								} ?>
		    				</div>
	    				</div>
						<div class="clearfix"></div>
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Banco: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<a class="filter btn btn-default btnfiltro" data-filter=".provincial">Provincial</a>
								<a class="filter btn btn-default btnfiltro" data-filter=".banesco">Banesco</a>
								<a class="filter btn btn-default btnfiltro" data-filter=".activo">Banco Activo</a>
								<a class="filter btn btn-default btnfiltro" data-filter=".bicentenario">Banco Bicentenario</a>
								<a class="filter btn btn-default btnfiltro" data-filter=".venezuela">Banco de Venezuela</a>
								<a class="filter btn btn-default btnfiltro" data-filter=".banplus">Banco BanPlus</a>
								<a class="filter btn btn-default btnfiltro" data-filter=".mercantil">Banco Mercantil</a>  
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
						<div class="row margintop10">
							<div class="col-md-12 col-sm-12 col-xs-12">
  								<a class="filter btn btn-default" id="Reset">Mostrar Todos</a>
							</div>
						</div>
		            </div>
                    <div class="pager-list margintop10 marginbot10"></div>
		      		<div class="inventario margintop25">
			    		<div class="col-md-2 col-sm-2 col-xs-4"><h4>Fecha</h4></div>
					    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Cliente</h4></div>
					    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Banco</h4></div>
					    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Número de Referencia</h4></div>
					    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Monto</h4></div>
					    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Status</h4></div>
					</div>
					<div class="clearfix"></div>
					<div id="Container"><?php include (TEMPLATEPATH . '/funciones/estadodecuenta.php'); ?></div>
                    <div class="pager-list marginbot10"></div>
				<?php } else { ?>
					<h3 class="marginbot25">No existen colecciones asignadas</h3>
				<?php } ?>
	</div>
	<div class="clearfix"></div>

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
			pagination: { limit: 50, loop: false, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
			controls: { toggleFilterButtons: true, toggleLogic: 'and' }
		});
	});
</script>
<script>
	jQuery(document).ready(function() { jQuery("#Reset").click(function () { jQuery(".btnfiltro").removeClass("active"); jQuery("#Reset").removeClass("active"); }); });
</script>
<?php }
get_footer(); ?>