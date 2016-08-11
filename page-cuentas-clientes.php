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
			if(isset($_POST['btn'])) { include (TEMPLATEPATH . '/funciones/cambiodestatus.php'); }
    	?>
			<style>
				/* For Posts List by CodexWorld */
				
				/* For Loading Overlay by CodexWorld */
				.post-wrapper{position: relative;}
				.loading-overlay{display: none;position: absolute;left: 0; top: 0; right: 0; bottom: 0;z-index: 2;background: rgba(255,255,255,0.7);}
				.overlay-content {
				    position: absolute;
				    transform: translateY(-50%);
				     -webkit-transform: translateY(-50%);
				     -ms-transform: translateY(-50%);
				    top: 50%;
				    left: 0;
				    right: 0;
				    text-align: center;
				    color: #555;
				}
				/* For Pagination Links by CodexWorld */
				div.pagination {
					padding:20px;
					margin:7px;
				}

				div.pagination a {
					margin: 2px;
					padding: 0.5em 0.64em 0.43em 0.64em;
					background-color: #ee4e4e;
					text-decoration: none; /* no underline */
					color: #fff;
				}
				div.pagination a:hover, div.pagination a:active {
					padding: 0.5em 0.64em 0.43em 0.64em;
					margin: 2px;
					background-color: #de1818;
					color: #fff;
				}
				div.pagination span.current {
				    padding: 0.5em 0.64em 0.43em 0.64em;
				    margin: 2px;
				    background-color: #f6efcc;
				    color: #6d643c;
				}
				div.pagination span.disabled {
				    display:none;
				}
			</style>
			<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
			<script type="text/javascript">
				// Show loading overlay when ajax request starts
				jQuery( document ).ajaxStart(function() {
				    jQuery('.loading-overlay').show();
				});
				// Hide loading overlay when ajax request completes
				jQuery( document ).ajaxStop(function() {
				    jQuery('.loading-overlay').hide();
				});
			</script>
			<div class="post-wrapper">
			    <div class="loading-overlay"><div class="overlay-content">Loading.....</div></div>
				<h1 class="marginbot10 text-left">Pagos Recibidos</h1>
			    <div id="posts_content">
				    <?php
				    //Include pagination class file
				    include(TEMPLATEPATH . '/Pagination.php');
				    
				    //Include database configuration file
				    include(TEMPLATEPATH . '/dbConfig.php');
				    
				    $limit = 50;
				    
				    //get number of rows
				    $queryNum = $db->query("SELECT COUNT(*) as postNum FROM registro");
				    $resultNum = $queryNum->fetch_assoc();
				    $rowCount = $resultNum['postNum'];
				    
				    //initialize pagination class
				    $pagConfig = array('baseURL'=>'/wp-content/themes/vive/getData.php', 'totalRows'=>$rowCount, 'perPage'=>$limit, 'contentDiv'=>'posts_content');
				    $pagination =  new Pagination($pagConfig);
				    
				    //get rows
				    $query = $db->query("SELECT * FROM registro ORDER BY id DESC LIMIT $limit");
				    
				    if($query->num_rows > 0){ ?>
				        <div class="posts_list">
				        	<?php echo $pagination->createLinks(); ?>
							<div class="inventario margintop25">
								<div class="col-md-2 col-sm-2 col-xs-4"><h4>Fecha</h4></div>
							    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Cliente</h4></div>
							    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Banco</h4></div>
							    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Número de Referencia</h4></div>
							    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Monto</h4></div>
							    <div class="col-md-2 col-sm-2 col-xs-4"><h4>Status</h4></div>
							</div>
							<div class="clearfix"></div>
				        	<?php while($row = $query->fetch_assoc()){ 
				                $postID = $row['id'];
				        		$iddeposito=$row['id'];
								$clientedeposito=$row['cliente'];
								$fechadeposito=$row['fecha'];
								$bancodeposito=$row['banco'];
								$referenciadeposito=$row['referencia'];
								$montodeposito=$row['monto'];
								$statusdeposito=$row['status'];
								if ($statusdeposito=='aprobado') {
									$fondo="btn-success";
								} elseif ($statusdeposito=='pendiente') {
									$fondo="btn-warning";
								}elseif ($statusdeposito=='negada') {
									$fondo="btn-danger";
								}
								$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fechadeposito);
								$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
								$fechaunixdep=strtotime($fechacambiadadep); 
								?>
								<div class="fondogrispar <?php echo $clientedeposito; ?> <?php echo $bancodeposito; ?> <?php echo $statusdeposito; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
									<form name="importa<?php echo $iddeposito; ?>" method="post" action="http://vivecolecciones.com.ve/cuentas-clientes/" >
								        <div class="row text-center bordertopnegro">
											<div class="col-md-2 col-sm-2 col-xs-12"> 
												<input placeholder="Fecha"  id="fecha<?php echo $iddeposito; ?>" name="fecha<?php echo $iddeposito; ?>" type="text" class="form-control" value="<?php echo $fechadeposito; ?>">
											</div>
											<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
												<?php echo $clientedeposito; ?>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-6 paddingtop10"> 
												<?php echo $bancodeposito; ?>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12 paddingtop10"> 
												<?php echo $referenciadeposito; ?>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12 paddingtop10">
												Bsf <?php echo number_format($montodeposito, 2, ',', '.'); ?>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12 <?php echo $fondo; ?>">
												<h6><?php echo $statusdeposito; ?></h6>
											</div>
										</div>
										<div class="row text-center marginbot10 paddingbot10 borderbotnegro">
												<input class="btn btn-success btnedc" type="submit" name="btn" id="btn"  value="Aprobar" />
											
												<input class="btn btn-warning btnedc" type="submit" name="btn" id="btn"  value="Pendiente" />
											
												<input class="btn btn-danger btnedc" type="submit" name="btn" id="btn"  value="Negar" />
											
												<input class="btn btn-primary btnedc" type="submit" name="btn" id="btn"  value="Editar" />
											
												<input class="btn btn-default btnedc" type="submit" name="btn" id="btn"  value="Eliminar" />
											
										</div>
										<input hidden type="text" name="id" id="id" value="<?php echo $iddeposito; ?>">
									</form>
								</div>
								<div class="clearfix"></div>
								<script>
								  jQuery(function() {
								    jQuery( "#fecha<?php echo $iddeposito; ?>" ).datepicker({
						        		dateFormat: 'dd/mm/yy',
						        		defaultDate: '<?php echo $fechadeposito; ?>'
						    		});
								  });
								</script>
					        <?php } ?>
				        </div>
				        <?php echo $pagination->createLinks(); ?>
				    <?php } ?>
			    </div>
			</div>


		<?php } else { ?> <h3 class="marginbot25">No existen colecciones asignadas</h3> <?php } ?>
	</div>


<?php }
get_footer(); ?>