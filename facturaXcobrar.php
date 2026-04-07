<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas</title>
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
    //include("auth.php");

    $sql = "SELECT idcliente, nombre FROM cliente";
    $resultado = $conn->query($sql);

    $sqlServicios = "SELECT idservicios, nombre, precio FROM servicios";
    $resServicios = $conn->query($sqlServicios);
    ?>

    <h1>Facturas por cobrar</h1>
    <form action="factura.php" method="POST">

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

        <label>Cliente:</label>
        <input type="text" id="buscarCliente" placeholder="Buscar cliente...">
        <input type="hidden" name="cliente" id="clienteId">

        <div id="resultadosC"></div><br><br>

        <input type="hidden" name="">
        <input type="hidden" name="correoCliente">
        <input type="hidden" name="direccionCliente">


        <label>Servicio:</label>
        <select id="servicio">
            <option value="">Seleccione</option>

            <?php while ($s = $resServicios->fetch_assoc()) { ?>
                <option value="<?php echo $s['precio']; ?>" data-id="<?php echo $s['idservicios']; ?>">
                    <?php echo $s['nombre'] . " - ₡" . $s['precio']; ?>
                </option>
            <?php } ?>

        </select>
        <label>Cantidad:</label>
        <input type="number" id="cantidad" min="1" value="1">

        <button type="button" onclick="agregarServicio()">Agregar</button>


        <h3>Servicios agregados</h3>
        <table border="1" id="tablaServicios">
            <tr>
                <th>Servicio</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
        </table><br><br>

        <input type="hidden" name="listaServicios" id="listaServicios">


        <label>Monto Total:</label>
        <input type="number" name="totalFactura" id="totalFactura" readonly><br><br>

        <br><br>
        <button type="submit">Generar factura</button>
    </form>


    <!--LISTA FACTURAS REGISTRADAS-->
    <h2>Facturas registradas</h2>

    <?php
    $sqlFacturas = "SELECT f.idfactura, f.numFactura, f.fechaEmision, f.montoTotal, c.nombre 
                FROM factura f
                JOIN cliente c ON f.id_cliente = c.idcliente
                ORDER BY f.idfactura DESC";

    $resFacturas = $conn->query($sqlFacturas);
    ?>

    <table border="1">
        <tr>
            <th>N° Factura</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Acción</th>
        </tr>

        <?php while ($f = $resFacturas->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $f['numFactura']; ?></td>
                <td><?php echo $f['nombre']; ?></td>
                <td><?php echo $f['fechaEmision']; ?></td>
                <td>₡<?php echo $f['montoTotal']; ?></td>
                <td>
                    <a href="ver_factura.php?id=<?php echo $f['idfactura']; ?>">
                        <button type="button">Ver</button>
                    </a>
                </td>
            </tr>
        <?php } ?>

    </table>

    <!--BUSCAR CLIENTE EN BD-->
    <script>
        document.getElementById("buscarCliente").addEventListener("keyup", function () {
            let valor = this.value;

            if (valor.length > 1) {
                fetch("buscar.php?dato=" + valor + "&tipo=cliente")
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById("resultadosC").innerHTML = data;
                    });
            } else {
                document.getElementById("resultadosC").innerHTML = "";
            }
        });

        function seleccionarCliente(id, nombre) {
            document.getElementById("buscarCliente").value = nombre;
            document.getElementById("clienteId").value = id;
            document.getElementById("resultadosC").innerHTML = "";
        }
    </script>

    <!--AGREGAR SERVICIOS Y PRECIOS A TABLA-->
    <script>
        let total = 0;
        let servicios = [];

        function agregarServicio() {
            let select = document.getElementById("servicio");
            let cantidadInput = document.getElementById("cantidad");

            let opcion = select.options[select.selectedIndex];
            let nombre = opcion.text;
            let precio = parseInt(opcion.value);
            let id = opcion.getAttribute("data-id");
            let cantidad = parseInt(cantidadInput.value);

            if (!precio || cantidad <= 0) return;

            // 🔍 Buscar si ya existe
            let existente = servicios.find(s => s.id == id);

            if (existente) {
                // ✔ actualizar cantidad
                existente.cantidad += cantidad;
                existente.subtotal = existente.cantidad * existente.precio;

            } else {
                // ✔ agregar nuevo
                servicios.push({
                    id: id,
                    nombre: nombre,
                    precio: precio,
                    cantidad: cantidad,
                    subtotal: precio * cantidad
                });
            }

            // 🔄 reconstruir tabla
            actualizarTabla();

            // reset cantidad
            cantidadInput.value = 1;
        }
    </script>

    <!--ACTUALIZAR TABLA-->
    <script>
        function actualizarTabla() {
            let tabla = document.getElementById("tablaServicios");

            // limpiar tabla (menos encabezado)
            tabla.innerHTML = `
        <tr>
            <th>Servicio</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acción</th>
        </tr>
    `;

            total = 0;

            servicios.forEach((s, index) => {
                let fila = tabla.insertRow();

                fila.insertCell(0).innerText = s.nombre;
                fila.insertCell(1).innerText = "₡" + s.precio;
                fila.insertCell(2).innerText = s.cantidad;
                fila.insertCell(3).innerText = "₡" + s.subtotal;

                // botón eliminar
                let btn = document.createElement("button");
                btn.innerText = "Eliminar";
                btn.type = "button";

                btn.onclick = function () {
                    eliminarServicio(index);
                };

                fila.insertCell(4).appendChild(btn);

                total += s.subtotal;
            });

            document.getElementById("totalFactura").value = total;
            document.getElementById("listaServicios").value = JSON.stringify(servicios);
        }
    </script>

    <!--ELIMINAR SERVICIOS-->
    <script>
        function eliminarServicio(index) {
            servicios.splice(index, 1); // elimina correctamente
            actualizarTabla();
        }
    </script>



</body>


</html>