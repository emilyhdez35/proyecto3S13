<?php
include("conexion.php");

// -----------------------------
// RECIBIR DATOS
// -----------------------------

$fecha = $_POST['fecha'];
$expediente = $_POST['numExpediente'];
$recibioPx = $_POST['recibioPX'];

$nombreTutor = $_POST['nombreTutor'];
$direccionTutor = $_POST['direccion'];
$tipoTutor = $_POST['tipoTutor'];
$telefonoTutor = $_POST['numTelefono'];
$usoTransporte = $_POST['transporte'];

$nombrePaciente = $_POST['nombrePaciente'];
$especie = $_POST['especie'];
$sexo = $_POST['sexo'];

$raza = $_POST['raza'];
$peso = $_POST['peso'];
$edad = $_POST['edad'];

// Arrays
$color = isset($_POST['color']) ? implode(", ", $_POST['color']) : "";
$pertenencias = isset($_POST['pertenencias']) ? implode(", ", $_POST['pertenencias']) : "";
$examenes = isset($_POST['examenes']) ? implode(", ", $_POST['examenes']) : "";

$pelo = $_POST['pelo'];
$particularidades = $_POST['particularidades'] ?? "";
$descripcion = $_POST['descripcion'] ?? "";

$ayuno = $_POST['ayuno'];
$horaAyuno = $_POST['horaAyuno'] ?? null;

$nombreAutorizacion = $_POST['nombreAutorizacion'];
$cedulaAutorizacion = $_POST['cedulaAutorizacion'];
$firmaAutorizacion = $_POST['firmaAutorizacion'] ?? "";

$historiaMedica = $_POST['historiaMedica'];
$procedimiento = $_POST['procedimiento'];
$medicamentos = $_POST['medicamentos'];

// -----------------------------
// INSERT
// -----------------------------

$sql = "INSERT INTO formIngreso (
    ayuno, cedulaAutorizacion, color, descripcion, direccionTutor, edad,
    especie, examenes, expediente, fecha, firmaAutorizacion, historiaMedica,
    horaAyuno, medicamentos, nombreAutorizacion, nombrePaciente, nombreTutor,
    particularidades, pelo, pertenencias, peso, procedimiento, raza,
    recibioPx, sexo, telefonoTutor, tipoTutor, usoTransporte
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssssssssssssssssssssssssss",
    $ayuno,
    $cedulaAutorizacion,
    $color,
    $descripcion,
    $direccionTutor,
    $edad,
    $especie,
    $examenes,
    $expediente,
    $fecha,
    $firmaAutorizacion,
    $historiaMedica,
    $horaAyuno,
    $medicamentos,
    $nombreAutorizacion,
    $nombrePaciente,
    $nombreTutor,
    $particularidades,
    $pelo,
    $pertenencias,
    $peso,
    $procedimiento,
    $raza,
    $recibioPx,
    $sexo,
    $telefonoTutor,
    $tipoTutor,
    $usoTransporte
);

$stmt->execute();

echo "<script>
alert('Formulario guardado correctamente');
window.location.href = 'frmIngreso.php';
</script>";
?>