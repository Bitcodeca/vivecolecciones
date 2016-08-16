<?php get_header();
if( current_user_can('subscriber')) { ?>
	<?php include (TEMPLATEPATH . '/funciones/usuariologged.php');?>
		  <!--/////////////////////////////////////////////////////////////////////////////// -->
		  <!--/////////////////////////////      GERENTE    //////////////////////////////// -->
		  <!--///////////////////////////////////////////////////////////////////////////// -->

		<div class="container">
			<div class="row">
			<?php
				if(isset($_POST['enviar'])) {
					include (TEMPLATEPATH . '/funciones/registrardevolucion.php'); ?>
					<div class="modal fade" id="myModal"  tabindex="-1" role="dialog">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title letraroja text-center">ATENCIÓN</h4>
					      </div>
					      <div class="modal-body">
					        <h1 class="letraverde">¡Gracias! Se ha registrado exitosamente la devolución.</h1>
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
			?>
				<div class="col-md-12 margintop25">
					<h2 class="text-center">Historial de Devoluciones</h2>
					<div id="Container"><?php include (TEMPLATEPATH . '/funciones/verdevoluciones.php');?></div>
                    <div class="pager-list marginbot10 text-center"></div>
					<div class="row marginbot10">
						<div class="text-center">  
							<span class="finalinventario">Ordernar por: </span>
							<button type="button" class="sort btn btn-default" data-sort="default">Default</button>
						  	<button type="button" class="sort btn btn-default" data-sort="myorder:asc">Anteriores</button>
						  	<button type="button" class="sort btn btn-default active" data-sort="myorder:desc">Recientes</button>
						</div>
		            </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 margintop25 marginbot25">
					<h2 class="text-center">Registrar Devolución</h2>
					<form name="importa" method="post" action="http://vivecolecciones.com.ve/devoluciones/" >
                        <div class="col-md-12 margintop25">
							<div class="col-md-3">
								<input value="<?php echo date("d/m/Y"); ?>" id="fecha" name="fecha" type="text" class="form-control" readonly>
							</div>
							<div class="col-md-4">
							    <select class="form-control" name="coleccion" id="coleccion">
							    	<option value="">Seleccionar colección</option>
					                <?php $args=array('post_status' => 'publish', 'post_type'=> 'post',  'order' => 'ASC', 'posts_per_page' => -1, 'tax_query' => array( array(  'taxonomy' => 'Gerente', 'field' => 'slug', 'terms' => $usuariologged ) ) ); $my_query = new WP_Query($args);
									    if( $my_query->have_posts() ) { 
											while ($my_query->have_posts()) : $my_query->the_post(); $id = get_the_ID();
										        $categories = get_the_category(); 
										        $producto=$categories[0]->name;
										        echo '<option value="'. $producto.'"> '.$producto.' </option>';
									        endwhile;
									    } ?>
							    </select>
							</div>
							<div class="col-md-4">
								<input placeholder="Cantidad"  id="cantidad" name="cantidad" type="text" class="form-control" required>
							</div>
							<input value="<?php echo $usuariologged; ?>" id="cliente" name="cliente" type="text" hidden required>
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
				pagination: { limit: 50, loop: false, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' }
			});
		});
	</script>


		  <!--/////////////////////////////////////////////////////////////////////////////// -->
		  <!--///////////////////////////      ADMINISTRADOR    //////////////////////////// -->
		  <!--///////////////////////////////////////////////////////////////////////////// -->
<?php }
elseif (current_user_can('administrator')) { ?>
	<div class="container text-center margintop25 marginbot25">
		<?php include (TEMPLATEPATH . '/funciones/usuariologged.php');
			if(isset($_POST['btn'])) {
				$btn=$_POST['btn'];
				$id=$_POST['id'];
				if ($btn=='Eliminar') {
					$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
					$sql = "DELETE FROM devoluciones WHERE id=$id";
					mysqli_query($con, $sql);
					mysqli_close($con);
				}
			}
			$args=array('post_status' => 'publish', 'order' => 'ASC', 'post_type'=> 'post', 'posts_per_page' => 1); 
			$my_query = new WP_Query($args);
        	if( $my_query->have_posts() ) {
        		$todoslosusuarios = get_users();
	        	?>
      			<h1 class="marginbot10 text-left">Devoluciones</h1>
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
										$result = mysqli_query($con, "SELECT DISTINCT cliente FROM devoluciones ORDER BY cliente");
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
				    <div class="col-md-2 col-sm-2 col-xs-6"><h4>Fecha</h4></div>
				    <div class="col-md-3 col-sm-3 col-xs-6"><h4>Cliente</h4></div>
				    <div class="col-md-3 col-sm-3 col-xs-6"><h4>Colección</h4></div>
				    <div class="col-md-2 col-sm-2 col-xs-3"><h4>Cantidad</h4></div>
				    <div class="col-md-2 col-sm-2 col-xs-3"><h4>Borrar</h4></div>
				</div>
				<div class="clearfix"></div>
				<div id="Container">
					<?php
						$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
						$result = mysqli_query($con, "SELECT * FROM devoluciones");
						while ($row = mysqli_fetch_array($result)) {
							$id=$row['id'];
							$cliente=$row['cliente'];
							$fecha=$row['fecha'];
							$cantidad=$row['cantidad'];
							$coleccion=$row['coleccion'];
							$fechaunixcamb = DateTime::createFromFormat("d/m/Y", $fecha);
							$fechaunixcamb=date_format($fechaunixcamb,"Y-m-d");
							$fechaunixdep=strtotime($fechaunixcamb);
							?>
							<div class="fondogrispar paddingtopbot10 mix <?php echo $cliente; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
						        <div class="row text-center">
									<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
										<?php echo $fecha; ?>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 paddingtop10"> 
										<?php echo $cliente; ?>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6 paddingtop10"> 
										<?php echo $coleccion; ?>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-3 paddingtop10">
										<?php echo $cantidad; ?>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-3">
										<form name="importa<?php echo $iddeposito; ?>" method="post" >
											<input class="btn btn-default btnedc" type="submit" name="btn" id="btn"  value="Eliminar" />
											<input hidden type="text" name="id" id="id" value="<?php echo $id; ?>">
										</form>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<?php }
					?>
				</div>
                <div class="pager-list marginbot10"></div>
			<?php } else { ?>
				<h3 class="marginbot25">No existen devoluciones</h3>
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