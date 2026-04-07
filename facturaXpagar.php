<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas por Pagar</title>
    <link rel="stylesheet" href="css/facturas.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<header id="header">
    <img src="img/LogoSample_ByTailorBrands.jpg" alt="logo" id="logo">

    <nav class="menu">
        <a href="inicio.html">Inicio</a>
        <a href="flujoDeCaja.html">Flujo de Caja</a>
        <a href="login.html">Iniciar Sesión</a>
        <a href="generarCodigos.php">Generar códigos</a>
        <a href="facturaXcobrar.php">Facturas por Cobrar</a>
        <a href="facturaXpagar.php">Facturas por Pagar</a>
        <a href="empleados.html">Empleados</a>
        <a href="planilla.html">Planilla</a>
    </nav>

    <div class="ubicacion">
        <i class="fa-solid fa-location-dot"></i>
        <p>Costa Rica</p>

    </div>

</header>

<body>
    <?php
    include("conexion.php");
    include("auth.php");

    $sqlProductos = "SELECT id, nombre, precio FROM productos";
    $resProductos = $conn->query($sqlProductos);
    ?>

    <h1>Facturas por pagar</h1>
    <form action="factura_productos.php" method="POST">

    <label>Número de factura:</label>
    <input type="number" name="numFactura"><br><br>


    <label>Fecha de emisión:</label>
    <input type="date" id="fechaE" name="fechaEmision"><br><br>

    <script>
        document.getElementById("fechaE").value = new Date().toISOString().split('T')[0];
    </script>

    <label>Fecha de vencimiento:</label>
    <input type="date" id="fechaV" name="fechaVencimiento" min="2020-01-01"><br><br>

    <label>Estado:</label>
    <select name="estadoFactura" required>
        <option value="">Seleccione</option>
        <option value="pendiente">Pendiente</option>
        <option value="pagada">Pagada</option>
        <option value="vencida">Vencida</option>
    </select><br><br>

    <label>Condición de venta:</label>
    <select name="condicionVenta" required>
        <option value="">Seleccione</option>
        <option value="credito">Crédito</option>
        <option value="contado">Contado</option>
    </select><br><br>

    <label>Descripción:</label>
    <input type="text" name="descripcion"><br><br>

    <label>Proveedor:</label>
    <input type="text" id="buscarProveedor" placeholder="Buscar proveedor...">
    <input type="hidden" name="proveedor" id="proveedorId">

    <div id="resultadosProveedor"></div><br><br>

    <label>Producto:</label>
    <select id="producto">
    <option value="">Seleccione</option>

    <?php while($p = $resProductos->fetch_assoc()){ ?>
        <option value="<?php echo $p['precio']; ?>" 
                data-id="<?php echo $p['id']; ?>">
            <?php echo $p['nombre'] . " - ₡" . $p['precio']; ?>
        </option>
    <?php } ?>
</select>

<label>Cantidad:</label>
<input type="number" id="cantidadProducto" min="1" value="1">

<button type="button" onclick="agregarProducto()">Agregar</button>

<h3>Productos agregados</h3>

<table border="1" id="tablaProductos">
<tr>
    <th>Producto</th>
    <th>Precio</th>
    <th>Cantidad</th>
    <th>Subtotal</th>
    <th>Acción</th>
</tr>
</table><br><br>

<input type="hidden" name="listaProductos" id="listaProductos"><br><br>

   <label>Subtotal:</label>
<input type="number" id="subtotalFactura" readonly><br><br>

<label>IVA (13%):</label>
<input type="number" id="impuestoFactura" readonly><br><br>

<label>Total:</label>
<input type="number" name="totalFactura" id="totalFactura" readonly><br><br>

    <br><br>
    <button type="submit">Generar factura</button>
    </form>

    <h2>Facturas registradas</h2>

<?php
$sqlFacturas = "SELECT f.idfactura, f.numFactura, f.fechaEmision, f.montoTotal, p.nombreEmpresa 
                FROM factura f
                JOIN proveedor p ON f.id_proveedor = p.idproveedor
                ORDER BY f.idfactura DESC";

