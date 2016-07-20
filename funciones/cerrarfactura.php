<?php 
$fechainicierre=$_POST['fechainicierre'];
$fechafincierre=$_POST['fechafincierre'];
$clientecierre=$_POST['clientecierre'];
$montocierre=$_POST['montocierre'];

$con = mysqli_connect ("localhost","advv","cdavv210416","bdve210416");

$sql = "INSERT INTO historial (fechaini,fechafin,cliente,monto) VALUES ('$fechainicierre','$fechafincierre','$clientecierre','$montocierre')";
mysqli_query($con, $sql);
mysqli_close($con);

echo $fechainicierre.'<br>';
echo $fechafincierre.'<br>';
echo $clientecierre.'<br>';
echo $montocierre;
?>