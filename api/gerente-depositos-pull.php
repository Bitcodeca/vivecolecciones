<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$mysqli  = new mysqli("localhost","adbddvc280118","cdadbddvc280118","vivebdd280118");

$gerente_logged=$_GET['usuario'];
$camact=$_GET['camact'];
$stmt = $mysqli->prepare('SELECT fecha, banco, referencia, monto, cam FROM vive_dep WHERE usuario = ? AND cam = ?');
$stmt->bind_param('ss', $gerente_logged, $camact);
$stmt->execute();
$stmt->bind_result($fecha, $banco, $referencia, $monto, $cam);
$stmt->store_result();
$outp = "";
while ($stmt->fetch()) {
	$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fecha);
	$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
	$fechaunixdep=strtotime($fechacambiadadep);
	$valor=number_format($monto, 2, ',', '.');
    if ($outp != "") {$outp .= ",";}

	    $outp .= '{"Fechaunix":"'.$fechaunixdep.'",';
		$outp .= '"Banco":"'.$banco.'",';
		$outp .= '"Fecha":"'.$fecha.'",';
		$outp .= '"Referencia":"'.$referencia.'",';
		$outp .= '"Monto":"'.$valor.'",';
	    $outp .= '"Cam":"'.$cam.'"}';

}
$outp ='{"records":['.$outp.']}';
$stmt->close();

$mysqli->close();

echo($outp);
?>