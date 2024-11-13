<?php

require_once 'Clases/conexion.php';
require_once 'Clases/Utilidades.php';

// Crear una instancia de la conexión a la base de datos
$database = new Database();
//var_dump($_POST);
switch ($_POST["clase"]) {

    case "alumno":
        $result = $database->db_CargarDatosAlumnos($_POST);
        break;
        case "alumnoEditar":
            $result = $database->db_EditarDatosAlumnos($_POST);
            break;
    case "profesor":
        $result = $database->db_CargarDatosProfesor($_POST);
        break;
    case "profesorEditar":
        $result = $database->db_EditarDatosProfesor($_POST);
        break;
    case "instituto":
        $result = $database->db_CargarDatosInstituto($_POST);
        break;
    case "institutoEdicion":
        $result = $database->actualizarInstituto($_POST);
        break;
    case "materia":
        $result = $database->db_CargarDatosMateria($_POST);
        break;
}
//var_dump($_POST);
echo "<h3>";
if ($result["resultadoOperacion"] == "exito") {

    echo "operacion exitosa: " . $_POST['clase'] . " ingresado exitosamente";
} else {
    echo "error: " . $_POST['clase'] . " no se pudo ingresar en la base de datos";
}
echo "</h3>"
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
    <button onclick="location.href='http://localhost/Asistencias/main.php'"> Aceptar </button>

</body>

</html>