<?php
session_start();
include("conexion.php");


if (isset($_POST['accion']) && $_POST['accion'] == "login") {

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios WHERE correo=? AND contrasena=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $correo, $contrasena);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $usuario = $resultado->fetch_assoc();

        $_SESSION['usuario'] = $usuario['correo'];
        $_SESSION['tipo'] = $usuario['tipoUsuario'];

        // Redirección por rol
        if ($usuario['tipoUsuario'] == "administrador") {
            header("Location: inicio.html");
        } else {
            header("Location: inicio.html");
        }

    } else {
        echo "Usuario o contraseña incorrectos";
    }
}



if (isset($_POST['accion']) && $_POST['accion'] == "registro") {

    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != "administrador") {
        die("No tienes permisos para registrar usuarios");
    }

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $tipo = $_POST['tipoUsuario'];

    $sql = "INSERT INTO usuarios (correo, contrasena, tipoUsuario) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $correo, $contrasena, $tipo);

    if ($stmt->execute()) {
        echo "Usuario creado correctamente";
    } else {
        echo "Error al crear usuario";
    }
}


if (isset($_GET['accion']) && $_GET['accion'] == "logout") {
    session_destroy();
    header("Location: login.html");
}

// ---------------- LISTAR ----------------
if (isset($_GET['accion']) && $_GET['accion'] == "listar") {

    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != "administrador") {
        die("No autorizado");
    }

    $res = $conn->query("SELECT correo, tipoUsuario FROM usuarios");

    $data = [];

    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

// ---------------- ELIMINAR ----------------
if (isset($_POST['accion']) && $_POST['accion'] == "eliminar") {

    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != "administrador") {
        die("No autorizado");
    }

    $correo = $_POST['correo'];

    // ❌ evitar eliminar admins
    $sqlCheck = "SELECT tipoUsuario FROM usuarios WHERE correo=?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $correo);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result();
    $user = $resCheck->fetch_assoc();

    if ($user['tipoUsuario'] == "administrador") {
        die("No se puede eliminar un administrador");
    }

    $sql = "DELETE FROM usuarios WHERE correo=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);

    if ($stmt->execute()) {
        echo "Usuario eliminado";
    } else {
        echo "Error al eliminar";
    }
}
?>