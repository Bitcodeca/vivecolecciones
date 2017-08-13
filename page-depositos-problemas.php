<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else { ?>

			<div class="container-fluid margintop25 marginbot25">	
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Depósitos Problemas</h1>





<?php
if(isset($_POST['btn'])){
	if($_POST['btn']=='borrar'){
		$iddep=$_POST['id'];
		$query2 = "DELETE FROM vive_pen WHERE id=$iddep";
		if ($mysqli->query( $query2 ) === TRUE) { ?>
			<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
				<div class="modal-content">
					<h4>DEPÓSITO BORRADO</h4>
				</div>
				<div class="modal-footer">
					<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
				</div>
			</div> 
		<?php }
	}
	if($_POST['btn']=='editar') {
		$iddep=$_POST['id'];
		$usuariodep=$_POST['usuario'];
		$fechadep=$_POST['fecha'];
		$referenciadep=$_POST['referencia'];
		$montodep=$_POST['monto'];
		$bancodep=$_POST['banco'.$iddep];
		$statusdep=$_POST['status'.$iddep];
		$camdep=$_POST['cam'.$iddep];
		$comentariodep=$_POST['comentario'];

		if($statusdep=='aprobado'){
			
							
			$query = "SELECT * from vive_dep WHERE fecha='$fechadep' AND referencia='$referenciadep' AND monto='$montodep' AND banco='$bancodep' AND usuario<>'vacio'";
			$result = mysqli_query($mysqli, $query);
			if(mysqli_num_rows($result) == 0) {

				$query3 = "SELECT * from vive_dep WHERE fecha='$fechadep' AND referencia='$referenciadep' AND monto='$montodep' AND banco='$bancodep' AND usuario='vacio'";
				$result3 = mysqli_query($mysqli, $query3);
				if(mysqli_num_rows($result3) != 0) {
					while ($row = mysqli_fetch_assoc($result3)) { 
						$iddata=$row['id'];
					}
					$query2 = "DELETE FROM vive_pen WHERE id=$iddep";
	                if( $mysqli->query( $query2 ) ){
	                	$query3="UPDATE vive_dep SET cam='$camdep', status='$statusdep', usuario='$usuariodep' WHERE id='$iddata'";
	            		if( $mysqli->query( $query3 ) ){ ?>
							<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
								<div class="modal-content">
									<h4>DEPÓSITO APROBADO</h4>
								</div>
								<div class="modal-footer">
									<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
								</div>
							</div> 
						<?php }
	                }
	            } 
	            else { 
	            	?>
					<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
						<div class="modal-content">
							<h4>ERROR</h4>
							<h5>No se puede aprobar el depósito si no se encuentra en la base de datos</h5>
						</div>
						<div class="modal-footer">
							<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
						</div>
					</div> 
					<?php
				}
			} else { 
				?>
				<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
					<div class="modal-content">
						<h4>ERROR</h4>
						<h5>Ya existe un depósito con los mismos datos aprobado.</h5>
					</div>
					<div class="modal-footer">
						<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
					</div>
				</div> 
				<?php
			}
		}else{
			$query2 = "UPDATE vive_pen SET fecha='$fechadep', referencia='$referenciadep', monto='$montodep', banco='$bancodep', status='$statusdep', cam='$camdep', comentario='$comentariodep' WHERE id=$iddep";
			if ($mysqli->query( $query2 ) === TRUE) { ?>
				<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
					<div class="modal-content">
						<h4>DEPÓSITO MODIFICADO</h4>
					</div>
					<div class="modal-footer">
						<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
					</div>
				</div> 
			<?php } else {
				 printf("Error: %s\n", $mysqli->error);
			}
		}


	}
}
// Establish Connection to the Database
$con = mysqli_connect("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");//Records per page
$per_page=20;

$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = explode("/", $actual_link);
end($actual_link);
$ultimo=prev($actual_link);

if (is_numeric($ultimo)) {

$page = $ultimo;

}

else {

$page=1;

}

// Page will start from 0 and Multiple by Per Page
$start_from = ($page-1) * $per_page;

//Selecting the data from table but with limit
$query = "SELECT * FROM vive_pen WHERE status='Pendiente' LIMIT $start_from, $per_page";
$result = mysqli_query ($con, $query);

?>
  <table class="striped responsive-table">
        <thead>
          <tr>
              <th data-field="id">Fecha</th>
              <th data-field="id">Usuario</th>
              <th data-field="name">Banco</th>
              <th data-field="price">Referencia</th>
              <th data-field="price">Monto</th>
              <th data-field="price">Campaña</th>
              <th data-field="price">Acción</th>
          </tr>
        </thead>

        <tbody>

<?php
while ($row = mysqli_fetch_assoc($result)) {
?>
    <tr>
        <td><?php echo $row['fecha']; ?></td>
        <td><?php echo $row['usuario']; ?></td>
        <td><?php echo $row['banco']; ?></td>
        <td><?php echo $row['referencia']; ?></td>
        <td>Bsf <?php if (is_numeric($row['monto'])){$valor=formato($row['monto']); echo $valor;}else{echo $row['monto'];} ?></td>
        <td><?php echo $row['cam']; ?></td>
        <td>
        	<a class="btn hoverable fondo3 waves-effect waves-light btn-radius" href="#<?php echo $row['id']; ?>">EDITAR</a>
		</td>
    </tr>
	<div id="<?php echo $row['id']; ?>" class="modal">
		<form role="form" method="post" name="<?php echo $row['id']; ?>" action="" >
			<div class="modal-content">
				<h4 class="bold">MODIFICAR</h4>
				<div class="input-field col-xs-12">
					<h4>Fecha</h4>
					<input type="date" class="datepicker" id="fecha" name="fecha" data-value="<?php echo $row['fecha'];?>">
				</div>
				<div class="input-field col-xs-12">
					<h4>Usuario</h4>
	        		<input type="text" placeholder="Campaña" name="usuario"  id="usuario"  value="<?php echo $row['usuario'];?>" readonly required>
				</div>
				<div class="input-field col-xs-12">
					<h4>Banco</h4>

					<p>
						<input name="banco<?php echo $row['id']; ?>" type="radio" id="<?php echo $row['banco']; ?><?php echo $row['id']; ?>" value="<?php echo $row['banco']; ?>" checked />
						<label for="<?php echo $row['banco']; ?><?php echo $row['id']; ?>"><?php echo $row['banco']; ?></label>
					</p>
					<?php
						$bancos=bancos();
						foreach ($bancos as $opcion) {
							if($opcion!=$row['banco']){ ?>
								<p>
									<input name="banco<?php echo $row['id']; ?>" type="radio" id="<?php echo $opcion; ?><?php echo $row['id']; ?>" value="<?php echo $opcion; ?>" />
									<label for="<?php echo $opcion; ?><?php echo $row['id']; ?>"><?php echo $opcion; ?></label>
								</p>
							<?php }
						}
					?>
				</div>
				<div class="input-field col-xs-12">
					<h4>Referencia</h4>
	        		<input type="text" placeholder="Campaña" name="referencia"  id="referencia"  value="<?php echo $row['referencia'];?>" required>
				</div>
				<div class="input-field col-xs-12">
					<h4>Monto</h4>
	        		<input type="text" placeholder="Campaña" name="monto"  id="monto"  value="<?php echo $row['monto'];?>" required>
				</div>
				<div class="input-field col-xs-12">
					<h4>Campaña</h4>

					<p>
						<input name="cam<?php echo $row['id']; ?>" type="radio" id="<?php echo $row['cam']; ?><?php echo $row['id']; ?>" value="<?php echo $row['cam']; ?>" checked />
						<label for="<?php echo $row['cam']; ?><?php echo $row['id']; ?>"><?php echo $row['cam']; ?></label>
					</p>
						<?php
						$usuario=$row['usuario'];
						$query3 = "SELECT DISTINCT cam from vive_fac WHERE usuario='$usuario' ORDER BY cam ASC";
						$result3 = mysqli_query($mysqli, $query3);
						if(mysqli_num_rows($result3) != 0) {
							while($row3 = mysqli_fetch_assoc($result3)) {
								$cam=$row3['cam'];
								if($row['cam']!=$cam){
									?>
									<p>
										<input name="cam<?php echo $row['id']; ?>" type="radio" id="<?php echo $cam; ?><?php echo $row['id']; ?>" value="<?php echo $cam; ?>" />
										<label for="<?php echo $cam; ?><?php echo $row['id']; ?>"><?php echo $cam; ?></label>
									</p>
									<?php
								}
							}
						} ?>
				</div>
				<div class="input-field col-xs-12">
					<h4>Status</h4>
					<?php
						$minuscula=strtolower($row['status']);
					?>
					<p>
						<input name="status<?php echo $row['id']; ?>" type="radio" id="<?php echo $minuscula; ?><?php echo $row['id']; ?>" value="<?php echo $minuscula; ?>" checked />
						<label for="<?php echo $minuscula; ?><?php echo $row['id']; ?>"><?php echo $minuscula; ?></label>
					</p>
					<?php
						$status=status();
						foreach ($status as $opcion) {
							if($opcion!=$minuscula){ ?>
								<p> 
									<input name="status<?php echo $row['id']; ?>" type="radio" id="<?php echo $opcion; ?><?php echo $row['id']; ?>" value="<?php echo $opcion; ?>" />
									<label for="<?php echo $opcion; ?><?php echo $row['id']; ?>"><?php echo $opcion; ?></label>
								</p>
							<?php }
						}
					?>
				</div>
				<div class="input-field col-xs-12 marginbot25">
					<h4>Descripción</h4>
	        		<textarea id="comentario" name="comentario" class="materialize-textarea" length="500"></textarea>
				</div>
			</div>
			<div class="modal-footer">
					<button  type="submit" name="btn" id="btn" value="borrar" class="btn hoverable fondo5 waves-effect waves-light btn-radius" type="submit">
						<i class="material-icons left">cancel</i>
							BORRAR DEPÓSITO
					</button>
					<button  type="submit" name="btn" id="btn" value="editar" class="btn hoverable fondo2 waves-effect waves-light btn-radius" type="submit">
						<i class="material-icons left">mode_edit</i>
							EDITAR
					</button>
					<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
					<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">CANCELAR</a>
			</div>
		</form>
	</div>
<?php
};
?>
        </tbody>
      </table>

<div>
<?php

//Now select all from table
$query = "select * from vive_pen WHERE status='Pendiente'";
$result = mysqli_query($con, $query);

// Count the total records
$total_records = mysqli_num_rows($result);

//Using ceil function to divide the total records on per page
$total_pages = ceil($total_records / $per_page);

//Going to first page

echo '<ul class="pagination">';
echo "<li><a href='http://app.vivecolecciones.com.ve/depositos-problemas/?page=1'>".'Primera página'."</a></li>";

for ($i=1; $i<=$total_pages; $i++) {
	if($ultimo==$i){$clase='active';}else{$clase='';}
echo "<li class='waves-effect ".$clase."'><a href='http://app.vivecolecciones.com.ve/depositos-problemas/?page=".$i."'>".$i."</a></li>";
};
// Going to last page
echo "<li><a href='http://app.vivecolecciones.com.ve/depositos-problemas/?page=".$total_pages."'>".'Última página'."</a></li>";
echo '</ul>';

?>

</div>








						</div>
					</div>
				</div>
			</div>
	    <?php }
	} elseif($user_logged['rol']=='Analista'){


	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } 
	    else { 


			$gerente_logged=$user_logged['login'];
			$stmt0 = $mysqli->prepare("SELECT gerente FROM vive_analista WHERE analista = ?");
			$stmt0->bind_param('s', $gerente_logged);
			$stmt0->execute();
			$stmt0->bind_result($query_gerente);
			$stmt0->store_result();
			$array_analista=array();
		    while ($stmt0->fetch()) {
		    	array_push($array_analista, $query_gerente);
		    }
		    $stmt0->close();
		    $cantidad_gerente=count($array_analista);
		    if($cantidad_gerente>=1){
		    	$cantidad_gerente_pu=$cantidad_gerente-1;
		    	if($cantidad_gerente==1){$buscar_gerente="usuario='".$array_analista[0]."'";}
		    	elseif($cantidad_gerente>1){
		    		$buscar_gerente='';
		    		$buscar_gerente = join("','",$array_analista);
		    	}

    			?>

				<div class="container-fluid margintop25 marginbot25">	
		    		<div class="row">
						<div class="col-md-12">
							<div class="card-panel z-depth-2 hoverable">
						     	<h1 class="center-align">Depósitos Problemas</h1>
								<?php
								if(isset($_POST['btn'])){
									if($_POST['btn']=='borrar'){
										$iddep=$_POST['id'];
										$query2 = "DELETE FROM vive_pen WHERE id=$iddep";
										if ($mysqli->query( $query2 ) === TRUE) { ?>
											<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
												<div class="modal-content">
													<h4>DEPÓSITO BORRADO</h4>
												</div>
												<div class="modal-footer">
													<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
												</div>
											</div> 
										<?php }
									}
									if($_POST['btn']=='editar') {
										$iddep=$_POST['id'];
										$usuariodep=$_POST['usuario'];
										$fechadep=$_POST['fecha'];
										$referenciadep=$_POST['referencia'];
										$montodep=$_POST['monto'];
										$bancodep=$_POST['banco'.$iddep];
										$statusdep=$_POST['status'.$iddep];
										$camdep=$_POST['cam'.$iddep];
										$comentariodep=$_POST['comentario'];

										if($statusdep=='aprobado'){
											
															
											$query = "SELECT * from vive_dep WHERE fecha='$fechadep' AND referencia='$referenciadep' AND monto='$montodep' AND banco='$bancodep' AND usuario<>'vacio'";
											$result = mysqli_query($mysqli, $query);
											if(mysqli_num_rows($result) == 0) {

												$query3 = "SELECT * from vive_dep WHERE fecha='$fechadep' AND referencia='$referenciadep' AND monto='$montodep' AND banco='$bancodep' AND usuario='vacio'";
												$result3 = mysqli_query($mysqli, $query3);
												if(mysqli_num_rows($result3) != 0) {
													while ($row = mysqli_fetch_assoc($result3)) { 
														$iddata=$row['id'];
													}
													$query2 = "DELETE FROM vive_pen WHERE id=$iddep";
									                if( $mysqli->query( $query2 ) ){
									                	$query3="UPDATE vive_dep SET cam='$camdep', status='$statusdep', usuario='$usuariodep' WHERE id='$iddata'";
									            		if( $mysqli->query( $query3 ) ){ ?>
															<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
																<div class="modal-content">
																	<h4>DEPÓSITO APROBADO</h4>
																</div>
																<div class="modal-footer">
																	<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
																</div>
															</div> 
														<?php }
									                }
									            } 
									            else { 
									            	?>
													<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
														<div class="modal-content">
															<h4>ERROR</h4>
															<h5>No se puede aprobar el depósito si no se encuentra en la base de datos</h5>
														</div>
														<div class="modal-footer">
															<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
														</div>
													</div> 
													<?php
												}
											} else { 
												?>
												<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
													<div class="modal-content">
														<h4>ERROR</h4>
														<h5>Ya existe un depósito con los mismos datos aprobado.</h5>
													</div>
													<div class="modal-footer">
														<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
													</div>
												</div> 
												<?php
											}
										}else{
											$query2 = "UPDATE vive_pen SET fecha='$fechadep', referencia='$referenciadep', monto='$montodep', banco='$bancodep', status='$statusdep', cam='$camdep', comentario='$comentariodep' WHERE id=$iddep";
											if ($mysqli->query( $query2 ) === TRUE) { ?>
												<div id="<?php echo 'btn'.$iddep; ?>" class="modal">
													<div class="modal-content">
														<h4>DEPÓSITO MODIFICADO</h4>
													</div>
													<div class="modal-footer">
														<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
													</div>
												</div> 
											<?php } else {
												 printf("Error: %s\n", $mysqli->error);
											}
										}


									}
								}
								// Establish Connection to the Database
								$con = mysqli_connect("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");//Records per page
								$per_page=20;

								$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
								$actual_link = explode("/", $actual_link);
								end($actual_link);
								$ultimo=prev($actual_link);

								if (is_numeric($ultimo)) {

								$page = $ultimo;

								}

								else {

								$page=1;

								}

								// Page will start from 0 and Multiple by Per Page
								$start_from = ($page-1) * $per_page;

								//Selecting the data from table but with limit
								$query = "SELECT * FROM vive_pen WHERE status='Pendiente' AND usuario IN ('$buscar_gerente') LIMIT $start_from, $per_page";
								$result = mysqli_query ($con, $query);

								?>
				  <table class="striped responsive-table">
				        <thead>
				          <tr>
				              <th data-field="id">Fecha</th>
				              <th data-field="id">Usuario</th>
				              <th data-field="name">Banco</th>
				              <th data-field="price">Referencia</th>
				              <th data-field="price">Monto</th>
				              <th data-field="price">Campaña</th>
				              <th data-field="price">Acción</th>
				          </tr>
				        </thead>

				        <tbody>

						<?php
						while ($row = mysqli_fetch_assoc($result)) {
							?>
						    <tr>
						        <td><?php echo $row['fecha']; ?></td>
						        <td><?php echo $row['usuario']; ?></td>
						        <td><?php echo $row['banco']; ?></td>
						        <td><?php echo $row['referencia']; ?></td>
						        <td>Bsf <?php if (is_numeric($row['monto'])){$valor=formato($row['monto']); echo $valor;}else{echo $row['monto'];} ?></td>
						        <td><?php echo $row['cam']; ?></td>
						        <td>
						        	<a class="btn hoverable fondo3 waves-effect waves-light btn-radius" href="#<?php echo $row['id']; ?>">EDITAR</a>
								</td>
						    </tr>
							<div id="<?php echo $row['id']; ?>" class="modal">
								<form role="form" method="post" name="<?php echo $row['id']; ?>" action="" >
									<div class="modal-content">
										<h4 class="bold">MODIFICAR</h4>
										<div class="input-field col-xs-12">
											<h4>Fecha</h4>
											<input type="date" class="datepicker" id="fecha" name="fecha" data-value="<?php echo $row['fecha'];?>">
										</div>
										<div class="input-field col-xs-12">
											<h4>Usuario</h4>
							        		<input type="text" placeholder="Campaña" name="usuario"  id="usuario"  value="<?php echo $row['usuario'];?>" readonly required>
										</div>
										<div class="input-field col-xs-12">
											<h4>Banco</h4>

											<p>
												<input name="banco<?php echo $row['id']; ?>" type="radio" id="<?php echo $row['banco']; ?><?php echo $row['id']; ?>" value="<?php echo $row['banco']; ?>" checked />
												<label for="<?php echo $row['banco']; ?><?php echo $row['id']; ?>"><?php echo $row['banco']; ?></label>
											</p>
											<?php
												$bancos=bancos();
												foreach ($bancos as $opcion) {
													if($opcion!=$row['banco']){ ?>
														<p>
															<input name="banco<?php echo $row['id']; ?>" type="radio" id="<?php echo $opcion; ?><?php echo $row['id']; ?>" value="<?php echo $opcion; ?>" />
															<label for="<?php echo $opcion; ?><?php echo $row['id']; ?>"><?php echo $opcion; ?></label>
														</p>
													<?php }
												}
											?>
										</div>
										<div class="input-field col-xs-12">
											<h4>Referencia</h4>
							        		<input type="text" placeholder="Campaña" name="referencia"  id="referencia"  value="<?php echo $row['referencia'];?>" required>
										</div>
										<div class="input-field col-xs-12">
											<h4>Monto</h4>
							        		<input type="text" placeholder="Campaña" name="monto"  id="monto"  value="<?php echo $row['monto'];?>" required>
										</div>
										<div class="input-field col-xs-12">
											<h4>Campaña</h4>

											<p>
												<input name="cam<?php echo $row['id']; ?>" type="radio" id="<?php echo $row['cam']; ?><?php echo $row['id']; ?>" value="<?php echo $row['cam']; ?>" checked />
												<label for="<?php echo $row['cam']; ?><?php echo $row['id']; ?>"><?php echo $row['cam']; ?></label>
											</p>
												<?php
												$usuario=$row['usuario'];
												$query3 = "SELECT DISTINCT cam from vive_fac WHERE usuario='$usuario' ORDER BY cam ASC";
												$result3 = mysqli_query($mysqli, $query3);
												if(mysqli_num_rows($result3) != 0) {
													while($row3 = mysqli_fetch_assoc($result3)) {
														$cam=$row3['cam'];
														if($row['cam']!=$cam){
															?>
															<p>
																<input name="cam<?php echo $row['id']; ?>" type="radio" id="<?php echo $cam; ?><?php echo $row['id']; ?>" value="<?php echo $cam; ?>" />
																<label for="<?php echo $cam; ?><?php echo $row['id']; ?>"><?php echo $cam; ?></label>
															</p>
															<?php
														}
													}
												} ?>
										</div>
										<div class="input-field col-xs-12">
											<h4>Status</h4>
											<?php
												$minuscula=strtolower($row['status']);
											?>
											<p>
												<input name="status<?php echo $row['id']; ?>" type="radio" id="<?php echo $minuscula; ?><?php echo $row['id']; ?>" value="<?php echo $minuscula; ?>" checked />
												<label for="<?php echo $minuscula; ?><?php echo $row['id']; ?>"><?php echo $minuscula; ?></label>
											</p>
											<?php
												$status=status();
												foreach ($status as $opcion) {
													if($opcion!=$minuscula){ ?>
														<p> 
															<input name="status<?php echo $row['id']; ?>" type="radio" id="<?php echo $opcion; ?><?php echo $row['id']; ?>" value="<?php echo $opcion; ?>" />
															<label for="<?php echo $opcion; ?><?php echo $row['id']; ?>"><?php echo $opcion; ?></label>
														</p>
													<?php }
												}
											?>
										</div>
										<div class="input-field col-xs-12 marginbot25">
											<h4>Descripción</h4>
							        		<textarea id="comentario" name="comentario" class="materialize-textarea" length="500"></textarea>
										</div>
									</div>
									<div class="modal-footer">
											<button  type="submit" name="btn" id="btn" value="borrar" class="btn hoverable fondo5 waves-effect waves-light btn-radius" type="submit">
												<i class="material-icons left">cancel</i>
													BORRAR DEPÓSITO
											</button>
											<button  type="submit" name="btn" id="btn" value="editar" class="btn hoverable fondo2 waves-effect waves-light btn-radius" type="submit">
												<i class="material-icons left">mode_edit</i>
													EDITAR
											</button>
											<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
											<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">CANCELAR</a>
									</div>
								</form>
							</div>
							<?php
						}
						?>
				        </tbody>
				      </table>

				<div>
				<?php

					//Now select all from table
					$query = "select * from vive_pen WHERE status='Pendiente' AND usuario IN ('$buscar_gerente')";
					$result = mysqli_query($con, $query);

					// Count the total records
					$total_records = mysqli_num_rows($result);

					//Using ceil function to divide the total records on per page
					$total_pages = ceil($total_records / $per_page);

					//Going to first page

					echo '<ul class="pagination">';
					echo "<li><a href='http://app.vivecolecciones.com.ve/depositos-problemas/?page=1'>".'Primera página'."</a></li>";

					for ($i=1; $i<=$total_pages; $i++) {
						if($ultimo==$i){$clase='active';}else{$clase='';}
					echo "<li class='waves-effect ".$clase."'><a href='http://app.vivecolecciones.com.ve/depositos-problemas/?page=".$i."'>".$i."</a></li>";
					};
					// Going to last page
					echo "<li><a href='http://app.vivecolecciones.com.ve/depositos-problemas/?page=".$total_pages."'>".'Última página'."</a></li>";
					echo '</ul>';

					?>

					</div>
				<?php
			}
		}
	}
	else{ ?>
		<h1> ACCESO NEGADO </h1>
	<?php	}  ?>
<?php } else {  
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit(); 
 } get_footer(); ?>
 <script>
	jQuery(document).ready(function(){
	    jQuery('.modal').modal();
	    jQuery('select').material_select();
	    jQuery('textarea#descripcion').characterCounter();
	    jQuery('.datepicker').pickadate({
	    	monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		    selectMonths: true, // Creates a dropdown to control month
		    selectYears: 1, // Creates a dropdown of 15 years to control year
		    format: 'dd/mm/yyyy',
		    today: 'Hoy',
			clear: 'Borrar',
			close: 'Cerrar',
		});
	});
</script>
<?php
	if(isset($_POST['btn'])){ ?>
		<script>
			  jQuery(document).ready(function(){
			    jQuery('#<?php echo 'btn'.$iddep; ?>').modal('open');
			  });
		</script>
	<?php
	}
?>