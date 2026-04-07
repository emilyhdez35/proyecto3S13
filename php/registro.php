<?php 
include("conexion.php"); 
if($_POST){ 
    $nombre = $_POST['nombre']; 
    $correo = $_POST['correo']; 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $sql = "INSERT INTO usuarios (nombre, correo, password) 
            VALUES ('$nombre','$correo','$password')"; 
    $conn->query($sql); 
    echo "Usuario registrado correctamente"; 
} 
?> 
<form method="POST"> 
Nombre: <input type="text" name="nombre" required><br> 
Correo: <input type="email" name="correo" required><br> 
Contraseña: <input type="password" name="password" required><br> 
<button type="submit">Registrar</button> 
</form> 
