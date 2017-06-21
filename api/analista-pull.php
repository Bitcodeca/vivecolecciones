<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$analista = $_GET['analista'];
$conn = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");
$result = $conn->query("SELECT * FROM vive_analista WHERE analista = '$analista'");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}

	    $outp .= '{"Analista":"'.$rs["analista"].'",';
	    $outp .= '"Gerente":"'.$rs["gerente"].'",';
	    $outp .= '"Id":"'.$rs["id"].'"}';
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>