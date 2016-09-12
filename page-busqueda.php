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
				if(isset($_POST['btn'])) { include (TEMPLATEPATH . '/funciones/cambiodestatus.php'); } ?>

      			<h1 class="marginbot10 text-left">Pagos Recibidos</h1>

	            <div class="text-left">
					<div class="clearfix"></div>
					<form class="controls" name="busqueda" id="busqueda" method="post">
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Status: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
							    <select class="form-control" name="busstatus" id="busstatus">
								    <option value="todos">Todos</option>
									<option value="aprobado">Aprobado</option>
									<option value="pendiente">Pendiente</option>
									<option value="negada">Negado</option>
							    </select>
							</div>
						</div>
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Usuarios: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
							    <select class="form-control" name="buscliente" id="buscliente">
								    <option value="todos">Todos</option>
					                <?php $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
									$result = mysqli_query($con, "SELECT DISTINCT cliente FROM registro ORDER BY cliente");
									while ($row = mysqli_fetch_array($result)) {
										echo '<option value="'.$row['cliente'].'"> '.$row['cliente'].' </option>';
									} ?>
							    </select>
		    				</div>
	    				</div>
						<div class="clearfix"></div>
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Banco: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
							    <select class="form-control" name="busbanco" id="busbanco">
								    <option value="todos">Todos</option>
									<option value="provincial">Provincial</a>
									<option value="banesco">Banesco</a>
									<option value="activo">Banco Activo</a>
									<option value="bicentenario">Banco Bicentenario</a>
									<option value="venezuela">Banco de Venezuela</a>
									<option value="banplus">Banco BanPlus</a>
									<option value="mercantil">Banco Mercantil</a>
									<option value="bancaribe">Bancaribe</a>
									<option value="bnc">BNC</a>
							    </select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<input class="btn btn-default " type="submit" name="buscar" id="buscar"  value="buscar" />
							</div>
						</div>
					</form>
					<form class="controls" id="Filters">
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

	            <?php if(isset($_POST['buscar']) || isset($_POST['btn'])) { 
	            	$busstatus=$_POST['busstatus'];
	            	$buscliente=$_POST['buscliente'];
	            	$busbanco=$_POST['busbanco'];
	            	if (isset($_POST['gerentecont'])){$buscliente=$_POST['gerentecont'];}
	            	$buscar= ' WHERE ';

					if($buscliente!='todos'){ 
						$buscar=$buscar."cliente='".$buscliente."' "; 
					}
					if($busstatus!='todos'){ 
						if($buscliente=='todos'){
							$buscar=$buscar." status='".$busstatus."' "; 
						}else{
							$buscar=$buscar." AND status='".$busstatus."' "; 
						}
					}
					if($busbanco!='todos'){
						if($buscliente=='todos' && $busstatus=='todos'){
							$buscar=$buscar."  banco='".$busbanco."' "; 
						}else{
							$buscar=$buscar." AND banco='".$busbanco."' "; 
						}
					}
					if($busstatus=='todos' && $buscliente=='todos' &&  $busbanco=='todos' ) {$buscar=''; } 
					?>

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
					<div id="Container">
						<?php
						$result = mysqli_query($con, "SELECT * FROM registro ".$buscar."");
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
							$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fechadeposito);
							$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
							$fechaunixdep=strtotime($fechacambiadadep);
							?>
							<div class="mix <?php echo $clientedeposito; ?> <?php echo $bancodeposito; ?> <?php echo $statusdeposito; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
								<form name="importa<?php echo $iddeposito; ?>" method="post" >
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
									<input hidden type="text" name="gerentecont" id="gerentecont" value="<?php echo $clientedeposito; ?>">
									<input hidden type="text" name="busstatus" id="busstatus" value="<?php echo $busstatus; ?>">
									<input hidden type="text" name="busbanco" id="busbanco" value="<?php echo $busbanco; ?>">
								</form>
							</div>
							<div class="clearfix"></div>
						<?php } ?>

					</div>
                    <div class="pager-list marginbot10"></div>


	            <?php } 
			} else { ?> <h3 class="marginbot25">No existen colecciones asignadas</h3> <?php } ?>
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
		$(function(){   
		  dropdownFilter.init();
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

	<!--////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
	<!--//////////////////////////////////////       CONTRIBUTOR     //////////////////////////////////////////// -->
	<!--//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php } elseif (current_user_can('contributor')) { ?>
	<div class="container text-center margintop25 marginbot25">
		<?php include (TEMPLATEPATH . '/funciones/usuariologged.php');
			$args=array('post_status' => 'publish', 'order' => 'ASC', 'post_type'=> 'post', 'posts_per_page' => 1); $my_query = new WP_Query($args);
        	if( $my_query->have_posts() ) {
        		$todoslosusuarios = get_users();
				if(isset($_POST['btn'])) { include (TEMPLATEPATH . '/funciones/cambiodestatus.php'); } ?>

      			<h1 class="marginbot10 text-left">Pagos Recibidos</h1>

	            <div class="text-left">
					<div class="clearfix"></div>
					<form class="controls" name="busqueda" id="busqueda" method="post">
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Status: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
							    <select class="form-control" name="busstatus" id="busstatus">
								    <option value="todos">Todos</option>
									<option value="aprobado">Aprobado</option>
									<option value="pendiente">Pendiente</option>
									<option value="negada">Negado</option>
							    </select>
							</div>
						</div>
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Usuarios: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
							    <select class="form-control" name="buscliente" id="buscliente">
								    <option value="todos">Todos</option>
					                <?php $con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");
									$result = mysqli_query($con, "SELECT DISTINCT cliente FROM registro ORDER BY cliente");
									while ($row = mysqli_fetch_array($result)) {
										echo '<option value="'.$row['cliente'].'"> '.$row['cliente'].' </option>';
									} ?>
							    </select>
		    				</div>
	    				</div>
						<div class="clearfix"></div>
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<span class="finalinventario">Filtrar por Banco: </span>
							</div>
							<div class="col-md-10 col-sm-10 col-xs-12">
							    <select class="form-control" name="busbanco" id="busbanco">
								    <option value="todos">Todos</option>
									<option value="provincial">Provincial</a>
									<option value="banesco">Banesco</a>
									<option value="activo">Banco Activo</a>
									<option value="bicentenario">Banco Bicentenario</a>
									<option value="venezuela">Banco de Venezuela</a>
									<option value="banplus">Banco BanPlus</a>
									<option value="mercantil">Banco Mercantil</a>
									<option value="bancaribe">Bancaribe</a>
									<option value="bnc">BNC</a>
							    </select>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row margintop10">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<input class="btn btn-default " type="submit" name="buscar" id="buscar"  value="buscar" />
							</div>
						</div>
					</form>
					<form class="controls" id="Filters">
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

	            <?php if(isset($_POST['buscar'])) { 
	            	$busstatus=$_POST['busstatus'];
	            	$buscliente=$_POST['buscliente'];
	            	$busbanco=$_POST['busbanco'];
	            	$buscar= ' WHERE ';

					if($buscliente!='todos'){ 
						$buscar=$buscar."cliente='".$buscliente."' "; 
					}
					if($busstatus!='todos'){ 
						if($buscliente=='todos'){
							$buscar=$buscar." status='".$busstatus."' "; 
						}else{
							$buscar=$buscar." AND status='".$busstatus."' "; 
						}
					}
					if($busbanco!='todos'){
						if($buscliente=='todos' && $busstatus=='todos'){
							$buscar=$buscar."  banco='".$busbanco."' "; 
						}else{
							$buscar=$buscar." AND banco='".$busbanco."' "; 
						}
					}
					if($busstatus=='todos' && $buscliente=='todos' &&  $busbanco=='todos' ) {$buscar=''; } 
					?>

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
					<div id="Container">
						<?php
						$result = mysqli_query($con, "SELECT * FROM registro ".$buscar."");
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
							$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fechadeposito);
							$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
							$fechaunixdep=strtotime($fechacambiadadep);
							?>
							<div class="mix <?php echo $clientedeposito; ?> <?php echo $bancodeposito; ?> <?php echo $statusdeposito; ?>" data-myorder="<?php echo $fechaunixdep; ?>">
						        <div class="row text-center bordertopnegro">
									<div class="col-md-2 col-sm-2 col-xs-12 paddingtop10"> 
										<?php echo $fechadeposito; ?>
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
							</div>
							<div class="clearfix"></div>
						<?php } ?>

					</div>
                    <div class="pager-list marginbot10"></div>


	            <?php } 
			} else { ?> <h3 class="marginbot25">No existen colecciones asignadas</h3> <?php } ?>
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
	$(function(){   
	  dropdownFilter.init();
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