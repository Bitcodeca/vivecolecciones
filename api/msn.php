<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost","adbddvc280118","cdadbddvc280118","vivebdd280118");
$usuario=$_GET['usuario'];
$logged=$_GET['logged'];
$result = $conn->query("SELECT * FROM vive_msn WHERE (ini='$usuario' AND fin='$logged') OR (ini='$logged' AND fin='$usuario') ORDER BY id ASC");

$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $msn=str_replace('"','`', $rs["msn"]);
    $msn=preg_replace('/[^A-Za-z0-9\-]/', ' ', $msn);
    if($rs['ini']==$usuario){$grid='col-xs-11 col-sm-10 left-align';$gridinner='bubble me';}else{$grid='col-xs-offset-1 col-xs-11 col-sm-offset-2 col-sm-10 right-align';$gridinner='bubble you';}
	    $outp .= '{"Grid":"'.$grid.'",';
		$outp .= '"Inner":"'.$gridinner.'",';
	    $outp .= '"Msn":"'.$msn.'"}';
}
$outp ='{"records":['.$outp.']}';


$stmt_ORDER = $conn->prepare("UPDATE vive_msn SET visto='Y' WHERE ini=? AND fin=? ");
$stmt_ORDER->bind_param("ss", $usuario, $logged);
$stmt_ORDER->execute();

$stmt_ORDER->close();

$conn->close();

echo($outp);
?>