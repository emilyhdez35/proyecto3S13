<?php
include("conexion.php");

// Recibir datos
$numFactura = $_POST['numFactura'];
$tipoFactura = "cobrar"; // porque este formulario es por cobrar
$fechaEmision = $_POST['fechaEmision'];
$fechaVencimiento = $_POST['fechaVencimiento'];
$estado = $_POST['estadoFactura'];
$condicionVenta = $_POST['condicionVenta'];
$descripcion = $_POST['descripcion'];
$total = $_POST['totalFactura'];
$idCliente = $_POST['cliente'];

// servicios (JSON)
$listaServicios = $_POST['listaServicios'];
$servicios = json_decode($listaServicios, true);

// Insertar factura
$sql = "INSERT INTO factura 
(numFactura, tipoFactura, fechaEmision, fechaVencimiento, estado, condicionVenta, descripcion, montoTotal, id_cliente) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issssssdi", 
    $numFactura,
    $tipoFactura,
    $fechaEmision,
    $fechaVencimiento,
    $estado,
    $condicionVenta,
    $descripcion,
    $total,
    $idCliente
);

$stmt->execute();

// Obtener ID de la factura recién creada
$idFactura = $conn->insert_id;


// --------------------------------------
// ✅ GUARDAR DETALLE DE SERVICIOS
// --------------------------------------

$sqlDetalle = "INSERT INTO detalle_factura 
(idFactura, idServicio, cantidad, precio, subtotal) 
VALUES (?, ?, ?, ?, ?)";

$stmtDetalle = $conn->prepare($sqlDetalle);

foreach($servicios as $s){
    $idServicio = $s['id'];
    $cantidad = $s['cantidad'];
    $precio = $s['precio'];
    $subtotal = $s['subtotal'];

    $stmtDetalle->bind_param("iiidd",
        $idFactura,
        $idServicio,
        $cantidad,
        $precio,
        $subtotal
    );

    $stmtDetalle->execute();
}


echo "<script>
alert('Factura guardada correctamente');
window.location.href = 'facturaXpagar.php';
</script>";
?>