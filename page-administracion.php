<?php get_header();
if( current_user_can('subscriber')) { ?>
	<h1 class="letraroja">Acceso Negado</h1>
	<div class="clearfix"></div>
<?php }
elseif (current_user_can('administrator')) { 
if(isset($_POST['cerrarfactura'])) {
	include (TEMPLATEPATH . '/funciones/cerrarfactura.php');
}
	?>




	<div class="container text-center margintop25 marginbot25">


<!--*//////////////// TE PIDE SELECCIONAR EL USUARIO QUE QUISIERAS MODIFICAR ///////////////*/-->
		<div class="row">
				<div class="col-md-12 text-center">
					<form name="importa" method="post" action="http://vivecolecciones.com.ve/administracion/" >
				        <div class="col-md-12 text-center">
					        <select id="cliente" name="cliente" style="width: auto; padding: 8px;" required>
					        	<option value="" hidden>Seleccionar Usuario</option>
					        	<?php $todoslosusuarios = get_users();
									foreach ( $todoslosusuarios as $user ) {
										 $buscar=$user->user_login; ?>
										 <option value="<?php echo $buscar; ?>"><?php echo $buscar; ?></option>
								<?php } ?>
							</select>
							<input class="btn btn-default" type="submit" name="btn" id="btn"  value="Ver" />
						</div>
					</form>
				</div>
			</div>



<!--*//////////////// CHEQUEA SI HAY MERCANCIA EN PROCESO ///////////////*/-->	
		<?php
		 if(isset($_POST['cliente'])) {
		 	include (TEMPLATEPATH . '/funciones/usuariologged.php');
    		$buscar=$_POST['cliente'];
        	?>

<!--*//////////////// MUESTRA TODOS LOS PAGOS EN LA BASE DE DATOS ///////////////*/-->
			<div class="container"><h1 class="text-left"><small>Viendo Usuario:</small> <b><?php echo $buscar; ?></b></h1></div>
  			<h3 class="marginbot10 text-left">Pagos Recibidos</h3>
	            
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


<!-- //////////////////// MUESTRA AQUI TODA LA BASE DE DATOS //////////////////////// -->
				<div id="Container">
					<?php include (TEMPLATEPATH . '/funciones/estadodecuentaindividual.php'); ?>
				</div>
	            <div class="pager-list marginbot10"></div>


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



				<div class="row margintop75">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModal">
					  		CERRAR FACTURA
						</button>
					</div>
				</div>

<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog" role="document">
						    <div class="modal-content">
							      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        <h2 class="modal-title" id="myModalLabel"><b>ATENCIÓN</b></h2>
							      </div>
							      <div class="modal-body">
							        	<h3>¿Desea cerrar la factura del usuario <b><?php echo $buscar; ?></b>? </h3>
							        	<br>
							        	<h4>Se unificará de esta manera los pagos realizados entre el </h4>
							        	<h4><b><?php echo $primerafecha; ?></b> y el <b><?php echo $ultimafecha; ?></b></h4>
							        	<h4>con un total de <b>Bsf <?php echo number_format($montototal, 2, ',', '.'); ?></b></h4>
							        	<br>
							        	<h5><b>Una vez realizado, no habrá vuelta atrás</b></h5>
							      </div>
							      <div class="modal-footer">
								        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
								        <form name="cierre" method="post" action="http://vivecolecciones.com.ve/administracion/" >
								        	<input hidden type="text" name="fechainicierre" id="fechainicierre" value="<?php echo $primerafecha; ?>">
								        	<input hidden type="text" name="fechafincierre" id="fechafincierre" value="<?php echo $ultimafecha; ?>">
								        	<input hidden type="text" name="clientecierre" id="clientecierre" value="<?php echo $buscar; ?>">
								        	<input hidden type="text" name="montocierre" id="montocierre" value="<?php echo $montototal; ?>">
								        	<button type="submit" name="cerrarfactura" id="cerrarfactura" class="btn btn-primary">Aceptar</button>
										</form>
							      </div>
						    </div>
					  </div>
				</div>

			<?php } ?>

		<div class="clearfix"></div>
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
			pagination: { limit: 20, loop: false, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
			controls: { toggleFilterButtons: true, toggleLogic: 'and' }
		});
	});
</script>
<script>
	jQuery(document).ready(function() { jQuery("#Reset").click(function () { jQuery(".btnfiltro").removeClass("active"); jQuery("#Reset").removeClass("active"); }); });
</script>
<?php }


get_footer(); ?>