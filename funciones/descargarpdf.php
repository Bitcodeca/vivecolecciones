<?php get_header();
	include (TEMPLATEPATH . '/funciones/constantes.php'); ?>
	<style type="text/css">
		@media print and (color) {	
			* { -webkit-print-color-adjust: exact; print-color-adjust: exact !important; }
			body {-webkit-print-color-adjust: exact !important; font-size: 8px; }
			.fondoazul:before { background-color: #13345d !important; color: white; -webkit-print-color-adjust: exact !important; }
			.fondorojo:before { background-color: #5d1334 !important; color: white; -webkit-print-color-adjust: exact !important; }
			.page-break	{ display: block; page-break-before: always; }
		}
	</style>
	<?php $cliente=$_POST['cliente']; 
	$user = get_user_by( 'login', $cliente); ?>
		<div class="container">
			<div class="row">
				<div class="col-xs-6 text-left">
					<div class="row">
						<img src="<?php echo get_bloginfo('template_directory');?>/img/logonav.jpg" class="img-responsive">
					</div>
					<div class="row">
						<p>Dirección: Barquisimeto</p>
						<p>Ciudad: Edo. Lara </p>
						<p>Teléfono: 0251-6117105</p>
						<p>coimtex@hotmail.com</p>
					</div>
				</div>
				<div class="col-xs-6 text-right">
					<div class="row">
						<h3>COIMTEX</h3>
						<h4>Rif: J-40757994-0</h4>
					</div>
					<div class="row">
						<h3>Factura</h3>
						<h4>No Fiscal</h4>
						<h3>Fecha: <?php echo date("Y-m-d"); ?></h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 bordernegro">
					<h4>Factura para:</h4>
				</div>
				<div class="col-xs-12">
					<p>Código del Gerente: <?php echo $cliente; ?></p>
				</div>
				<div class="col-xs-12">
					<p>Nombre del Gerente: <?php echo $user->first_name . ' ' . $user->last_name; ?></p>
				</div>
				<div class="col-xs-12">
					<p>Dirección:</p>
				</div>
				<div class="col-xs-12">
					<p>Ciudad:</p>
				</div>
				<div class="col-xs-12">
					<p>Teléfono:</p>
				</div>
			</div>
	      	<div class="col-md-12">
		      	<?php
	  			include (TEMPLATEPATH . '/funciones/usuariologged.php');
	   			$args=array('post_status' => 'publish', 'post_type'=> 'post',  'order' => 'DESC', 'tax_query' => array( array(  'taxonomy' => 'Gerente', 'field' => 'slug', 'terms' => $cliente ) ) ); $my_query = new WP_Query($args);
		        if( $my_query->have_posts() ) { ?>
			        <?php include (TEMPLATEPATH . '/funciones/graficacliente.php'); ?>
				  	<div class="clearfix"></div>
			      	<div class="marginbot10 margintop25">
				    	<div class="row bordernegro">
						    <div class="col-md-3 col-sm-3 col-xs-3"><h4>CANTDAD</h4></div>
						    <div class="col-md-3 col-sm-3 col-xs-3"><h4>COLECCIÓN</h4></div>
						    <div class="col-md-3 col-sm-3 col-xs-3"><h4>PRECIO C/U</h4></div>
						    <div class="col-md-3 col-sm-3 col-xs-3"><h4>PRECIO TOTAL</h4></div>
				  		</div>
					    <?php include (TEMPLATEPATH . '/funciones/loopinventario.php'); ?>
			    		<div class="row margintop10 bordernegro">
			    			<div class="col-md-3 col-sm-3 col-xs-3"><h4 class="margin0"><?php echo $totalcantidad; ?></h4></div>
			    			<div class="col-md-3 col-sm-3 col-xs-3"></div>
			    			<div class="col-md-3 col-sm-3 col-xs-3"><h4 class="margin0">Total Facturado: </h4></div>
			    			<div class="col-md-3 col-sm-3 col-xs-3"><h4 class="margin0">Bsf <?php echo number_format($totalcosto, 2, ',', '.'); ?></h4></div>
			    		</div>
					</div>
			        <?php include (TEMPLATEPATH . '/funciones/pagocuotas.php'); ?>
			        <div class="row margintop25 bordernegro">
			        	<div class="col-xs-6">
			        		<h4>CUOTA A PAGAR POR CADA QUINCENA</h4>
			        	</div>
			        	<div class="col-xs-6">
			        		<h4>Bsf <?php echo number_format($totaladepositarquincenal, 2, ',', '.'); ?></h4>
			        	</div>
			        </div>
				  	<div class="clearfix margintop50"></div>
		      		<div class="row bordernegro">
		      			<div class="col-xs-12"><h4>DESCRIPCIÓN DE PAGOS POR GANANCIAS</h4></div>
		      		</div>
		      		<div class="marginbot10">
			    		<div class="row margintop10">
			    			<div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Ganancia Vendedor:</h4></div>
			    			<div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Bsf <?php echo number_format($gananciavendedor, 2, ',', '.');; ?></h4></div>
			    			<div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Bsf <?php echo number_format($totalvendedor, 2, ',', '.'); ?></h4></div>
			    		</div>
				  		<div class="row margintop10">
			              	<div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Premios Básico</h4></div>
						    <div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Bsf <?php echo number_format($premiobasico, 2, ',', '.'); ?></h4></div>
						    <div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Bsf <?php echo number_format($subtotalpremiobasico, 2, ',', '.'); ?></h4></div>
					  	</div>
				  		<div class="row margintop10">
			              	<div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Distribución</h4></div>
						    <div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Bsf <?php echo number_format($distribucion, 2, ',', '.'); ?></h4></div>
						    <div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Bsf <?php echo number_format($subtotaldistribucion, 2, ',', '.'); ?></h4></div>
					  	</div>
				  		<div class="row margintop10">
			              	<div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Gerencia</h4></div>
						    <div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Bsf <?php echo number_format($gerencia, 2, ',', '.'); ?></h4></div>
						    <div class="col-md-4 col-sm-4 col-xs-4"><h4 class="margin0">Bsf <?php echo number_format($subtotalgerencia, 2, ',', '.'); ?></h4></div>
					  	</div>
					</div>
					<div class="row marginbot1 bordernegro margintop25 marginbot25">
				    	<div class="col-md-6 col-sm-6 col-xs-6"><h4>TOTAL A CANCELAR A LA COMPAÑÍA:</h4> </div>
						<div class="col-md-6 col-sm-6 col-xs-6"><h4>Bsf <?php echo number_format($totalacancelar, 2, ',', '.'); ?></h4></div>
				  	</div>
	        </div>
	    </div>
	    <script>
			jQuery(document).ready(function(){
			    window.print();
			});
	    </script>
	<?php } wp_reset_query(); 
 get_footer(); ?>