<?php
include("conexion.php");

// -------------------------
// 📥 RECIBIR DATOS
// -------------------------
$numFactura = $_POST['numFactura'];
$tipoFactura = "pagar"; // o "cobrar" según tu módulo
$fechaEmision = $_POST['fechaEmision'];
$fechaVencimiento = $_POST['fechaVencimiento'];
$estado = $_POST['estadoFactura'];
$condicionVenta = $_POST['condicionVenta'];
$descripcion = $_POST['descripcion'];
$idProveedor = $_POST['proveedor']; // importante aquí

// productos (JSON)
$listaProductos = $_POST['listaProductos'];
$productos = json_decode($listaProductos, true);

// -------------------------
// 🧮 CALCULAR TOTALES (BACKEND)
// -------------------------
$subtotal = 0;

foreach($productos as $p){
    $subtotal += $p['subtotal'];
}

$impuesto = $subtotal * 0.13;
$total = $subtotal + $impuesto;

// -------------------------
// 🧾 INSERTAR FACTURA
// -------------------------
$sql = "INSERT INTO factura 
(numFactura, tipoFactura, fechaEmision, fechaVencimiento, estado, condicionVenta, descripcion, montoTotal, id_proveedor) 
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
    $idProveedor
);

$stmt->execute();

// obtener ID generado
$idFactura = $conn->insert_id;

// -------------------------
// 📦 DETALLE DE PRODUCTOS
// -------------------------
$sqlDetalle = "INSERT INTO detalle_factura 
(idFactura, idProducto, cantidad, precio, subtotal) 
VALUES (?, ?, ?, ?, ?)";

$stmtDetalle = $conn->prepare($sqlDetalle);

foreach($productos as $p){

    $idProducto = $p['id'];
    $cantidad = $p['cantidad'];
    $precio = $p['precio'];
    $subtotal = $p['subtotal'];

    $stmtDetalle->bind_param("iiidd",
        $idFactura,
        $idProducto,
        $cantidad,
        $precio,
        $subtotal
    );

    $stmtDetalle->execute();
}

echo "<script>
alert('Factura guardada correctamente');
window.location.href = 'facturaXcobrar.php';
</script>";
?>