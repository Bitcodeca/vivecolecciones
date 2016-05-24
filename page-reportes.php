<?php get_header();
	if( current_user_can('subscriber')) { ?>
	<h1 class="letraroja">Acceso Negado</h1>
	<?php }
	elseif (current_user_can('administrator')) {
		$pagina='reportes';
		if(isset($_POST['btn'])) {
			include (TEMPLATEPATH . '/funciones/cambiodestatus.php');
		}
		if(isset($_POST['btncya'])) {
			include (TEMPLATEPATH . '/funciones/cambiosyaveriasstatus.php');
		} ?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

		<div class="container marginbot25">
			<div class="row hidden-print">
				<div class="col-md-12 text-center">
					<h2>Reporte Detallado</h2>
				</div>
			</div>
			<?php if(!isset($_POST['print'])) { ?>
			<div class="row">
				<div class="col-md-12 text-center">
					<form name="importa" method="post" action="http://vivecolecciones.com.ve/reportes/" >
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
			<?php } ?>
		</div>
		<?php if(isset($_POST['cliente'])) {
			$cliente=$_POST['cliente'];
			include (TEMPLATEPATH . '/funciones/constantes.php');
			if(isset($_POST['print'])) { $pagina='print'; include (TEMPLATEPATH . '/funciones/descargarpdf.php'); } else { ?>
			<div class="container"><h4 class="text-left">Viendo Usuario: <?php echo $cliente ?></h4></div>
			<div class="container">
				<form name="print" method="post" action="http://vivecolecciones.com.ve/reportes/" >
					<input hidden type="text" name="cliente" id="cliente" value="<?php echo $cliente; ?>">
					<input class="btn btn-primary" type="submit" name="print" id="print"  value="Imprimir" />
				</form>
		      	<div class="col-md-12">
			      	<?php
		  			include (TEMPLATEPATH . '/funciones/usuariologged.php');
		   			$args=array('post_status' => 'publish', 'post_type'=> 'post',  'order' => 'DESC', 'posts_per_page' => -1, 'tax_query' => array( array(  'taxonomy' => 'Gerente', 'field' => 'slug', 'terms' => $cliente ) ) ); $my_query = new WP_Query($args);
			        if( $my_query->have_posts() ) { ?>
			      		<h1 class="marginbot10 margintop25">Factura</h1>
				        <?php include (TEMPLATEPATH . '/funciones/graficacliente.php'); ?>
			      		<script type="text/javascript">
						    google.charts.load('current', {'packages':['corechart']});
						    google.charts.setOnLoadCallback(drawChart);
						    function drawChart() {
						        var data = google.visualization.arrayToDataTable([
						          ['Información', 'Valor'],
						          ['Saldo Restante', <?php echo $debe; ?>],
						          ['Saldo Aprobado', <?php echo $totaldepositado; ?>]
						        ]);
						        var options = { title: 'Saldo Porcentual' };
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
			      		<h2 class="marginbot10">Descripción de Colecciones</h2>
				      	<div class="marginbot25">
					    	<div class="row fondoazul bordernegro">
					    		<div class="col-md-2 col-sm-2 hidden-xs"></div>
							    <div class="col-md-2 col-sm-2 col-xs-6"><h4>Producto</h4></div>
							    <div class="col-md-2 col-sm-2 col-xs-6"><h4>Cantidad</h4></div>
							    <div class="col-md-2 col-sm-2 col-xs-6"><h4>Costo</h4></div>
							    <div class="col-md-2 col-sm-2 col-xs-6"><h4>Costo Total</h4></div>
					  		</div>
						    <?php include (TEMPLATEPATH . '/funciones/loopinventario.php'); ?>
				    		<div class="row margintop25 bordernegro">
				    			<div class="col-md-4 col-sm-4 col-xs-12"><h4>Sub-Total: </h4></div>
				    			<div class="col-md-4 col-sm-4 col-xs-12"><h4>Colecciones: <?php echo $totalcantidad; ?></h4></div>
				    			<div class="col-md-4 col-sm-4 col-xs-12"><h4>Bsf <?php echo number_format($totalcosto, 2, ',', '.'); ?></h4></div>
				    		</div>
				    		<div class="row margintop25 bordernegro">
				    			<div class="col-md-4 col-sm-4 col-xs-12"><h4>Ganancia Vendedor:</h4></div>
				    			<div class="col-md-2 col-sm-2 col-xs-6"><h4>Colecciones: <?php echo $totalcantidad; ?></h4></div>
				    			<div class="col-md-2 col-sm-2 col-xs-6"><h4>Bsf <?php echo number_format($gananciavendedor, 2, ',', '.');; ?></h4></div>
				    			<div class="col-md-2 col-sm-2 col-xs-12"><h4>Bsf <?php echo number_format($totalvendedor, 2, ',', '.'); ?></h4></div>
				    		</div>
				    		<div class="row margintop25 bordernegro">
				    			<div class="col-md-6 col-sm-6 col-xs-6 fondoazul"><h4>Total:</h4></div>
				    			<div class="col-md-6 col-sm-6 col-xs-6 fondorojo"><h4>Bsf <?php echo number_format($total, 2, ',', '.'); ?></h4></div>
				    		</div>
						</div>
			      		<h2 class="marginbot10 margintop25">Descripción de Pagos</h2>
			      		<div class="marginbot25">
					    	<div class="row fondoazul">
					    		<div class="col-md-3 col-sm-3 hidden-xs"></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><h4>Monto</h4></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><h4>Cantidad</h4></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><h4>Sub-Total</h4></div>
					  		</div>
					  		<div class="row margintop10">
				              	<div class="col-md-12">
				              		<b class="pull-left">Total Adeudado</b> 
				              		<b class="pull-right">Bsf <?php echo number_format($total, 2, ',', '.'); ?></b>
				              	</div>
						  	</div>
					  		<div class="row margintop10">
				              	<div class="col-md-3 col-sm-3 col-xs-3"><b>Premios Básico</b></div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo number_format($premiobasico, 2, ',', '.'); ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><?php echo $totalcantidad; ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo number_format($subtotalpremiobasico, 2, ',', '.'); ?></div>
						  	</div>
					  		<div class="row margintop10">
				              	<div class="col-md-3 col-sm-3 col-xs-3"><b>Distribución</b></div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo number_format($distribucion, 2, ',', '.'); ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><?php echo $totalcantidad; ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo number_format($subtotaldistribucion, 2, ',', '.'); ?></div>
						  	</div>
					  		<div class="row margintop10">
				              	<div class="col-md-3 col-sm-3 col-xs-3"><b>Gerencia</b></div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo number_format($gerencia, 2, ',', '.'); ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><?php echo $totalcantidad; ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo number_format($subtotalgerencia, 2, ',', '.'); ?></div>
						  	</div>
						</div>
						<div class="row marginbot25">
					    	<div class="col-md-6 col-sm-6 col-xs-6 fondoazul"><h4>TOTAL A CANCELAR:</h4> </div>
							<div class="col-md-6 col-sm-6 col-xs-6"><h4>Bsf <?php echo number_format($totalacancelar, 2, ',', '.'); ?></h4></div>
					  	</div>
				        <?php include (TEMPLATEPATH . '/funciones/pagocuotas.php'); ?>
			      		<h2 class="marginbot10 margintop25">Premios Quincenales</h2>
						<div class="marginbot25">
					    	<div class="row fondoazul margintop10">
					    		<div class="col-md-3 col-sm-3 hidden-xs"></div>
					    		<div class="col-md-3 col-sm-3 hidden-xs"></div>
					    		<div class="col-md-3 col-sm-3 col-xs-6"><h4>Premios Ganados (Unidad)</h4></div> 
					    		<div class="col-md-3 col-sm-3 col-xs-6"><h4>Premios Ganados (Bsf)</h4></div>
					  		</div>
					    	<div class="row marginbot25">
							    <div class="col-md-3 col-sm-3 col-xs-3 fondoazul"><h4>Total a depositar quincenal</h4></div>
							    <div class="col-md-3 col-sm-3 col-xs-3 fondorojo"><h4>Bsf <?php echo number_format($totaladepositarquincenal, 2, ',', '.'); ?></h4></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"></div>
					  		</div>
					    	<div class="row marginbot25">
							    <div class="col-md-3 col-sm-3 col-xs-3">Depósito 1era quincena (<?php echo $c1; ?>)</div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo $montoq1; ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><?php echo number_format($premioporcentajeq1, 2, ',', '.'); ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf  <?php echo number_format($premioq1, 2, ',', '.'); ?></div>
					  		</div>
					    	<div class="row marginbot25">
							    <div class="col-md-3 col-sm-3 col-xs-3">Depósito 2da quincena (<?php echo $c2; ?>)</div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo $montoq2; ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><?php echo number_format($premioporcentajeq2, 2, ',', '.'); ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf  <?php echo number_format($premioq2, 2, ',', '.'); ?></div>
					  		</div>
					    	<div class="row marginbot25">
							    <div class="col-md-3 col-sm-3 col-xs-3">Depósito 3ra quincena (<?php echo $c3; ?>)</div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo $montoq3; ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><?php echo number_format($premioporcentajeq3, 2, ',', '.'); ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo number_format($premioq3, 2, ',', '.'); ?></div>
					  		</div>
					    	<div class="row marginbot25">
							    <div class="col-md-3 col-sm-3 col-xs-3">Cuarto cierre (<?php echo $c4; ?>)</div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo $montoq4; ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><?php echo number_format($premioporcentajeq4, 2, ',', '.'); ?></div>
							    <div class="col-md-3 col-sm-3 col-xs-3">Bsf <?php echo number_format($premioq4, 2, ',', '.'); ?></div>
					  		</div>
					    	<div class="row">
							    <div class="col-md-3 col-sm-3 col-xs-3"><h4>Total depositado</h4></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><h4>Bsf <?php echo number_format($totaldepositado, 2, ',', '.'); ?></h4></div>
							    <div class="col-md-3 col-sm-3 col-xs-3"><h4><?php echo number_format($premioporcentajetotal, 2, ',', '.'); ?></h4></div>
							    <div class="col-md-3 col-sm-3 col-xs-3 fondorojo"><h4>Bsf <?php echo number_format($premiototal, 2, ',', '.'); ?></h4></div>
					  		</div>
					    	<div class="row">
							    <div class="col-md-3 col-sm-3 col-xs-6 fondoazul"><h4>Total deuda</h4></div>
							    <div class="col-md-3 col-sm-3 col-xs-6"><h4>Bsf <?php echo number_format($totalacancelar, 2, ',', '.'); ?></h4></div>
							    <div class="col-md-3 col-sm-3 hidden-xs"></div>
							    <div class="col-md-3 col-sm-3 hidden-xs"></div>
					  		</div>
					    	<div class="row marginbot25">
							    <div class="col-md-3 col-sm-3 col-xs-12 fondoazul"><h4>Deuda pendiente</h4></div>
							   	<div class="col-md-3 col-sm-3 col-xs-12 fondorojo"><h4>Bsf <?php $deudapendiente=$totalacancelar-$totaldepositado; echo number_format($deudapendiente, 2, ',', '.'); ?></h4></div>
							   	<div class="col-md-3 col-sm-3 hidden-xs"></div>
							   	<div class="col-md-3 col-sm-3 hidden-xs"></div>
					  		</div>
					  	</div>
					  	<div class="clearfix"></div>

						<div class="container"><h1 class="text-left margintop25">Cambios y Averías</h1></div>
						<div class="container fondoazul bordertopnegro borderbotnegro text-center margintop25">
							<div class="row">
								<div class="col-md-1 col-sm-1 col-xs-12">
									<h4>Fecha</h4>
								</div>
								<div class="col-md-1 col-sm-1 col-xs-4">
									<h4>Colección</h4>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-4">
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
								<div class="col-md-1 col-sm-1 col-xs-12">
									<h4>Status</h4>
								</div>
							</div>
						</div>
						<div id="Container"><?php $usuariologged=$cliente; include (TEMPLATEPATH . '/funciones/versolicitudes.php');?></div>
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
								<span class="finalinventario">Filtrar por Status: </span>
								<a class="filter btn btn-default btnfiltro" data-filter=".aprobado">Aprobado</a>
								<a class="filter btn btn-default btnfiltro" data-filter=".pendiente">Pendiente</a>
								<a class="filter btn btn-default btnfiltro" data-filter=".negado">Negado</a>
						    </div>
					    </div>
					  	<div class="clearfix"></div>
					  	<h1 class="margintop50 marginbot10 text-left">Pagos Recibidos</h1>
			      		<div class="inventario margintop25">
				    		<div class="col-md-2 col-sm-2 col-xs-4"><h4>Fecha</h4></div>
						    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Cliente</h4></div>
						    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Banco</h4></div>
						    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Número de Referencia</h4></div>
						    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Monto</h4></div>
						    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Status</h4></div>
						</div>
						<div class="clearfix"></div>
		        		<div id="Container2"><?php include (TEMPLATEPATH . '/funciones/reportesestadodecuenta.php'); ?></div>
	                    <div class="pager-list2 marginbot10 text-center"></div>
						<div class="row marginbot10">
							<div class="text-center">  
								<span class="finalinventario">Ordernar por: </span>
								<button type="button" class="sort2 btn btn-default" data-sort="default">Default</button>
							  	<button type="button" class="sort2 btn btn-default" data-sort="myorder:asc">Anteriores</button>
							  	<button type="button" class="sort2 btn btn-default active" data-sort="myorder:desc">Recientes</button>
							</div>
			            </div>
			            <div class="text-left marginbot25">
								<span class="finalinventario">Filtrar por Status: </span>
								<a class="filter2 btn btn-default btnfiltro2" data-filter=".aprobado">Aprobado</a>
								<a class="filter2 btn btn-default btnfiltro2" data-filter=".pendiente">Pendiente</a>
								<a class="filter2 btn btn-default btnfiltro2" data-filter=".negada">Negado</a>
								<div class="clearfix"></div>
								<span class="finalinventario">Filtrar por Banco: </span>
								<a class="filter2 btn btn-default btnfiltro2" data-filter=".provincial">Provincial</a>
								<a class="filter2 btn btn-default btnfiltro2" data-filter=".banesco">Banesco</a>
								<a class="filter2 btn btn-default btnfiltro2" data-filter=".activo">Banco Activo</a>
								<a class="filter2 btn btn-default btnfiltro2" data-filter=".bicentenario">Banco Bicentenario</a>
								<a class="filter2 btn btn-default btnfiltro2" data-filter=".venezuela">Banco de Venezuela</a>
								<a class="filter2 btn btn-default btnfiltro2" data-filter=".banplus">Banco BanPlus</a>
								<a class="filter2 btn btn-default btnfiltro2" data-filter=".mercantil">Banco Mercantil</a>  
			            </div>

						<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
						<script>
							jQuery(function(){
								jQuery('#Container').mixItUp({
									animation: { duration: 200 },
									pagination: { limit: 5, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
									controls: { toggleFilterButtons: true, toggleLogic: 'and' }
								});
								jQuery('#Container2').mixItUp({
									animation: { duration: 200 },
									pagination: { limit: 5, loop: true, prevButtonHTML: '<a><h4>Anterior</h4></a>', nextButtonHTML: '<a ><h4>Siguiente</h4></a>' },
									controls: { toggleFilterButtons: true, toggleLogic: 'and' },
									selectors: { filter: '.filter2', sort: '.sort2', pagersWrapper: '.pager-list2' }
								});
							});
						</script>
		        		<?php } else { ?>
						<h3 class="marginbot25">No posee colecciones asignadas</h3>
		    		<?php } ?>
		        </div>
		        <div class="clearfix"></div>
		    </div>
			<div class="clearfix"></div>
	<?php } } wp_reset_query();
}
 get_footer(); ?>