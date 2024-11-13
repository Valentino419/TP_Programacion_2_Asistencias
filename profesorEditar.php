<?php

require_once 'Clases/conexion.php';
$basededatos = new Database;

$id_profesores = $_GET['id_profesores'];
$datos = $basededatos->db_consulta("SELECT * FROM profesores   
WHERE id_profesores=$id_profesores");
$profesor = $datos[0];

//
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
  <h3>Profesor</h3>
  <form action="procesar_formularios.php" method="post" id="formularioProfesor">
            <table>

                <tr>
                    <td> <label for="nombre">Nombre:</label> </td>
                    <td> <input type="text" id="nombre" name="nombre" required  maxlength ="50" value="<?php echo ($profesor['nombre']) ?>"> </td>
                </tr>
                <tr>
                    <td> <label for="apellido">Apellido:</label> </td>
                    <td> <input type="text" id="apellido" name="apellido" required  maxlength ="50" value="<?php echo ($profesor['apellido']) ?>"> </td>
                </tr>
                <tr>
                    <td><label for="dni">DNI:</label></td>
                    <td> <input type="text" id="dni" name="dni" required pattern="[0-9]{8}"  maxlength ="8" title="8 numeros" value="<?php echo ($profesor['dni']) ?>"></td>
                </tr>

                <tr>
                    <td><label for="correo_electronico">Correo electronico:</label></td>
                    <td><input type="text" id="correo_electronico" name="correo_electronico" required  maxlength ="50" value="<?php echo ($profesor['correo_electronico']) ?>" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title=" characters@characters.domain"></td>
                </tr>

                <tr>
                    <td><label for="telefono">Telefono:</label></td>
                    <td><input type="text" id="telefono" name="telefono" required  value="<?php echo ($profesor['telefono']) ?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{4}"  maxlength ="12" title="XXXX-XX-XXXX"></td>
                </tr>

                <tr>
                    <td><label for="legajo">Tegajo</label></td>
                    <td><input type="number" id="legajo" name="legajo" required value="<?php echo ($profesor['legajo']) ?>"  pattern="[0-9]{8}"  maxlength ="8"></td>
                </tr>

            </table>
            <input type="hidden" name="id_profesores" value=<?php echo ($profesor['id_profesores']) ?>>
            <input type="hidden" name="clase" value="profesorEditar">
            <button type="submit" id="ingresoProfesor">Ingresar</button>
            
        </form>



</body>