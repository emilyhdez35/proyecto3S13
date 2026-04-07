<?php
session_start();
include("conexion.php");

// =====================
// AGREGAR
// =====================
if (isset($_POST['accion']) && $_POST['accion'] == "agregar") {

    if (!isset($_SESSION['tipo'])) {
        die("No autenticado");
    }

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen'];
    $distribuidor = $_POST['distribuidor'];
    $codigo = $_POST['codigo'];
    $fechaRegistro = date("Y-m-d H:i:s");

    $sql = "INSERT INTO productos(nombre, descripcion, precio, cantidad, imagen, distribuidor, fechaRegistro, codigo)
            VALUES (?,?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssdissss",
        $nombre,
        $descripcion,
        $precio,
        $cantidad,
        $imagen,
        $distribuidor,
        $fechaRegistro,
        $codigo
    );

    echo $stmt->execute() ? "ok" : "error";
}

// =====================
// LISTAR
// =====================
if (isset($_GET['accion']) && $_GET['accion'] == "listar") {

    $res = $conn->query("SELECT * FROM productos");

    $productos = [];

    while ($row = $res->fetch_assoc()) {
        $productos[] = $row;
    }

    echo json_encode($productos);
}

// =====================
// FILTRAR
// =====================
if (isset($_GET['accion']) && $_GET['accion'] == "filtrar") {
    $nombre = $_GET['nombre'] ?? "";
    $codigo = $_GET['codigo'] ?? "";
    $fecha = $_GET['fecha'] ?? "";

    $sql = "SELECT * FROM productos WHERE 1=1";

    if ($nombre != "") {
        $sql .= " AND nombre LIKE '%" . $conn->real_escape_string($nombre) . "%'";
    }
    if ($codigo != "") {
        $sql .= " AND codigo LIKE '%" . $conn->real_escape_string($codigo) . "%'";
    }
    if ($fecha != "") {
        $sql .= " AND DATE(fechaRegistro) = '" . $conn->real_escape_string($fecha) . "'";
    }

    $res = $conn->query($sql);

    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

// =====================
// EDITAR
// =====================
if (isset($_POST['accion']) && $_POST['accion'] == "editar") {

    if (!isset($_SESSION['tipo'])) {
        die("No autenticado");
    }

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Solo admin puede editar TODO
    if ($_SESSION['tipo'] == "administrador") {

        $descripcion = $_POST['descripcion'];
        $imagen = $_POST['imagen'];
        $distribuidor = $_POST['distribuidor'];
        $codigo = $_POST['codigo'];

        $sql = "UPDATE productos 
                SET nombre=?, precio=?, cantidad=?, descripcion=?, imagen=?, distribuidor=?, codigo=? 
                WHERE id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sdissssi",
            $nombre,
            $precio,
            $cantidad,
            $descripcion,
            $imagen,
            $distribuidor,
            $codigo,
            $id
        );

    } else {
        // Gestión solo puede editar lo básico
        $sql = "UPDATE productos 
                SET nombre=?, precio=?, cantidad=? 
                WHERE id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sdii",
            $nombre,
            $precio,
            $cantidad,
            $id
        );
    }

    echo $stmt->execute() ? "ok" : "error";
}

// =====================
// ELIMINAR (SOLO ADMIN)
// =====================
if (isset($_POST['accion']) && $_POST['accion'] == "eliminar") {

    if (!isset($_SESSION['tipo'])) {
        die("No autenticado");
    }

    if ($_SESSION['tipo'] != "administrador") {
        echo "denegado";
        exit();
    }

    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM productos WHERE id=?");
    $stmt->bind_param("i", $id);

    echo $stmt->execute() ? "ok" : "error";
}
?>