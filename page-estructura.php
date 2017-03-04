<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?> <h1>ERROR DE CONEXIÓN</h1> <?php }
	    else { ?>
	    <?php }
	    
	}  elseif ($user_logged['rol']=='Gerente') {
		require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php
	    }
	    else {
			$gerente_logged=$user_logged["login"]; ?>
			<div class="container margintop25 marginbot25">	
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Estructura</h1>

							<div id="chart_div"></div>

						</div>
					</div>
				</div>
			</div>
			<?php 
		}
	}  ?>
<?php } else {  
		header("Location: http://app.vivecolecciones.com.ve/");
		exit(); 
 } get_footer(); ?>
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
	    		//$variable=user_by_login($gerente_logged);
				//echo "[{v:'". $gerente_logged ."', f:'<h4>". $variable['nombre'].' '.$variable['apellido'] ."</h4>'}, '', ''],";
				$stmt = $mysqli->prepare('SELECT ger, sub FROM vive_sub WHERE sub= ? OR ger=?');
				$stmt->bind_param('ss', $gerente_logged, $gerente_logged);
				$stmt->execute();
				$stmt->bind_result($ger, $sub);
				$stmt->store_result();
			    while ($stmt->fetch()) {
			    	if($sub==$gerente_logged){
			    		$variable2=user_by_login($ger);
			    		$variable=user_by_login($sub);
						echo "[{v:'". $ger ."', f:'<h4>". $variable2['nombre'].' '.$variable2['apellido'] ."</h4>'}, '', ''],";
						echo "[{v:'". $sub ."', f:'<h4>". $variable['nombre'].' '.$variable['apellido'] ."</h4>'}, '".$ger."', ''],";
					}
					else{
			    		$variable=user_by_login($sub);
						echo "[{v:'". $sub ."', f:'<h4>". $variable['nombre'].' '.$variable['apellido'] ."</h4>'}, '".$ger."', ''],";
					}
			    }
				$stmt->close();
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

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {allowHtml:true});
      }
   </script>