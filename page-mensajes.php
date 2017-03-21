<?php get_header();
if ( is_user_logged_in() ) {
	$user_logged=user_logged();
	if($user_logged['rol']=='administrator'){
	    require_once 'api/vive-db.php';
	    if (mysqli_connect_errno()) { ?> <h1>ERROR DE CONEXIÓN</h1> <?php }
	    else {
	    	if(isset($_POST['btn'])){
	    		$msn=$_POST['msn'];
	    		$logged=$user_logged['login'];
	    		$gerentes=usuarioPorRol('Gerente');
	    		foreach ($gerentes as $value) {
	    			$usuario=$value['login'];
	    			$query="INSERT INTO  vive_msn ( ini, fin, msn ) VALUES ( '$logged', '$usuario', '$msn' )";

			        if( $mysqli->query( $query ) ){
			        } else{
			        }

					if ($result = $mysqli->query("SELECT * FROM vive_msn WHERE (ini='$usuario' AND fin='$logged') OR (ini='$logged' AND fin='$usuario')")) {
						$cantmsn = mysqli_num_rows($result);
						if($cantmsn>=21){
							$borrar=$cantmsn-20;
							$query="DELETE FROM vive_msn WHERE (ini='$usuario' AND fin='$logged') OR (ini='$logged' AND fin='$usuario') ORDER BY id asc limit $borrar";
					        if( $mysqli->query( $query ) ){
					        }
						}
					}
	    		}
	    		?>
					<script>
						jQuery(document).ready(function() {
						    alert('Cadena Enviada');
						});
					</script>
	    		<?php
    		} ?>

			<div class="container margintop25 marginbot25">	
	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable">
					     	<h1 class="center-align">Chat</h1>
	
							<div class="row">
								<div class="col-xs-12 col-sm-4 col-sm-offset-4">
									<div class="input-field">
										<select class="icons" name="usuario" id="usuario">
											<option value="" disabled selected>Selecciona el Usuario</option>
									        	<?php
									        		$todoslosusuarios = get_users();
													foreach ( $todoslosusuarios as $user ) {
														$buscar=$user->user_login;
														if($buscar!=$user_logged['login']){
															preg_match('/src="(.*?)"/i', get_avatar( $user->id, 32 ), $fotoxs );
															$foto = $fotoxs[1]; ?>
															<option data-icon="<?php echo $foto; ?>" value="<?php echo $buscar; ?>"><?php echo $buscar; ?></option>
													<?php }
													}
												?>
											<label>Seleccionar</label>
										</select>
									</div>
								</div>
							</div>

							<hr />

							<div class="row">
								<div class="col-xs-12 center-align">
									<a class="waves-effect waves-light btn hoverable fondo3 btn-radius" href="#modal1"><i class="material-icons left">email</i>ENVIAR MENSAJE CADENA</a>

									<div id="modal1" class="modal">
										<div class="modal-content">
											<h1>Mensaje para todos los Gerentes</h1>
											<form name="importa" method="post" >
												<div class="input-field col-xs-8 col-sm-10 col-md-11 chat">
													<textarea id="msn" name="msn" class="materialize-textarea" length="500"></textarea>
													<label for="msn"></label>
												</div>
												<div class="col-xs-4 col-sm-2 col-md-1 right-align">
													<button type="submit" value="siguiente" id="btn" name="btn" class="btn btn-radius margintop25 fondo3 waves-effect waves-light">
														<i class="material-icons medium">send</i>
													</button>
												</div>
											</form>
										</div>
										<div class="modal-footer">
											<a href="#!" class="btn btn-radius fondo5 modal-action modal-close waves-effect waves-green hoverable"><i class="material-icons left">clear</i> CANCELAR</a>
										</div>
									</div>

								</div>
							</div>

						</div>
					</div>
				</div>


	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable" id="notificacionesmsn">
					     	<h1 class="center-align">Notificaciones</h1>
					     	<?php
							$stmt = $mysqli->prepare('SELECT ini, msn FROM vive_msn WHERE fin = ? AND visto="N" GROUP BY (ini)');
							$stmt->bind_param('s', $user_logged['login']);
							$stmt->execute();
							$stmt->bind_result($ini, $msn);
							$stmt->store_result();
						    while ($stmt->fetch()) {
						    	$avatar=user_by_login($ini);
						    	?>
						    	<div class="row" >
							    	<div class="col-xs-12 ">
						    			<a id="<?php echo $ini; ?>" class="black-text pointer" >
								    		<h5 class="truncate">
										    	<div class="chip">
												    <img src="<?php echo $avatar['avatarxs']; ?>" alt="Contact Person">
												    <?php echo $ini; ?>
												</div>
												<?php echo $msn; ?>
											</h5>
										</a>
									</div>
								</div>
								<?php
						    }
						    ?>
						</div>
					</div>
				</div>

	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable" id="notificacionesmsn">
					     	<h1 class="center-align">Conversaciones abiertas</h1>
					     	<?php
							$stmt = $mysqli->prepare('SELECT ini FROM vive_msn WHERE fin = ? GROUP BY (ini)');
							$stmt->bind_param('s', $user_logged['login']);
							$stmt->execute();
							$stmt->bind_result($ini);
							$stmt->store_result();
						    while ($stmt->fetch()) {
						    	$avatar=user_by_login($ini);
						    	?>
				    			<a id="<?php echo $ini; ?>" class="black-text pointer" >
								    	<div class="chip">
										    <img src="<?php echo $avatar['avatarxs']; ?>" alt="Contact Person">
										    <?php echo $ini; ?>
										</div>
								</a>
								<?php
						    }
						    ?>
						</div>
					</div>
				</div>

			</div>
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
					     	<h1 class="center-align">Chat</h1>

							<div class="row">
								<div class="col-xs-12 col-sm-4 col-sm-offset-4">
									<div class="input-field">
										<select class="icons" name="usuario" id="usuario">
											<option value="" disabled selected>Selecciona el Usuario</option>
												<?php
													$stmt = $mysqli->prepare('SELECT ger, sub FROM vive_sub WHERE ger = ? OR sub= ?');
													$stmt->bind_param('ss', $gerente_logged, $gerente_logged);
													$stmt->execute();
													$stmt->bind_result($ger, $sub);
													$stmt->store_result();
												    while ($stmt->fetch()) {
												    	if($ger==$gerente_logged){
												    		$variable=user_by_login($sub);
												    		?>
															<option data-icon="<?php echo $variable['avatarxs']; ?>" value="<?php echo $sub; ?>"><?php echo $variable['nombre'].' '.$variable['apellido']; ?></option>
															<?php
												    	}else{
												    		$variable=user_by_login($ger);
												    		?>
															<option data-icon="<?php echo $variable['avatarxs']; ?>" value="<?php echo $ger; ?>"><?php echo $variable['nombre'].' '.$variable['apellido']; ?></option>
															<?php
												    	}
												    }
													$stmt->close();
													$prueba=usuarioPorRol('administrator');
													foreach ($prueba as $admin) {
											    		?>
														<option data-icon="<?php echo $admin['avatarxs']; ?>" value="<?php echo $admin['login']; ?>"><?php echo $admin['nombre'].' '.$admin['apellido']; ?></option>
														<?php
													}
												?>
											<label>Seleccionar</label>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable" id="notificacionesmsn">
					     	<h1 class="center-align">Notificaciones</h1>
					     	<?php
							$stmt = $mysqli->prepare('SELECT ini, msn FROM vive_msn WHERE fin = ? AND visto="N" GROUP BY (ini)');
							$stmt->bind_param('s', $user_logged['login']);
							$stmt->execute();
							$stmt->bind_result($ini, $msn);
							$stmt->store_result();
						    while ($stmt->fetch()) {
						    	$avatar=user_by_login($ini);
						    	?>
						    	<div class="row" >
							    	<div class="col-xs-12 ">
						    			<a id="<?php echo $ini; ?>" class="black-text pointer" >
								    		<h5 class="truncate">
										    	<div class="chip">
												    <img src="<?php echo $avatar['avatarxs']; ?>" alt="Contact Person">
												    <?php echo $ini; ?>
												</div>
												<?php echo $msn; ?>
											</h5>
										</a>
									</div>
								</div>
								<?php
						    }
						    ?>
						</div>
					</div>
				</div>

	    		<div class="row">
					<div class="col-md-12">
						<div class="card-panel z-depth-2 hoverable" id="notificacionesmsn">
					     	<h1 class="center-align">Conversaciones abiertas</h1>
					     	<?php
							$stmt = $mysqli->prepare('SELECT ini FROM vive_msn WHERE fin = ? GROUP BY (ini)');
							$stmt->bind_param('s', $user_logged['login']);
							$stmt->execute();
							$stmt->bind_result($ini);
							$stmt->store_result();
						    while ($stmt->fetch()) {
						    	$avatar=user_by_login($ini);
						    	?>
				    			<a id="<?php echo $ini; ?>" class="black-text pointer" >
								    	<div class="chip">
										    <img src="<?php echo $avatar['avatarxs']; ?>" alt="Contact Person">
										    <?php echo $ini; ?>
										</div>
								</a>
								<?php
						    }
						    ?>
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
<script>
	jQuery(document).ready(function() {
	    jQuery('select').material_select();
	    jQuery('.modal').modal();
 		jQuery('textarea#msn').characterCounter();
	});
	
	jQuery( "select" ).change(function() {
		sessionStorage.setItem("sent", this.value); 
		window.open('http://app.vivecolecciones.com.ve/chat/','window','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no');
	});

	jQuery("#notificacionesmsn a").click(function() {
		var a=jQuery(this).attr('id');
		sessionStorage.setItem("sent", a); 
		window.open('http://app.vivecolecciones.com.ve/chat/','window','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no');
	});
</script>