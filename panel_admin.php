<?php
session_start();

if(!isset($_SESSION['tipo']) || $_SESSION['tipo'] != "administrador"){
    header("Location: inicio.html");
    exit();
}

echo "Bienvenido administrador";
?>