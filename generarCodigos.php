<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar códigos</title>
    <link rel="stylesheet" href="css/codigos.css">
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
    <br>
    <h1>Registro de códigos</h1>
    <button onclick="abrirModal('cliente')">Registrar cliente</button>
    <button onclick="abrirModal('proveedor')">Registrar proveedor</button>

    <!--MODAL-->
    <div id="modal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:white; padding:20px; margin:10% auto; width:350px;">

            <h2 id="titulo"></h2>

            <div id="formulario"></div>

            <button onclick="cerrarModal()">Cerrar</button>
        </div>
    </div>

    <!--SCRIPT PARA CAMBIAR DE MODAL SEGÚN CORRESPONDA-->
    <script>
        function abrirModal(tipo) {
            document.getElementById("modal").style.display = "block";

            if (tipo === "cliente") {
                document.getElementById("titulo").innerText = "Registrar Cliente";

                document.getElementById("formulario").innerHTML = `
            <form action="guardar_cliente.php" method="POST">
                <label>Nombre:</label>
                <input type="text" name="nombre" required><br><br>

                <label>Cédula:</label>
                <input type="number" name="cedula"><br><br>

                <label>Correo:</label>
                <input type="email" name="correo" required><br><br>

                <label>Teléfono:</label>
                <input type="number" name="telefono"><br><br>

                <label>Dirección:</label>
                <input type="text" name="direccion"><br><br>

                <button type="submit">Guardar Cliente</button>
            </form>
        `;
            } else {
                document.getElementById("titulo").innerText = "Registrar Proveedor";

                document.getElementById("formulario").innerHTML = `
            <form action="guardar_proveedor.php" method="POST">
                <label>Nombre empresa:</label>
                <input type="text" name="empresa" required><br><br>

                <label>Cédula Jurídica:</label>
                <input type="number" name="cedula"><br><br>

                <label>Teléfono:</label>
                <input type="number" name="telefono"><br><br>

                <label>Correo:</label>
                <input type="email" name="correo"><br><br>

                <label>Dirección:</label>
                <input type="text" name="direccion"><br><br>

                <label>Código Interno:</label>
                <input type="text" name="codInterno">
                <p>SOLO proveedores internacionales*</p><br><br>

                <button type="submit">Guardar Proveedor</button>
            </form>
        `;
            }
        }

        function cerrarModal() {
            document.getElementById("modal").style.display = "none";
        }
    </script>


    <!--LISTADO DE CLIENTES Y PROVEEDORES-->
    <?php
    include("conexion.php");

    $sql = "SELECT * FROM cliente";
    $resultado = $conn->query($sql);
    ?>

    <h2>Lista de Clientes</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Dirección</th>
        </tr>

        <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $fila['idcliente']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['cedula']; ?></td>
                <td><?php echo $fila['correo']; ?></td>
                <td><?php echo $fila['telefono']; ?></td>
                <td><?php echo $fila['direccion']; ?></td>
            </tr>
        <?php } ?>

    </table>

    <?php
    $sql2 = "SELECT * FROM proveedor";
    $resultado2 = $conn->query($sql2);
    ?>

    <h2>Lista de Proveedores</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Empresa</th>
            <th>Cédula Jurídica</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Código Interno</th>
        </tr>

        <?php while ($fila = $resultado2->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $fila['idproveedor']; ?></td>
                <td><?php echo $fila['nombreEmpresa']; ?></td>
                <td><?php echo $fila['cedulaJuridica']; ?></td>
                <td><?php echo $fila['telefono']; ?></td>
                <td><?php echo $fila['correo']; ?></td>
                <td><?php echo $fila['direccion']; ?></td>
                <td><?php echo $fila['codInterno']; ?></td>
            </tr>
        <?php } ?>

    </table>

</body>

</html>