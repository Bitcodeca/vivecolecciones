<?php
	$d = DateTime::createFromFormat("d/m/Y", $fecha);
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c1=date_format($d,"d/m/Y");
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c2=date_format($d,"d/m/Y");
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c3=date_format($d,"d/m/Y");
	date_add($d,date_interval_create_from_date_string("15 days"));
	$c4=date_format($d,"d/m/Y");
?>