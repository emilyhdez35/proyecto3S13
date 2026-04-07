<?php
include("conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM formIngreso WHERE idForm = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$res = $stmt->get_result();
$ingreso = $res->fetch_assoc();

// Convertir strings a arrays (checkbox)
$colores = explode(", ", $ingreso['color']);
$pertenencias = explode(", ", $ingreso['pertenencias']);
$examenes = explode(", ", $ingreso['examenes']);
?>

<!DOCTYPE html>
<html>
<head>
<title>Detalle Ingreso</title>
    <link rel="stylesheet" href="css/formIngreso.css">

</head>


<body>

<h1>Formulario de Ingreso</h1>

<div class="container">
<form>

<label>Fecha:</label>
<input type="date" value="<?php echo $ingreso['fecha']; ?>" readonly><br><br>

<label>Expediente:</label>
<input type="text" value="<?php echo $ingreso['expediente']; ?>" readonly><br><br>

<label>Recibió Px:</label>
<input type="text" value="<?php echo $ingreso['recibioPx']; ?>" readonly><br><br>

<h3>DATOS DEL TUTOR/RESPONSABLE</h3>

<label>Nombre:</label>
<input type="text" value="<?php echo $ingreso['nombreTutor']; ?>" readonly>

<label>Dirección:</label>
<input type="text" value="<?php echo $ingreso['direccionTutor']; ?>" readonly><br><br>

<label>Tipo:</label>
<input type="radio" <?php if($ingreso['tipoTutor']=="rescatista") echo "checked"; ?> disabled> Rescatista
<input type="radio" <?php if($ingreso['tipoTutor']=="responsable") echo "checked"; ?> disabled> Responsable
<input type="radio" <?php if($ingreso['tipoTutor']=="organizacion") echo "checked"; ?> disabled> Organización

<label>Teléfono:</label>
<input type="text" value="<?php echo $ingreso['telefonoTutor']; ?>" readonly><br><br>

<label>Transporte:</label>
<input type="radio" <?php if($ingreso['usoTransporte']=="si") echo "checked"; ?> disabled> Sí
<input type="radio" <?php if($ingreso['usoTransporte']=="no") echo "checked"; ?> disabled> No

<h3>DATOS DEL PACIENTE</h3>

<label>Nombre:</label>
<input type="text" value="<?php echo $ingreso['nombrePaciente']; ?>" readonly>

<label>Especie:</label>
<input type="radio" <?php if($ingreso['especie']=="canino") echo "checked"; ?> disabled> Canino
<input type="radio" <?php if($ingreso['especie']=="felino") echo "checked"; ?> disabled> Felino

<label>Sexo:</label>
<input type="radio" <?php if($ingreso['sexo']=="macho") echo "checked"; ?> disabled> Macho
<input type="radio" <?php if($ingreso['sexo']=="hembra") echo "checked"; ?> disabled> Hembra

<br><br>

<label>Raza:</label>
<input type="text" value="<?php echo $ingreso['raza']; ?>" readonly>

<label>Peso:</label>
<input type="text" value="<?php echo $ingreso['peso']; ?>" readonly>

<label>Edad:</label>
<input type="text" value="<?php echo $ingreso['edad']; ?>" readonly>

<br><br>

<b>Color:</b>
<input type="checkbox" <?php if(in_array("Negro",$colores)) echo "checked"; ?> disabled> Negro
<input type="checkbox" <?php if(in_array("Blanco",$colores)) echo "checked"; ?> disabled> Blanco
<input type="checkbox" <?php if(in_array("Cafe claro",$colores)) echo "checked"; ?> disabled> Café claro
<input type="checkbox" <?php if(in_array("Cafe oscuro",$colores)) echo "checked"; ?> disabled> Café oscuro
<input type="checkbox" <?php if(in_array("Manchas",$colores)) echo "checked"; ?> disabled> Manchas
<input type="checkbox" <?php if(in_array("Rayas",$colores)) echo "checked"; ?> disabled> Rayas

<br><br>

<b>Pelo:</b>
<input type="radio" <?php if($ingreso['pelo']=="corto") echo "checked"; ?> disabled> Corto
<input type="radio" <?php if($ingreso['pelo']=="medio") echo "checked"; ?> disabled> Medio
<input type="radio" <?php if($ingreso['pelo']=="largo") echo "checked"; ?> disabled> Largo

<br><br>

<b>Particularidades:</b>
<input type="text" value="<?php echo $ingreso['particularidades']; ?>" readonly>

<br><br>

<b>Pertenencias:</b>
<input type="checkbox" <?php if(in_array("collar",$pertenencias)) echo "checked"; ?> disabled> Collar
<input type="checkbox" <?php if(in_array("Correa",$pertenencias)) echo "checked"; ?> disabled> Correa
<input type="checkbox" <?php if(in_array("Transportadora",$pertenencias)) echo "checked"; ?> disabled> Transportadora

<br><br>

<label>Descripción:</label>
<input type="text" value="<?php echo $ingreso['descripcion']; ?>" readonly>

<br><br>

<label>Ayuno:</label>
<input type="radio" <?php if($ingreso['ayuno']=="si") echo "checked"; ?> disabled> Sí
<input type="radio" <?php if($ingreso['ayuno']=="no") echo "checked"; ?> disabled> No

<label>Hora:</label>
<input type="time" value="<?php echo $ingreso['horaAyuno']; ?>" readonly>

<br><br>

<b>Exámenes:</b>
<input type="checkbox" <?php if(in_array("Hemograma",$examenes)) echo "checked"; ?> disabled> Hemograma
<input type="checkbox" <?php if(in_array("Bioquimicas",$examenes)) echo "checked"; ?> disabled> Bioquímicas
<input type="checkbox" <?php if(in_array("Heces",$examenes)) echo "checked"; ?> disabled> Heces
<input type="checkbox" <?php if(in_array("Orina",$examenes)) echo "checked"; ?> disabled> Orina

<br><br>

<h3>AUTORIZACIÓN PARA SEDACIÓN / ANESTESIA / CIRUGÍA</h3>

<p>
El abajo firmante presta su conformidad y autoriza a BIENVET Animal Care Center y Fundación Narime, 
        y a quien éste designe, <br> para efectuar la sedación, anestesia y cirugía que sea necesaria para 
        poder realizar las maniobras detalladas, al animal cuyos datos <br>han sido especificados previamente, 
        para realizar todos los procedimientos destinados a procurar salvaguardar su vida y/o procurar <br>
        mejorar y/o recuperar la salud de este. Asimismo, deja constancia y acepta de forma irrevocable, 
        que le han sido explicados los<br> riesgos que implican para la vida del animal, los resultados 
        esperados, las posibles complicaciones, así como eventuales secuelas <br> derivadas de la sana práctica 
        médica, a someterse a las indicaciones, tratamientos y prácticas que los profesionales actuantes 
        consideren <br> convenientes. Certifica de esta manera que ha leído y comprendido la presente 
        autorización y que ha aceptado o rechazado los insumos <br>o exámenes arriba recomendados o sugeridos.
</p>

<br>

<table style="width:100%; margin-top:30px;">
    <tr>
        <td>
            <strong>Nombre:</strong><br>
            <input type="text" value="<?php echo $ingreso['nombreAutorizacion']; ?>" readonly style="width:90%;">
        </td>

        <td>
            <strong>Cédula:</strong><br>
            <input type="text" value="<?php echo $ingreso['cedulaAutorizacion']; ?>" readonly style="width:90%;">
        </td>
    </tr>
</table>

<br><br>

<!-- Línea de firma -->
<div style="margin-top:50px;">
    <strong>Firma:</strong><br><br>
    <div style="border-bottom: 2px solid black; width:300px;"></div>
</div>

<h3>USO INTERNO</h3>

<label>Historia médica:</label>
<input type="text" value="<?php echo $ingreso['historiaMedica']; ?>" readonly>

<label>Procedimiento:</label>
<input type="radio" <?php if($ingreso['procedimiento']=="OVH") echo "checked"; ?> disabled> OVH
<input type="radio" <?php if($ingreso['procedimiento']=="Orq") echo "checked"; ?> disabled> Orq

<label>Medicamentos:</label>
<input type="radio" <?php if($ingreso['medicamentos']=="si") echo "checked"; ?> disabled> Sí
<input type="radio" <?php if($ingreso['medicamentos']=="no") echo "checked"; ?> disabled> No

<br><br>

<button onclick="window.print()">Imprimir</button>

</form>
</div>

</body>
</html>