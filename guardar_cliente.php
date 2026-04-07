<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$cedula = $_POST['cedula'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];

$sql = "INSERT INTO cliente (nombre, cedula, correo, telefono, direccion) VALUES (?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombre, $cedula, $correo, $telefono, $direccion);
$stmt->execute();

echo "Cliente guardado";
?>