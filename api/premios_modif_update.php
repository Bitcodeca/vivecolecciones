<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","adbddvc280118","cdadbddvc280118","vivebdd280118");

$query= $_GET['query'];

$result = $conn->query("UPDATE vive_fac_prem SET $query");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
}
$outp ='{"records":['.$outp.']}';

$conn->close();
//$outp = $query;
echo($outp);
?>