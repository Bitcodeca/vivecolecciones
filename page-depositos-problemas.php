<?php get_header();

	if( current_user_can('subscriber')) {
		include (TEMPLATEPATH . '/funciones/usuariologged.php'); ?>
		<div class="container">
			<div class="row">
			<?php
				if(isset($_POST['enviar'])) {
					include (TEMPLATEPATH . '/funciones/registrarproblema.php');
					if ($status=='aprobado') {
						 echo '<h1 class="letraverde">Registre este depósito normalmente, no es problemático.</h1>';
					} elseif ($status=='pendiente') {
						  echo '<h1 class="letraamarilla">Se ha introducido el depósito problemático. En la brevedad posible se analizará.</h1>';
					} elseif ($status=='negada') {
						echo '<h1 class="letraroja">Ya ha introducido el mismo registro. Intente con uno diferente.</h1>';
					}
				}
			?>
				<div class="col-md-12 margintop25">
					<h2 class="text-center">Depósitos Problemas en Análisis</h2>
					<div id="Container">
						<?php
							$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
							$result = mysqli_query($con, "SELECT * FROM registro WHERE cliente='".$usuariologged."' AND status='pendiente'");
						 	echo '<div class="row margintop25 fondoazul text-center">';
							echo			    '<div class="col-md-3 col-sm-3 col-xs-6"><h4>Fecha</h4></div>';
							echo			    '<div class="col-md-3 col-sm-3 col-xs-6"><h4>Banco</h4></div>'	;	
							echo			    '<div class="col-md-3 col-sm-3 col-xs-6"><h4># Referencia</h4></div>';
							echo			    '<div class="col-md-3 col-sm-3 col-xs-6"><h4>Monto</h4></div>';
							echo '</div>';
							while ($row = mysqli_fetch_array($result)) {
								$banco=$row['banco'];
								$fecha=$row['fecha'];
								$referencia=$row['referencia'];
								$monto=$row['monto'];
								$status=$row['status'];
								$cliente=$row['cliente'];
								$fechaunixcamb = DateTime::createFromFormat("d/m/Y", $fecha);
								$fechaunixcamb=date_format($fechaunixcamb,"Y-m-d");
								$fechaunixdep=strtotime($fechaunixcamb);
						        echo '<div class="row mix bordertopnegro borderbotnegro paddingbot10 paddingtop10 text-center '.$banco.'"  data-myorder="'.$fechaunixdep.'">';
								echo     '<div class="col-md-3 col-sm-3 col-xs-6">'.$fecha.'</div>';
								echo     '<div class="col-md-3 col-sm-3 col-xs-6">'.$banco.'</div>';
								echo     '<div class="col-md-3 col-sm-3 col-xs-6">'.$referencia.'</div>';
								echo     '<div class="col-md-3 col-sm-3 col-xs-6">Bsf '.$monto.'</div>';
								echo '</div>'; 
							}
						?>
					</div>
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
					<h2 class="text-center">Registrar Depósito Problemático</h2>
					<h1 class="letranegra text-center">Introducir montos sin decimales</h1>
					<form name="importa" method="post" action="http://vivecolecciones.com.ve/depositos-problemas/" >
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
					pagination: { limit: 50, loop: false, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' }
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
	if( current_user_can('administrator')) { ?>
<div class="container text-center margintop25 marginbot25">
		<?php include (TEMPLATEPATH . '/funciones/usuariologged.php');
			$args=array('post_status' => 'publish', 'order' => 'ASC', 'post_type'=> 'post', 'posts_per_page' => 1); $my_query = new WP_Query($args);
        	if( $my_query->have_posts() ) {
        		$todoslosusuarios = get_users();
				if(isset($_POST['btn'])) {
						$id=$_POST['id'];
						$btn=$_POST['btn'];

						$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");

						if ($btn=='Aprobar') {

							$sql = "UPDATE registro SET status='aprobado' WHERE id=$id";
							mysqli_query($con, $sql);
							mysqli_close($con);

						} elseif ($btn=='Pendiente') {

							$sql = "UPDATE registro SET status='pendiente' WHERE id=$id";
							mysqli_query($con, $sql);
							mysqli_close($con);

						} elseif ($btn=='Negar') {

							$sql = "UPDATE registro SET status='negada' WHERE id=$id";
							mysqli_query($con, $sql);
							mysqli_close($con);

						} elseif ($btn=='Eliminar') {

							$sql = "DELETE FROM registro WHERE id=$id";
							mysqli_query($con, $sql);
							mysqli_close($con);

						} elseif ($btn=='Editar') {

							$fechaeditada=$_POST['fecha'.$id];
							$referenciaeditada=$_POST['referencia'.$id];
							$sql = "UPDATE registro SET fecha='$fechaeditada', referencia='$referenciaeditada' WHERE id=$id";
							mysqli_query($con, $sql);
							mysqli_close($con);

						}
				}
	        	?>
      			<h1 class="marginbot10 text-left">Pagos Recibidos</h1>
		            <div class="text-left">
						<div class="clearfix"></div>
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Usuarios: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
				                <?php 
				                $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
								$result = mysqli_query($con, "SELECT DISTINCT cliente FROM registro WHERE status='pendiente'");
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
					<div id="Container"><?php include (TEMPLATEPATH . '/funciones/estadodecuentaproblema.php'); ?></div>
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