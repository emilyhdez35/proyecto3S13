<?php
include("conexion.php");

$idFactura = $_GET['id'];

// 🔹 Obtener datos de la factura
$sql = "SELECT f.*, c.nombre, c.correo, c.direccion
        FROM factura f
        JOIN cliente c ON f.id_cliente = c.idcliente
        WHERE f.idfactura = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idFactura);
$stmt->execute();
$res = $stmt->get_result();
$factura = $res->fetch_assoc();

// 🔹 Obtener detalle
$sqlDetalle = "SELECT d.*, s.nombre 
               FROM detalle_factura d
               JOIN servicios s ON d.idServicio = s.idservicios
               WHERE d.idFactura = ?";

$stmtD = $conn->prepare($sqlDetalle);
$stmtD->bind_param("i", $idFactura);
$stmtD->execute();
$resD = $stmtD->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Detalle Factura</title>

<style>
body{font-family:Arial; margin:40px;}
.factura{border:1px solid #000; padding:20px; width:600px;}
table{width:100%; border-collapse:collapse;}
table,th,td{border:1px solid black; padding:8px;}
</style>

</head>
<body>

<div class="factura">

<h1>Factura #<?php echo $factura['numFactura']; ?></h1>

<h3>Cliente</h3>
<p><?php echo $factura['nombre']; ?></p>
<p><?php echo $factura['correo']; ?></p>
<p><?php echo $factura['direccion']; ?></p>

<p><strong>Fecha:</strong> <?php echo $factura['fechaEmision']; ?></p>
<p><strong>Estado:</strong> <?php echo $factura['estado']; ?></p>

<h3>Detalle:</h3>

<table>
<tr>
    <th>Servicio</th>
    <th>Precio</th>
    <th>Cantidad</th>
    <th>Subtotal</th>
</tr>

<?php while($d = $resD->fetch_assoc()){ ?>
<tr>
    <td><?php echo $d['nombre']; ?></td>
    <td>₡<?php echo $d['precio']; ?></td>
    <td><?php echo $d['cantidad']; ?></td>
    <td>₡<?php echo $d['subtotal']; ?></td>
</tr>
<?php } ?>

</table>

<h2>Total: ₡<?php echo $factura['montoTotal']; ?></h2>

<button onclick="window.print()">Imprimir</button>

</div>

</body>
</html>