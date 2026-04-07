<?php
include("../conexion.php");

$accion = $_GET['accion'];

// GUARDAR SALARIO
if ($accion == "guardarSalario") {
    $id = $_POST['empleado'];
    $salario = $_POST['salario'];

    $sql = "INSERT INTO salario(id_empleado, salarioBase) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $id, $salario);
    $stmt->execute();

    echo "Salario guardado";
}

// GUARDAR PAGO
if ($accion == "guardarPago") {
    $id = $_POST['empleado'];
    $fecha = $_POST['fecha'];
    $monto = $_POST['monto'];
    $desc = $_POST['descripcion'];

    $sql = "INSERT INTO pago(id_empleado, fecha, monto, descripcion) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isds", $id, $fecha, $monto, $desc);
    $stmt->execute();

    echo "Pago registrado";
}

// CONSULTA PLANILLA
if ($accion == "listar") {
    $sql = "SELECT e.nombre, e.puesto, s.salarioBase, p.fecha, p.monto
            FROM empleado e
            LEFT JOIN salario s ON e.idempleado = s.id_empleado
            LEFT JOIN pago p ON e.idempleado = p.id_empleado
            ORDER BY e.nombre";

    $res = $conn->query($sql);

    $data = [];

    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>