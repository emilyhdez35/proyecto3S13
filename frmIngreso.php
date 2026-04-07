<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Ingreso</title>
    <link rel="stylesheet" href="css/formIngreso.css">
    <link rel="stylesheet" href="css/estilos.css">

</head>

<header id="header">
    <img src="img/LogoSample_ByTailorBrands.jpg" alt="logo" id="logo">

    <nav class="menu">
        <a href="inicio.html">Inicio</a>
        <a href="flujoDeCaja.html">Flujo de Caja</a>
        <a href="login.html">Iniciar Sesión</a>
        <a href="generarCodigos.php">Generar códigos</a>
        <a href="facturaXcobrar.php">Facturas por Cobrar</a>
        <a href="facturaXpagar.php">Facturas por Pagar</a>
        <a href="empleados.html">Empleados</a>
        <a href="planilla.html">Planilla</a>
    </nav>

    <div class="ubicacion">
        <i class="fa-solid fa-location-dot"></i>
        <p>Costa Rica</p>

    </div>

</header>
<body>
    

<div class="container">
<form action="frmIngresoBK.php" method="POST">
   <h1>Formulario de Ingreso/Rescatistas</h1>
    <label>Fecha:</label>
    <input type="date" id="fechaE" name="fecha"><br><br>
    
    <script>
        document.getElementById("fechaE").value = new Date().toISOString().split('T')[0];
    </script>

    <label> Expediente:</label>
    <input type="number" name="numExpediente" placeholder="fecha-consecutivo del día" ><br><br>

    <label>Recibió Px:</label>
    <input type="text" name="recibioPX">

    <h3>DATOS DEL TUTOR/RESPONSABLE</h3>
    <u>Datos de quien entrega:</u> <br><br>

    <label>Nombre y apellidos:</label>
    <input type="text" name="nombreTutor">

    &nbsp;&nbsp;&nbsp;&nbsp;<label>Dirección:</label>
    <input type="text" name="direccion"> <br><br>

    <label>Tipo de tutor:</label>
    <input type="radio" name="tipoTutor" value="rescatista" required>
    <label>Rescatista</label>
    <input type="radio" name="tipoTutor" value="responsable">
    <label>Responsable</label>
    <input type="radio" name="tipoTutor" value="organizacion">
    <label>Organización</label>

    &nbsp;&nbsp;&nbsp;<label># de teléfono:</label>
    <input type="number" name="numTelefono"> <br><br>

    <label>Uso de transporte(adicional):</label>
    <input type="radio" name="transporte" value="si" required>
    <label>Si</label>
    <input type="radio" name="transporte" value="no">
    <label>No</label> <br><br>

    <h3>DATOS DEL PACIENTE</h3>
    <b>Nombre:</b>
    <input type="text" name="nombrePaciente">&nbsp;&#124;&nbsp;&nbsp;

    <label>Especie:</label>
    <input type="radio" name="especie" value="canino" required>
    <label>Canino</label>
    <input type="radio" name="especie" value="felino">
    <label>Felino</label> &nbsp;&#124;&nbsp;&nbsp;

    <label>Sexo:</label>
    <input type="radio" name="sexo" value="macho" required>
    <label>Macho</label>
    <input type="radio" name="sexo" value="hembra">
    <label>Hembra</label> <br><br>



    <label>Raza:</label>
    <input type="text" name="raza">&nbsp;&nbsp;
    
    <label>Peso(kg):</label>
    <input type="text" name="peso">&nbsp;&nbsp;

    <label>Edad aproximada:</label>
    <input type="number" min="1" name="edad"> <br><br>


    <b>Descripción física - Color:</b>
    <input type="checkbox" name="color[]" value="Negro"> Negro
    <input type="checkbox" name="color[]" value="Blanco"> Blanco
    <input type="checkbox" name="color[]" value="Cafe claro"> Café claro
    <input type="checkbox" name="color[]" value="Cafe oscuro"> Café oscuro
    <input type="checkbox" name="color[]" value="Manchas"> Manchas
    <input type="checkbox" name="color[]" value="Rayas"> Rayas <br><br>

    <b>Pelo:</b>
    <input type="radio" name="pelo" value="corto" required>
    <label>Corto</label>
    <input type="radio" name="pelo" value="medio">
    <label>Medio</label> 
    <input type="radio" name="pelo" value="largo">
    <label>Largo</label> &nbsp;&#124;&nbsp;&nbsp;

     <b>Marcas o particularidades:</b>
    <input type="text" name="particularidades"> <br><br>

    <b>Pertenencias:</b>
    <input type="checkbox" name="pertenencias[]" value="No"> No
    <input type="checkbox" name="pertenencias[]" value="collar"> Collar
    <input type="checkbox" name="pertenencias[]" value="Correa"> Correa
    <input type="checkbox" name="pertenencias[]" value="Transportadora"> Transportadora
    <input type="checkbox" name="pertenencias[]" value="Otros"> Otros  &nbsp;&#124;&nbsp;&nbsp;

    <label>Descripción:</label>
    <input type="text" name="descripcion"><br><br>
    
    <label>¿Está en ayuno?</label>
    <input type="radio" name="ayuno" value="si" required>
    <label>Si</label>
    <input type="radio" name="ayuno" value="no">
    <label>No</label> &nbsp;&#124;&nbsp;&nbsp;
    <label>¿Desde qué hora?</label>
    <input type="time" name="horaAyuno"><br><br>

    <b>¿Desea realizar examenes complementarios? (adicional)</b>
    <input type="checkbox" name="examenes[]" value="No"> No
    <input type="checkbox" name="examenes[]" value="Hemograma"> Hemograma
    <input type="checkbox" name="examenes[]" value="Bioquimicas"> Bioquímicas
    <input type="checkbox" name="examenes[]" value="Heces"> Heces
    <input type="checkbox" name="examenes[]" value="Orina"> Orina 

    <h3>AUTORIZACIÓN PARA SEDACIÓN / ANESTESIA / CIRUGIA</h3>
    <p>El abajo firmante presta su conformidad y autoriza a BIENVET Animal Care Center y Fundación Narime, 
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

    <label>Nombre:</label>
    <input type="text" name="nombreAutorizacion">
    <label>Cédula:</label>
    <input type="number" name="cedulaAutorizacion">
    <label>Firma:</label>
    <input type="text" name="firmaAutorizacion">

    <hr>

    <h3>USO INTERNO</h3>
    <b>Historia médica:</b>
    <input type="text" name="historiaMedica"> <br><br>

    <label>Procedimiento:</label>
    <input type="radio" name="procedimiento" value="OVH" required>
    <label>OVH</label>
    <input type="radio" name="procedimiento" value="Orq">
    <label>Orq</label> &nbsp;&#124;&nbsp;&nbsp;

    <label>Requiere medicamentos:</label>
    <input type="radio" name="medicamentos" value="si" required>
    <label>Si</label>
    <input type="radio" name="medicamentos" value="no">
    <label>No</label>

   <button type="submit">Registrar paciente</button>
</form>
</div>


<h2>Expedientes registrados</h2>

<?php
include("conexion.php");

$sql = "SELECT idForm, expediente, nombrePaciente, especie, fecha
        FROM formIngreso
        ORDER BY idForm DESC";

$res = $conn->query($sql);
?>

<table border="1">
    <tr>
        <th>Expediente</th>
        <th>Paciente</th>
        <th>Especie</th>
        <th>Fecha</th>
        <th>Acción</th>
    </tr>

    <?php while ($f = $res->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $f['expediente']; ?></td>
            <td><?php echo $f['nombrePaciente']; ?></td>
            <td><?php echo $f['especie']; ?></td>
            <td><?php echo $f['fecha']; ?></td>
            <td>
                <a href="ver_ingreso.php?id=<?php echo $f['idForm']; ?>">
                    <button type="button">Ver</button>
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

        
</body>
</html>