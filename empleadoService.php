<?php
include("conexion.php");

$accion = $_GET['accion'];

if ($accion == "guardar") {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $puesto = $_POST['puesto'];

    $sql = "INSERT INTO empleado(nombre, cedula, telefono, correo, puesto) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $cedula, $telefono, $correo, $puesto);
    $stmt->execute();

    echo "Empleado guardado";
}

if ($accion == "listar") {
    $res = $conn->query("SELECT * FROM empleado");

    $data = [];

    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>