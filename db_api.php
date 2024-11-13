<?php
require_once 'Clases/conexion.php';
$basededatos = new Database;
$alumnos = new Alumno;
$cursada = new CursadaAlumnos;
$profesor = new Profesor;
$materias = new Materia;
$instituto = new Instituto;
header('Content-Type: application/json');
$data = file_get_contents("php://input"); // Decode the JSON data the server recived
$items = json_decode($data, true); // Access the array


switch ($items["opcion"]) {
    case "test":
        echo json_encode($items);
        break;
        //ALUMNOS
    case "alumnosRegistradosPorMateria": //devuelve Json con todas las materias impartidas por un profesor
        echo json_encode($basededatos->getAlumnosMateria($items["id_materia"]));
        break;
    case "alumnoListaPorcentajeAsistencias": //devuelve una lista con los dias de clases las asistencias y el porcentaje
        echo json_encode($basededatos->todosPorcentajeAsistencias($items["id_materia"]));
        break;
    case "listarAlumnos": //lista todos los alumnos
        echo json_encode($basededatos->listar($alumnos));
        break;
    case "getInscriptos": //lista los alumnos incriptos a una materia
        echo json_encode($basededatos->getAlumnosInscriptos($items["id_materia"]));
        break;
        //Profesores
    case "listarProfesores": //lista todos los profesores almacenados en la base de datos
        echo json_encode($basededatos->listar($profesor));
        break;
        //Materias
    case "materiaPorProfesor": //devuelve Json con todas las materias impartidas por un profesor
        echo json_encode($basededatos->db_BuscarRegistro($items["id_profesor"], $materias, $items['campo']));
        break;
    case "materiaInstitutoProfesor": //devuelve una lista de materias de un profesor acotadas por la institucion
        echo json_encode($basededatos->listaMateriasPorInstitutoProfesor($items["id_profesor"], $items["id_instituto"]));
        break;
    case "nuevaMateria": //crea un registro nuevo en la tabla de materias
        echo json_encode($basededatos->db_CargarDatosMateria($items));
        break;
        //instituto
    case "listarInstitutos": //lista todos los profesores almacenados en la base de datos
        echo json_encode($basededatos->listar($instituto));
        break;
        //Asistencias
    case "guardarAsistencisas": //guarda las asisntecias tomadas en la bace de datos y regresa un Json con informacion
        echo json_encode($basededatos->tomarAsistencia($items["id_materia"], $items["vectorListaAlumnos"],$items['fecha']));
        break;


    case "getPresentes": //verifica las asitencias para una materia que ya hayan sido tomadas.
        echo json_encode($basededatos->asistenciasTomadas($items["id_materia"], $items["fecha"]));
        break;
    case "consultarAsistencias": //regresa un Json con la cantidad de dias que se tomo asistencia, los que estubo precente y el porcentaje
        echo json_encode($basededatos->porcentajeAsistencias($items["id_materia"], $items["id_alumno"]));
        break;
    case "DiasDeClase": // regresa el total de dias que se tomo asistencia de una materia
        echo json_encode(["totalDias" => $basededatos->db_MateriaTotalDias($items["id_materia"])]);
    case "inscribirAlumnosMateria":
        echo json_encode($basededatos->inscribirAlumnosMateria($items["id_materia"], $items["vectorListaAlumnos"]));
        break;
        //NOTAS Y CALIFICACIONES
    case "nuevaInstanciaEvaluativa": //crea un nuevo registro en la tabla de Evaluaciones
        echo json_encode($basededatos->db_CargarDatosInstanciaEvaluativa($items));
        break;
    case "listarInstanciasEvaluativas": //lista todas las instancias evalutaivas asociadas a una materia
        echo json_encode($basededatos->getInstancisasEvaluativas($items['id_materia']));
        break;
    case 'ingresarNotas': //crea un nuevo elemnto en la tabla de notas asociado a un alumno y una instancia evalutaiva, si ya hay una nota entonces edita la existente
        echo json_encode($basededatos->IngresarNotas($items['id_InstancisasEvaluativas'], $items['notas']));
        break;
    case "cosultarNotas": //lista todas las instancias evalutaivas de un alumno en una materia, pero solo devuelve la nota mas alta si hay recuperatorio
        echo json_encode($basededatos->getNotasAlumno($items["id_alumno"], $items["id_materia"]));
        break;
    case "getRam": //devuelce la ram de un colegio
        echo json_encode($basededatos->getRam($items["id_materia"]));
        break;
    case "getNotasDeInstanciaEvaluativa": //lista todas las notas que se calificado en una instancia evaluativa
        echo json_encode($basededatos->getNotasDeInstanciaEvaluativa($items[$id_InstancisasEvaluativas]));
        break;
    case "listarFechaAsistencias": // lista de todas las fechas en las que se haya tomado asistencia
        echo json_encode($basededatos->listarFechaAsistencias($items["id_materia"]));
        break;
}
