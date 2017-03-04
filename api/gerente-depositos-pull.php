<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$mysqli = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");

$gerente_logged=$_GET['usuario'];
$stmt = $mysqli->prepare('SELECT fecha, banco, referencia, monto, cam FROM vive_dep WHERE usuario = ?');
$stmt->bind_param('s', $gerente_logged);
$stmt->execute();
$stmt->bind_result($fecha, $banco, $referencia, $monto, $cam);
$stmt->store_result();
$outp = "";
while ($stmt->fetch()) {
	$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fecha);
	$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
	$fechaunixdep=strtotime($fechacambiadadep);
	if (is_numeric($monto)){$valor=number_format($monto, 2, ',', '.');}
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