<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?>
			<h1>ERROR DE CONEXIÓN</h1>
	    <?php } else { ?>

			<div class="container margintop25 marginbot25">
				<div class="row"> 		
		    		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		    			<h1 class="center-align margintop0">Inventario</h1>

			        	<?php
			        	$query2 = "SELECT art, id FROM vive_cam WHERE id IN ( SELECT DISTINCT art_id FROM vive_fac )";
						$result2 = mysqli_query($mysqli, $query2);
						if(mysqli_num_rows($result2) != 0) { 
							while($row2 = mysqli_fetch_assoc($result2)) {
								$id=$row2['id'];
								${$id}=$row2['art'];
							}
						}

						$query3 = "SELECT DISTINCT usuario from vive_fac ORDER BY usuario ASC";
						$result3 = mysqli_query($mysqli, $query3);
						if(mysqli_num_rows($result3) != 0) { ?>
							<ul class="collapsible popout" data-collapsible="expandable">
								<?php
								while($row3 = mysqli_fetch_assoc($result3)) {
									$usu=$row3['usuario'];
									$info=user_by_login($usu);
									?>
									<li>
										<div class="collapsible-header paddingtop5 paddingbot5">
											<h3 class="margintop0 marginbot0 marginleft25"><img src="<?php echo $info['avatarxs']; ?>" class="circle" height="48px" width="auto"><?php echo $usu; ?></h3>
										</div>
										<div class="collapsible-body white">
											<?php
											$query = "SELECT * from vive_fac WHERE usuario='$usu' ORDER BY cam";
											$result = mysqli_query($mysqli, $query);
											if(mysqli_num_rows($result) != 0) { ?>
												<table class="bordered striped centered highlight responsive-table">
											        <thead>
											          <tr>
											              <th class="padding0">Campaña</th>
											              <th class="padding0">Colección</th>
											              <th class="padding0">Cantidad</th>
											          </tr>
											        </thead>

											        <tbody><?php 
											        	$total=0;
														while($row = mysqli_fetch_assoc($result)) {
															$artid=$row['art_id'];
															$total=$total+$row['can'];
															?>
													        <tr>
													            <td class="paddingbot5 paddingtop5">
																	<p class="padding5 center-align"><?php echo $row['cam']; ?></p>
																</td>
													            <td class="paddingbot5 paddingtop5">
																	<p class="padding5 center-align"><?php echo ${$artid}; ?></p>
																</td>
													            <td class="paddingbot5 paddingtop5">
													            	<p class="padding5 center-align"><?php echo $row['can'] ?></p>
													            </td>
												            </tr>
															<?php
														} ?>
														<tr>
												            <td class="paddingbot5 paddingtop5">
																<p class="padding5 center-align"></p>
															</td>
												            <td class="paddingbot5 paddingtop5">
																<p class="padding5 center-align"></p>
															</td>
												            <td class="paddingbot5 paddingtop5">
												            	<p class="padding5 center-align bold">Total <?php echo $total; ?></p>
												            </td>
														</tr>
											        </tbody>
											    </table> <?php											
											}
											?>
										</div>
									</li> <?php
								} ?>
							</ul> <?php
						} ?>
					</div>
				</div>
			</div>
	    <?php }
	} else{ ?>
		<h1> ACCESO NEGADO </h1>
	<?php	}  ?>
<?php } else {  
		header("Location: http://app.vivecolecciones.com.ve/"); /* Redirect browser */
		exit(); 
 } get_footer(); ?>
<script>
	jQuery(document).ready(function(){
		jQuery('.collapsible').collapsible();
	});
</script>