<?php 
session_start(); 
include("conexion.php"); 
$correo = $_POST['correo']; 
$contrasena = $_POST['contrasena']; 

$sql = "SELECT * FROM usuarios WHERE correo=? AND contrasena=?"; 
$stmt = $conn->prepare($sql); 
$stmt->bind_param("ss", $correo, $contrasena); 
$stmt->execute(); 
$resultado = $stmt->get_result(); 

if($resultado->num_rows > 0){
     $usuario = $resultado->fetch_assoc(); 
     $_SESSION['usuario'] = $usuario['correo']; 
     $_SESSION['tipo'] = $usuario['tipo']; 
     
     if($usuario['tipo'] == "administrador"){ 
        header("Location: panel_admin.php"); 
        }
        else{ 
            header("Location: panel_gestion.php"); 
            } 
            }
else{ 
    echo "Usuario o contraseña incorrectos"; } ?>

    