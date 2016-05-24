<?php get_header();
	include (TEMPLATEPATH . '/funciones/usuariologged.php');
	if( current_user_can('administrator')) {
		$pagina='inicio';
		if(isset($_POST['btncya'])) {
			include (TEMPLATEPATH . '/funciones/cambiosyaveriasstatus.php');
		}?>
<!--
//////////////////////////////////////////////
//////////// ADMINISTRADOR //////////////////
////////////////////////////////////////////
-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

		<div class="container marginbot25">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1>Bienvenido <?php echo $nombrelogged.' '.$apellidologged; ?></h1>
				</div>
			</div>
			<div class="row">
				<?php 
				$todoslosusuarios = get_users( 'role=subscriber' );
				$x=0;
				$stotalcantidad=0;
				$stotalvendedor=0;
				$stotal=0;
				$ssubtotalpremiobasico=0;
				$ssubtotaldistribucion=0;
				$ssubtotalgerencia=0;
				$stotalacancelar=0;
				$stotaladepositarquincenal=0;
				foreach ( $todoslosusuarios as $user ) {
					$buscar=$user->user_login;
					$cliente=$buscar;
					include (TEMPLATEPATH . '/funciones/constantes.php');
				 	$args=array('post_status' => 'publish', 'post_type'=> 'post',  'order' => 'ASC', 'posts_per_page' => -1, 'tax_query' => array( array(  'taxonomy' => 'Gerente', 'field' => 'name', 'terms' => $buscar ) ) ); 
				 	$my_query = new WP_Query($args);
			        if( $my_query->have_posts() ) {
						$totalcosto=0;
						$totalcantidad=0;
						while ($my_query->have_posts()) : $my_query->the_post(); $id = get_the_ID();
							//El producto
					        $categories = get_the_category(); 
					        $producto=$categories[0]->name;
					        //Cantidad del producto
					        $cantidadarray = get_the_terms( $post->ID , 'cantidad' ); 
					        $cantidad=$cantidadarray[0]->name; 
					        //Costo del producto
					        $costoarray = get_the_terms( $post->ID , 'costo' ); 
					        $costo=$costoarray[0]->name;
					        //Total del producto
					        $preciototal=$cantidad*$costo; 
					        //Sumatoria de los totales de los productos
					        $totalcosto=$totalcosto+$preciototal;
					        //Sumatoria de las cantidades de productos 
					        $totalcantidad=$totalcantidad+$cantidad;
					        $fecha=get_the_date('d/m/Y');
					        $x++;
					    endwhile;

				        $stotalcantidad=$stotalcantidad+$totalcantidad;
						//Ganancia del vendedor actual
						$totalvendedor=$gananciavendedor*$totalcantidad;
						$stotalvendedor=$stotalvendedor+$totalvendedor;
						//Total
						$total=$totalcosto-$totalvendedor;
						$stotal=$stotal+$total;
						//Subtotal de Premio basico
						$subtotalpremiobasico=$totalcantidad*$premiobasico;
						$ssubtotalpremiobasico=$ssubtotalpremiobasico+$subtotalpremiobasico;
						//Subtotal de Distribucion
						$subtotaldistribucion=$totalcantidad*$distribucion;
						$ssubtotaldistribucion=$ssubtotaldistribucion+$subtotaldistribucion;
						//Subtotal de Gerencia
						$subtotalgerencia=$totalcantidad*$gerencia;
						$ssubtotalgerencia=$ssubtotalgerencia+$subtotalgerencia;
						//Total a cancelar
						$totalacancelar=$total-$subtotalgerencia-$subtotaldistribucion-$subtotalpremiobasico;
						$stotalacancelar=$stotalacancelar+$totalacancelar;
						//Total a depositar quincenal
						$totaladepositarquincenal=$total/4;
						$stotaladepositarquincenal=$stotaladepositarquincenal+$totaladepositarquincenal;				    				
		        	} 
		        }
				

				$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
				$totaldepositado=0;
				$totalaprobado=0;
				$totalpendiente=0;
				$result = mysqli_query($con, "SELECT * FROM registro WHERE status='aprobado'");
				while ($row = mysqli_fetch_array($result)) { $totalaprobado=$totalaprobado+$row['monto']; }
				$result = mysqli_query($con, "SELECT * FROM registro WHERE status='pendiente'");
				while ($row = mysqli_fetch_array($result)) { $totalpendiente=$totalpendiente+$row['monto']; }
				$totaldepositado=$totalaprobado+$totalpendiente; ?>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<h3 class="borderbotazul">Colecciones Entregadas:</h3> <h4><?php echo $stotalcantidad; ?></h4>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<h3 class="borderbotazul">Total Invertido:</h3> <h4>Bsf <?php echo number_format($stotalacancelar, 2, ',', '.'); ?></h4>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<h3 class="borderbotazul">Total Registrado:</h3> <h4>Bsf <?php echo number_format($totaldepositado, 2, ',', '.'); ?></h4>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6">
						<h3 class="borderbotazul">Total Aprobado:</h3> <h4>Bsf <?php echo number_format($totalaprobado, 2, ',', '.'); ?></h4>
					</div>
			</div>
			<div class="clearfix"></div>
			<?php $ptotalacancelar=$stotalacancelar-$stotalpendiente-$stotalaprobado; ?>
			<script type="text/javascript">
			    google.charts.load('current', {'packages':['corechart']});
			    google.charts.setOnLoadCallback(drawChart);
			    function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['Información', 'Valor'],
			          ['Saldo Restante', <?php echo $ptotalacancelar; ?>],
			          ['Saldo Pendiente', <?php echo $totalpendiente; ?>],
			          ['Saldo Aprobado', <?php echo $totalaprobado; ?>]
			        ]);
			        var options = { title: 'Control de Venta' };
			        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
				  	chart.draw(data, options);
			    }
		    </script>
		    <div class="row">
		    	<div class="col-md-12">
    				<div id="piechart" class="piechart1"></div>'
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="container"><h1 class="text-left">Cambios y Averías</h1></div>
			<div class="container fondoazul bordertopnegro borderbotnegro text-center margintop10">
				<div class="row">
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
			<div id="Container"><?php include (TEMPLATEPATH . '/funciones/versolicitudes.php'); ?></div>
		    <div class="pager-list marginbot10 text-center"></div>
			<div class="row marginbot10">
				<div class="text-center">  
					<span class="finalinventario">Ordernar por: </span>
					<button type="button" class="sort btn btn-default" data-sort="default">Default</button>
				  	<button type="button" class="sort btn btn-default" data-sort="myorder:asc">Anteriores</button>
				  	<button type="button" class="sort btn btn-default active" data-sort="myorder:desc">Recientes</button>
				</div>
		    </div>
			<div class="container">
			    <div class="text-left">
					<a class="filter btn btn-default" id="Reset">Mostrar Todos</a>
					<div class="clearfix"></div>
					<span class="finalinventario">Filtrar por Status: </span>
					<a class="filter btn btn-default btnfiltro" data-filter=".aprobado">Aprobado</a>
					<a class="filter btn btn-default btnfiltro" data-filter=".pendiente">Pendiente</a>
					<a class="filter btn btn-default btnfiltro" data-filter=".negado">Negado</a>
					<div class="clearfix"></div>
					<span class="finalinventario">Filtrar por Usuarios: </span>
			        <?php $todoslosusuarios = get_users();
			         foreach ( $todoslosusuarios as $user ) {
						echo '<a class="filter btn btn-default btnfiltro" data-filter=".'.$user->user_login.'"> '.$user->user_login.' </a>'; 
					} ?>
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
<!--
/////////////////////////////////////////
//////////// USUARIOS //////////////////
///////////////////////////////////////
-->
	<?php } elseif( current_user_can('subscriber')) { ?>
		<div class="container marginbot25">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1>Bienvenido <?php echo $nombrelogged.' '.$apellidologged; ?></h1>
				</div>
				<div class="col-md-12 text-center">
				<?php 
				$cliente=$usuariologged;
				include (TEMPLATEPATH . '/funciones/constantes.php');
				$args=array('post_status' => 'publish', 'post_type'=> 'post', 'order' => 'DESC', 'posts_per_page' => -1, 'tax_query' => array( array(  'taxonomy' => 'Gerente', 'field' => 'slug', 'terms' => $usuariologged ) ) ); $my_query = new WP_Query($args);
		        if( $my_query->have_posts() ) {
		        	include (TEMPLATEPATH . '/funciones/inventario.php');
		        	include (TEMPLATEPATH . '/funciones/pagocuotas.php');  ?>
					<div class="col-md-12 margintop25">
						<h2 class="text-left">Información General</h2>
					</div>
					<div class="row">
						<div class="col-md-12 margintop25">
							<div class="col-md-4 col-sm-4 col-xs-12">
								<h3 class="borderbotazul">Total Colecciones:</h3> <h4><?php echo $totalcantidad; ?></h4>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<h3 class="borderbotazul">Total a Pagar:</h3> <h4>Bsf <?php echo number_format($totalacancelar, 2, ',', '.'); ?></h4>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<h3 class="borderbotazul">Total Pagado:</h3> <h4>Bsf <?php echo number_format($totaldepositado, 2, ',', '.'); ?></h4>
							</div>
						</div>
					</div>
					<div class="col-md-12 margintop25">
						<h2 class="text-left">Fecha Límite de Pago de Cuotas</h2>
					</div>
					<div class="row">
						<div class="col-md-12 margintop25">
							<div class="col-md-3 col-sm-3 col-xs-6">
								<h3 class="borderbotazul">Cuota 1:</h3> <h4><?php echo $c1; ?></h4>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-6">
								<h3 class="borderbotazul">Cuota 2:</h3> <h4><?php echo $c2; ?></h4>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-6">
								<h3 class="borderbotazul">Cuota 3:</h3> <h4><?php echo $c3; ?></h4>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-6">
								<h3 class="borderbotazul">Cuota 4:</h3> <h4><?php echo $c4; ?></h4>
							</div>
						</div>
					</div>
				<?php } else { ?>
					<h3 class="marginbot25">No posees colecciones asignadas</h3>
	    		<?php } ?>
				</div>
			</div>
		</div>
	<?php }
get_footer(); ?>