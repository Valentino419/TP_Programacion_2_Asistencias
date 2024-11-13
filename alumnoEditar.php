<?php

require_once 'Clases/conexion.php';
$basededatos = new Database;

$id_alumno = $_GET['id_alumno'];
$datos = $basededatos->db_consulta("SELECT * FROM alumnos   
WHERE id_alumno=$id_alumno");
$alumno = $datos[0];


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="resources/css/estilos.css">
</head>

<body>
    <h3>Alumno</h3>
<form action="procesar_formularios.php" method="post" id="formularioAlumno">
            <table>

                <tr>
                    <td> <label for="nombre">Nombre:</label> </td>
                    <td> <input type="text" id="nombre" name="nombre" required value="<?php echo ($alumno['nombre']) ?>" maxlength ="50" > </td>
                </tr>
                <tr>
                    <td> <label for="apellido">Apellido:</label> </td>
                    <td> <input type="text" id="apellido" name="apellido" required value="<?php echo ($alumno['apellido']) ?>" maxlength ="50" title=" hasta 50 characters"> </td>
                </tr>
                <tr>
                    <td><label for="dni">DNI:</label></td>
                    <td> <input type="number" id="dni" name="dni" required value="<?php echo ($alumno['dni']) ?>" pattern="[0-9]{8}" maxlength="8" title="8 numeros"></td>
                </tr>
                <tr>
                    <td><label for="fecha_nacimiento">Fecha de Nacimiento:</label></td>
                    <td><input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo ($alumno['fecha_nacimiento']) ?>" required></td>
                </tr>
                <tr>
                    <td><label for="correo_electronico">Correo electronico:</label></td>
                    <td><input type="text" id="correo_electronico" name="correo_electronico" value="<?php echo ($alumno['correo_electronico']) ?>" maxlength ="50" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title=" characters@characters.domain"></td>
                </tr>

                <tr>
                    <td><label for="telefono">Telefono:</label></td>
                    <td><input type="text" id="telefono" name="telefono" pattern="[0-9]{4}-[0-9]{2}-[0-9]{4}"  value="<?php echo ($alumno['telefono']) ?>" maxlength ="12" title="XXXX-XX-XXXX"></td>
                </tr>

                <input type="hidden" name="clase"  value ="alumnoEditar" >
                <input type="hidden" name="id_alumno"  value="<?php echo ($alumno['id_alumno']) ?>" >

            </table>
            <button type="submit" id="ingresoAlumno">Ingresar</button>
        </form>

</body>