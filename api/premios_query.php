<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","adbddvc280118","cdadbddvc280118","vivebdd280118");

$query= $_GET['query'];

$result = $conn->query("SELECT vive_fac_prem.id, vive_fac_prem.usuario, vive_fac_prem.cam, vive_fac_prem.nombre, vive_fac_prem.cantidad, vive_pre.tipo FROM vive_fac_prem JOIN vive_pre ON vive_fac_prem.nombre = vive_pre.articulo AND vive_fac_prem.cam = vive_pre.cam $query");

$outp = "";
$total = 0;
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}

	    $outp .= '{"usuario":"'.$rs["usuario"].'",';
		$outp .= '"id":"'.$rs["id"].'",';
		$outp .= '"cam":"'.$rs["cam"].'",';
		$outp .= '"nombre":"'.$rs["nombre"].'",';
		$outp .= '"cantidad":"'.$rs["cantidad"].'",';
	    $outp .= '"tipo":"'.$rs["tipo"].'"}';

	    $total= $total + $rs["cantidad"];
}
$outp ='{"records":['.$outp.'], "total":"'.$total.'" }';

$conn->close();
//$outp = $query;
echo($outp);
?>