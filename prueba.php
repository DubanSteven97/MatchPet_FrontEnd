<?php

$conexion= new PDO("sqlsrv:server=DESKTOP-UIAKGPT;database=DBMatchpet","root","123456");


$consulta=$conexion->prepare("SELECT * FROM Animal");
$consulta->execute();
$datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
var_dump($datos);
$strPassword = hash("SHA256", "123456");



echo("Aqui.". $strPassword)
?>