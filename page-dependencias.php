<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else {
	    		if(isset($_POST['btn'])){
	    			$usuario=$_POST['usuario'];
	    			$array=array();
	    			$asub=array();
	    			$x=0;
/////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// IR AL GERENTE ORIGEN /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
	    			$buscar=$usuario;
	    			while($x==0){
						$query = "SELECT * from vive_sub WHERE sub='$buscar'";
						$result = mysqli_query($mysqli, $query);
						if(mysqli_num_rows($result) != 0) { while($row = mysqli_fetch_assoc($result)) { $buscar=$row['ger']; } } else { $x++; }
	    			}
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// GUARDAR AL GERENTE ORIGEN //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
					$variable="[{v:'".$buscar."', f:'<h4>".$buscar."</h4>'}, '', ''],";
					array_push($array, $variable);
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// GUARDAR A LOS SUBGERENTES PRINCIPALES //////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
					$query = "SELECT * from vive_sub WHERE ger='$buscar'";
					$result = mysqli_query($mysqli, $query);
					if(mysqli_num_rows($result) != 0) {
						while($row = mysqli_fetch_assoc($result)) {
							$variable="[{v:'".$row['sub']."', f:'<h4>".$row['sub']."</h4>'}, '".$row['ger']."', ''],";
							array_push($array, $variable);
							array_push($asub, $row['sub']);
						}
					}
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// EMPEZAR A BAJAR POR EL ARBOL ///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
					foreach ($asub as $value) {
						$query = "SELECT * from vive_sub WHERE ger='$value'";
						$result = mysqli_query($mysqli, $query);
						if(mysqli_num_rows($result) != 0) {
							////////////////////////////////////////////
							/////////////// VACIAR ARRAY //////////////
							//////////////////////////////////////////
							$varArray=array();
							//////////////////////////////////////////////////////////
							/////////////// GUARDAR LA ESCALA INFERIOR //////////////
							////////////////////////////////////////////////////////
							while($row = mysqli_fetch_assoc($result)) {
								$variable="[{v:'".$row['sub']."', f:'<h4>".$row['sub']."</h4>'}, '".$row['ger']."', ''],";
								array_push($array, $variable);
								array_push($varArray, $row['sub']);
							}
							/////////////////////////////////////////////////////////////
							/////////////// PASEAR POR LA ESCALA INFERIOR //////////////
							///////////////////////////////////////////////////////////
							foreach ($varArray as $value2) {
								$x=0;
								$buscar=$value2;
								///////////////////////////////////////////////////////////////////
								/////////////// LOOP DINAMICO DE ESCALAS INFERIORES //////////////
								/////////////////////////////////////////////////////////////////
				    			while($x==0){
									$query = "SELECT * from vive_sub WHERE ger='$buscar'";
									$result = mysqli_query($mysqli, $query);
									if(mysqli_num_rows($result) != 0) {
										while($row = mysqli_fetch_assoc($result)) {
											$variable="[{v:'".$row['sub']."', f:'<h4>".$row['sub']."</h4>'}, '".$row['ger']."', ''],";
											array_push($array, $variable);
											$buscar=$row['sub'];
										}
									} else {
										$x++;
									}
				    			}
							/////////////////////////////////////////////////////////
							/////////////// VOLVER A LA ESCALA ACTUAL //////////////
							///////////////////////////////////////////////////////
				    		}

						/////////////////////////////////////////////////////////////
						/////////////// VOLVER AL LOOP Y VACIAR ARRAY //////////////
						///////////////////////////////////////////////////////////
						}

					////////////////////////////////////////////////////////
					/////////////// VOLVER AL LOOP PRINCIPAL //////////////
					//////////////////////////////////////////////////////
					}
	    		?>
					<div class="container-fluid margintop25 marginbot25">	
			    		<div class="row">
							<div class="col-md-12">
								<div class="card-panel z-depth-2 hoverable" style="overflow-x: scroll">
							     	<h1 class="center-align">Dependencias</h1>

									<div id="chart_div"></div>

								</div>
							</div>
						</div>
					</div>
				<?php
	    		}
	    		else {
	    	?>

			<div class="container margintop25 marginbot25">	
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Dependencias</h1>

							<div class="row">
								<div class="col-xs-12 col-sm-4 col-sm-offset-4">
									<form name="importa" method="post" >
										<div class="input-field">
											<select name="usuario" id="usuario">
												<option value="" disabled selected>Selecciona el Usuario</option>
										        	<?php $todoslosusuarios = get_users();
														foreach ( $todoslosusuarios as $user ) {
															 $buscar=$user->user_login; ?>
															 <option value="<?php echo $buscar; ?>"><?php echo $buscar; ?></option>
													<?php } ?>
												<label>Seleccionar</label>
											</select>
										</div>

										<div class="row center-align">
											<button type="submit" value="siguiente" id="btn" name="btn" class="btn btn-radius fondo3 waves-effect waves-light">
												<i class="material-icons medium right">arrow_forward</i>
												SIGUIENTE
											</button>
										</div>
									</form>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

	    	<?php 
	    	}
		}
	} else{ ?>
		<h1> ACCESO NEGADO </h1>
	<?php	}  ?>
<?php } else {  
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit(); 
 } get_footer(); ?>

<script>
	jQuery(document).ready(function() {
	    jQuery('select').material_select();
	  });
</script>

<?php if(isset($_POST['btn'])){ ?>
  <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');

        // For each orgchart box, provide the name, manager, and tooltip to show.
        data.addRows([
        	<?php
        		foreach ($array as $value) {
        			echo $value;        			
        		}
        	?>
        /*
          [{v:'Mike', f:'<h4>Mike</h4>'}, '', 'The President'],
          [{v:'Jim', f:'<h4>Jim</h4>'}, 'Mike', 'VP'],
          [{v:'Juan', f:'<h4>Juan</h4>'}, 'Mike', 'VP2'],
          [{v:'Pepe', f:'<h4>Pepe</h4>'}, 'Juan', ''],
          [{v:'Sutano', f:'<h4>Sutano</h4>'}, 'Pepe', ''],
          [{v:'Mengano', f:'<h4>Mengano</h4>'}, 'Pepe', '']
        */
        ]);

        var options = {
        	allowHtml:true,
        	allowCollapse: true,
        }

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, options);
      }
   </script>
<?php } ?>