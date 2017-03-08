<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$mysqli = new mysqli("localhost","bitcode_bitvcv2","IRV$#eTDk]u4","bitcode_vcv2150117");

$gerente_logged=$_GET['usuario'];
$stmt = $mysqli->prepare('SELECT status, fecha, banco, referencia, monto, cam, comentario FROM vive_pen WHERE usuario = ?');
$stmt->bind_param('s', $gerente_logged);
$stmt->execute();
$stmt->bind_result($status, $fecha, $banco, $referencia, $monto, $cam, $comentario);
$stmt->store_result();
$outp = "";
while ($stmt->fetch()) {
	if($status=='aprobado'){$clase='fondo3';}elseif($status=='vacio'){$clase='grey lighten-5';}elseif($status=='pendiente'){$clase='yellow';}elseif($status=='negado'){$clase='fondo5';}
	$fechacambiadadep = DateTime::createFromFormat("d/m/Y", $fecha);
	$fechacambiadadep=date_format($fechacambiadadep,"d-m-Y");
	$fechaunixdep=strtotime($fechacambiadadep);
	$valor=number_format($monto, 2, ',', '.');
    if ($outp != "") {$outp .= ",";}

	    $outp .= '{"Fechaunix":"'.$fechaunixdep.'",';
		$outp .= '"Banco":"'.$banco.'",';
		$outp .= '"Fecha":"'.$fecha.'",';
		$outp .= '"Clase":"'.$clase.'",';
		$outp .= '"Referencia":"'.$referencia.'",';
		$outp .= '"Monto":"'.$valor.'",';
		$outp .= '"Cam":"'.$cam.'",';
		$outp .= '"Status":"'.$status.'",';
	    $outp .= '"Comentario":"'.$comentario.'"}';

}
$outp ='{"records":['.$outp.']}';
$stmt->close();

$mysqli->close();

echo($outp);
?>