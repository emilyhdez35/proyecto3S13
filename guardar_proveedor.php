<?php
include("conexion.php");

$empresa = $_POST['empresa'];
$cedulaJuridica = $_POST['cedula'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$codInterno = $_POST['codInterno'];

$sql = "INSERT INTO proveedor (NombreEmpresa, cedulaJuridica, telefono, correo, direccion, codInterno) VALUES (?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $empresa, $cedulaJuridica, $telefono, $correo, $direccion, $codInterno);
$stmt->execute();

echo "Proveedor guardado";
?>