$resFacturas = $conn->query($sqlFacturas);
?>

<table border="1">
<tr>
    <th>N° Factura</th>
    <th>Proveedor</th>
    <th>Fecha</th>
    <th>Total</th>
    <th>Acción</th>
</tr>

<?php while($f = $resFacturas->fetch_assoc()){ ?>
<tr>
    <td><?php echo $f['numFactura']; ?></td>
    <td><?php echo $f['nombreEmpresa']; ?></td>
    <td><?php echo $f['fechaEmision']; ?></td>
    <td>₡<?php echo $f['montoTotal']; ?></td>
    <td>
        <a href="ver_factura_producto.php?id=<?php echo $f['idfactura']; ?>">
            <button type="button">Ver</button>
        </a>
    </td>
</tr>
<?php } ?>
</table>


<!--BUSCAR PROVEEDOR EN BD-->
<script>
document.getElementById("buscarProveedor").addEventListener("keyup", function(){
    let valor1 = this.value;

    if(valor1.length > 1){
        fetch("buscar.php?dato=" + valor1 + "&tipo=proveedor")
        .then(res => res.text())
        .then(data => {
            document.getElementById("resultadosProveedor").innerHTML = data;
        });
    } else {
        document.getElementById("resultadosProveedor").innerHTML = "";
    }
});

function seleccionarProveedor(id, nombre){
    document.getElementById("buscarProveedor").value = nombre;
    document.getElementById("proveedorId").value = id;
    document.getElementById("resultadosProveedor").innerHTML = "";
}
</script>

<!--AGREGAR PRODUCTOS A TABLA-->
<script>
let productos = [];
let total = 0;
let impuesto = 0;
let totalFinal = 0;


function agregarProducto(){
    let select = document.getElementById("producto");
    let cantidadInput = document.getElementById("cantidadProducto");

    let opcion = select.options[select.selectedIndex];
    let nombre = opcion.text;
    let precio = parseInt(opcion.value);
    let id = opcion.getAttribute("data-id");
    let cantidad = parseInt(cantidadInput.value);

    if(!precio || cantidad <= 0) return;

    // evitar duplicados
    let existente = productos.find(p => p.id == id);

    if(existente){
        existente.cantidad += cantidad;
        existente.subtotal = existente.cantidad * existente.precio;
    } else {
        productos.push({
            id: id,
            nombre: nombre,
            precio: precio,
            cantidad: cantidad,
            subtotal: precio * cantidad
        });
    }

    actualizarTablaProductos();
    cantidadInput.value = 1;
}
</script>

<!--ACTUALIZAR TABLA PRODUCTOS-->
<script>
function actualizarTablaProductos(){
    let tabla = document.getElementById("tablaProductos");

    tabla.innerHTML = `
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acción</th>
        </tr>
    `;

    total = 0;

    productos.forEach((p, index) => {
        let fila = tabla.insertRow();

        fila.insertCell(0).innerText = p.nombre;
        fila.insertCell(1).innerText = "₡" + p.precio;
        fila.insertCell(2).innerText = p.cantidad;
        fila.insertCell(3).innerText = "₡" + p.subtotal;

        let btn = document.createElement("button");
        btn.innerText = "Eliminar";
        btn.type = "button";

        btn.onclick = function(){
            eliminarProducto(index);
        };

        fila.insertCell(4).appendChild(btn);

        total += p.subtotal;
    });

    // guardar lista para PHP
   // calcular impuesto (13%)
    impuesto = total * 0.13;

    // total final
    totalFinal = total + impuesto;

    // mostrar en inputs
    document.getElementById("subtotalFactura").value = total;
    document.getElementById("impuestoFactura").value = impuesto;
    document.getElementById("totalFactura").value = totalFinal;
    document.getElementById("listaProductos").value = JSON.stringify(productos);
}
</script>

<!--ELIMINAR PRODUCTO-->
<script>
function eliminarProducto(index){
    productos.splice(index, 1);
    actualizarTablaProductos();
}
</script>

</body>


</html>