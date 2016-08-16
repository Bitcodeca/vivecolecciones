<?php get_header();
	if( current_user_can('subscriber')) { ?>
	<h1 class="letraroja">Acceso Negado</h1>
	<?php }
	elseif (current_user_can('administrator')) { ?>
		<div class="row hidden-print">
			<div class="col-md-12 text-center">
				<h2>Impresión de depósitos Aprobados</h2>
			</div>
		</div>
		<?php if(!isset($_POST['print'])) { ?>
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<form name="importa" method="post" action="http://vivecolecciones.com.ve/imprimir-depositos/" >
					        <div class="col-md-12 text-center">
						        <select id="cliente" name="cliente" style="width: auto; padding: 8px;" required>
						        	<option value="" hidden>Seleccionar Usuario</option>
						        	<?php $todoslosusuarios = get_users();
										foreach ( $todoslosusuarios as $user ) {
											 $buscar=$user->user_login; ?>
											 <option value="<?php echo $buscar; ?>"><?php echo $buscar; ?></option>
									<?php } ?>
								</select>
								<input class="btn btn-default" type="submit" name="print" id="print"  value="Imprimir" />
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php } else { ?>
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
							<h3>Depósitos</h3>
							<h4>Fecha: <?php echo date("Y-m-d"); ?></h4>
						</div>
					</div>
				</div>
				<div class="row">
					<h2 class="text-center">Relación de depósitos</h2>
				</div>
		      	<div class="col-md-12">
			      	<?php
	      			$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
					$result = mysqli_query($con, "SELECT * FROM registro WHERE cliente='".$cliente."' AND status='aprobado' ORDER BY id");
					while ($row = mysqli_fetch_array($result)) {
						$iddeposito=$row['id'];
						$clientedeposito=$row['cliente'];
						$fechadeposito=$row['fecha'];
						$bancodeposito=$row['banco'];
						$referenciadeposito=$row['referencia'];
						$montodeposito=$row['monto'];
						$statusdeposito=$row['status'];
						if ($statusdeposito=='aprobado') {
							$fondo="btn-success";
							$aprobado++;
						} elseif ($statusdeposito=='pendiente') {
							$fondo="btn-warning";
							$pendiente++;
						}elseif ($statusdeposito=='negada') {
							$fondo="btn-danger";
							$negado++;
						}
						?>
				        <div class="fondogrispar row text-center bordertopnegro">
							<div class="col-md-2 col-sm-2 col-xs-2 paddingtop10"> 
								<?php echo $fechadeposito; ?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2 paddingtop10"> 
								<?php echo $clientedeposito; ?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2 paddingtop10"> 
								<?php echo $bancodeposito; ?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2 paddingtop10"> 
								<?php echo $referenciadeposito; ?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2 paddingtop10">
								Bsf <?php echo number_format($montodeposito, 2, ',', '.'); ?>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-2 <?php echo $fondo; ?>">
								<h6><?php echo $statusdeposito; ?></h6>
							</div>
						</div>
						<div class="clearfix"></div>
					<?php } ?>
		        </div>
		    </div>
			<div class="clearfix margintop50"></div>
		    <script>
				jQuery(document).ready(function(){
				    window.print();
				});
		    </script>
	<?php }
	}?> 

<div class="clearfix margintop50"></div>
<?php
 get_footer(); ?>