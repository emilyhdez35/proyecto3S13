<?php
session_start();

if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] != "gestion"){
    header("Location: login.html");
    exit();
}

echo "Bienvenido usuario de gestión";
?>