<?php
include("conexion.php");

$dato = $_GET['dato'];
$tipo = $_GET['tipo'];

$like = "%".$dato."%";

if($tipo == "cliente"){

    $sql = "SELECT idcliente, nombre FROM cliente WHERE nombre LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $resultado = $stmt->get_result();

    while($fila = $resultado->fetch_assoc()){
        echo "<div onclick=\"seleccionarCliente(".$fila['idcliente'].", '".$fila['nombre']."')\">
                ".$fila['nombre']."
              </div>";
    }

}else if($tipo == "proveedor"){

    $sql = "SELECT idproveedor, nombreEmpresa FROM proveedor WHERE nombreEmpresa LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $resultado = $stmt->get_result();

    while($fila = $resultado->fetch_assoc()){
        echo "<div onclick=\"seleccionarProveedor(".$fila['idproveedor'].", '".$fila['nombreEmpresa']."')\">
                ".$fila['nombreEmpresa']."
              </div>";
    }

}
?>
