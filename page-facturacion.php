<?php get_header();
	if( current_user_can('subscriber')) { ?>
		<div class="container">
	      	<div class="col-md-12">
	      	<?php
  			include (TEMPLATEPATH . '/funciones/usuariologged.php');
			include (TEMPLATEPATH . '/funciones/constantes.php'); 
   			$args=array('post_status' => 'publish', 'post_type'=> 'post', 'order' => 'DESC', 'posts_per_page' => -1, 'tax_query' => array( array(  'taxonomy' => 'Gerente', 'field' => 'slug', 'terms' => $usuariologged ) ) ); $my_query = new WP_Query($args);
	        if( $my_query->have_posts() ) { ?>		      	
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
    		<?php } else { ?>
				<h3 class="marginbot25">No posees colecciones asignadas</h3>
    		<?php } ?>
	        </div>
	        <div class="clearfix"></div>
	        <div class="col-md-12 marginbot25 text-center">
	        	<a href="<?php echo get_page_link( get_page_by_title('Registrar Pago')->ID ); ?>" class="btn btn-primary tituloinventario">Registrar Pago</a>
	        </div>
	    </div>
		<div class="clearfix"></div>
<?php } wp_reset_query();
get_footer(); ?>