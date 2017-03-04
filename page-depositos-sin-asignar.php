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
					     	<h1 class="center-align">Depósitos sin asignar</h1>





<?php
if(isset($_POST['btn'])){
	$iddep=$_POST['id'];
	$query2 = "DELETE FROM vive_dep WHERE id=$iddep";
	if ($mysqli->query( $query2 ) === TRUE) { ?>
		<div id="<?php echo $iddep; ?>" class="modal">
			<div class="modal-content">
				<h4>DEPÓSITO BORRADO</h4>
			</div>
			<div class="modal-footer">
				<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">Cerrar</a>
			</div>
		</div> 
	<?php }
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
$query = "SELECT * FROM vive_dep WHERE usuario='vacio' LIMIT $start_from, $per_page";
$result = mysqli_query ($con, $query);

?>
  <table class="striped responsive-table">
        <thead>
          <tr>
              <th data-field="id">Fecha</th>
              <th data-field="name">Banco</th>
              <th data-field="price">Referencia</th>
              <th data-field="price">Monto</th>
              <th data-field="price">Acción</th>
          </tr>
        </thead>

        <tbody>

<?php
while ($row = mysqli_fetch_assoc($result)) {
?>
    <tr>
        <td><?php echo $row['fecha']; ?></td>
        <td><?php echo $row['banco']; ?></td>
        <td><?php echo $row['referencia']; ?></td>
        <td>Bsf <?php if (is_numeric($row['monto'])){$valor=formato($row['monto']); echo $valor;}else{echo $row['monto'];} ?></td>
        <td>
        	<a class="btn hoverable fondo5 waves-effect waves-light btn-radius" href="#<?php echo $row['id']; ?>">Borrar</a>
		</td>
    </tr>
	<div id="<?php echo $row['id']; ?>" class="modal">
		<div class="modal-content">
			<h4>ADVERTENCIA</h4>
			<h5>¿Desea eliminar depósito? </h5>
			<p><?php echo $row['fecha']; ?></p>
	        <p><?php echo $row['banco']; ?></p>
	        <p><?php echo $row['referencia']; ?></p>
	        <p>Bsf <?php if (is_numeric($row['monto'])){$valor=formato($row['monto']); echo $valor;}else{echo $row['monto'];} ?></p>
		</div>
		<div class="modal-footer">
			<form role="form" method="post" name="<?php echo $row['id']; ?>" action="" >
				<button  type="submit" name="btn" id="btn" value="borrar" class="btn hoverable fondo5 waves-effect waves-light btn-radius" type="submit">
					<i class="material-icons left">cancel</i>
						BORRAR DEPÓSITO
				</button>
				<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
	    	</form>
			<a href="#!" class=" modal-action modal-close btn hoverable fondo3 waves-effect waves-light btn-radius">CANCELAR</a>
		</div>
	</div>
<?php
};
?>
        </tbody>
      </table>

<div>
<?php

//Now select all from table
$query = "select * from vive_dep WHERE usuario='vacio'";
$result = mysqli_query($con, $query);

// Count the total records
$total_records = mysqli_num_rows($result);

//Using ceil function to divide the total records on per page
$total_pages = ceil($total_records / $per_page);

//Going to first page

echo '<ul class="pagination">';
echo "<li><a href='http://app.vivecolecciones.com.ve/depositos-sin-asignar/?page=1'>".'Primera página'."</a></li>";

for ($i=1; $i<=$total_pages; $i++) {
	if($ultimo==$i){$clase='active';}else{$clase='';}
echo "<li class='waves-effect ".$clase."'><a href='http://app.vivecolecciones.com.ve/depositos-sin-asignar/?page=".$i."'>".$i."</a></li>";
};
// Going to last page
echo "<li><a href='http://app.vivecolecciones.com.ve/depositos-sin-asignar/?page=".$total_pages."'>".'Última página'."</a></li>";
echo '</ul>';

?>

</div>








						</div>
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
	    jQuery('.modal').modal();
	});
</script>
<?php
	if(isset($_POST['btn'])){ ?>
		<script>
			  jQuery(document).ready(function(){
			    jQuery('#<?php echo $iddep; ?>').modal('open');
			  });
		</script>
	<?php
	}
?>