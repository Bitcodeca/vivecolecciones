<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","adbddvc280118","cdadbddvc280118","vivebdd280118");

$query= $_GET['id'];

$result = $conn->query("SELECT * FROM vive_fac_prem WHERE id=$query");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}

	    $outp .= '{"usuario":"'.$rs["usuario"].'",';
		$outp .= '"cam":"'.$rs["cam"].'",';
		$outp .= '"nombre":"'.$rs["nombre"].'",';
		$outp .= '"id":"'.$rs["id"].'",';
	    $outp .= '"cantidad":"'.$rs["cantidad"].'"}';

}
$outp ='{"records":['.$outp.']}';

$conn->close();
//$outp = $query;
echo($outp);
?>