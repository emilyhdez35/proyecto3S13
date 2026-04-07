<?php
session_start();
echo json_encode([
    "tipo" => $_SESSION['tipo'] ?? null,
    "usuario" => $_SESSION['usuario'] ?? null
]);
?>
