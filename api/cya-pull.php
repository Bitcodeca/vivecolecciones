<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn  = new mysqli("localhost","adbddvc280118","cdadbddvc280118","vivebdd280118");
$result = $conn->query("SELECT * FROM vive_cya_con");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}

	    $outp .= '{"Usuario":"'.$rs["usuario"].'",';
	    $outp .= '"Id":"'.$rs["id"].'"}';
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
?>