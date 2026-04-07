<?php 
session_start(); 
include("conexion.php"); 

if($_POST){ 
    $correo = $_POST['correo']; 
    $password = $_POST['password']; 

    $sql = "SELECT * FROM usuarios WHERE correo='$correo'"; 
    $resultado = $conn->query($sql); 

    if($resultado->num_rows > 0){ 
        $usuario = $resultado->fetch_assoc(); 
        if(password_verify($password, $usuario['password'])){ 
            $_SESSION['usuario'] = $usuario['nombre']; 
            header("Location: panel.php"); 
        } else { 
            echo "Contraseña incorrecta"; 
        } 
    } else { 
        echo "Usuario no encontrado"; 
    } 
} 
?> 

<form method="POST"> 
Correo: <input type="email" name="correo" required><br> 
Contraseña: <input type="password" name="password" required><br> 
<button type="submit">Ingresar</button> 
</form> 