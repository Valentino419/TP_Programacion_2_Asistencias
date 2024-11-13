<?php

use LDAP\Result;

require_once "clases/Usuario.php";
require_once "clases/Asistencia.php";
require_once "clases/Educaen.php";
require_once "clases/Instituto.php";
require_once "clases/Materia.php";
require_once "clases/Profesor.php";
require_once "clases/Alumno.php";
require_once "clases/Materia.php";
require_once "clases/Cursada.php";
require_once "clases/Nota.php";
require_once "clases/Utilidades.php";

class Database
{
    use Utilidades;
    private $host = 'localhost';
    private $db_name = 'asistencias';
    private $username = 'root';
    private $password = '';
    public $conn;
    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }

        return $this->conn;
    }
    public function db_consulta($consulta)
    { //$this->db_consulta();
        try {
            $stmt = $this->conn->prepare($consulta);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }
    public function disconnect()
    {
        $this->conn->null;
    }

    public function db_vincular(&$stmt, $tabla) //$stmt->bindParam(':nombre, campo a vincular)}
    {
        for ($i = 1; $i <= 10; $i++) {
            if ($tabla->campo($i) <> '') {
                $stmt->bindParam(':' . $tabla->campo($i), $tabla->{$tabla->campo($i)}, PDO::PARAM_STR);
            }
        }
    }

    public function logindb($data)
    {

        // var_dump($data);
        // Obtener los valores enviados por POST
        $user = new Usuario;
        $usuario = $this->clean_input($data["usuario"]);
        $contrasena = $this->clean_input($data["contrasena"]);

        $datos = $this->db_BuscarRegistro($usuario, $user, 5);
        $this->cargarDatos($user, $datos[0]);
        if ($user->contrasena == $contrasena) {
            //echo "Login exitoso.";
            // Redirigir al usuario a otra página después del login exitoso
            header("Location: main.php");
            exit();
        }
    }

    public function db_insertarRegistro($tabla)
    {

        $query = "INSERT INTO " . $tabla->tabla() . $this->vincularP($tabla); //consulta SQL
        $stmt = $this->conn->prepare($query);
        $this->db_vincular($stmt, $tabla);


        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function db_BuscarRegistro($dato, $tabla, $campo)
    // busca en la base de datos un dato especifico, y lo debuelve resultados en formato Json
    {
        try {
            // Preparar la consulta SQL
            $stmt = $this->conn->prepare("SELECT * FROM " . $tabla->tabla() . " WHERE " . $tabla->campo($campo) . " = :" . $tabla->campo($campo));
            // Vincular los parámetros
            $stmt->bindParam(':' . $tabla->campo($campo), $dato, PDO::PARAM_STR);

            //var_dump($stmt);
            // Ejecutar la consulta
            $stmt->execute();
            // Obtener el resultado
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $datos;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public function db_eliminarElemento($tabla, $campo)
    //busca por id en la base de dato y elimina el registro
    {
        try {
            //  DELETE FROM tabla WHERE campo = valor
            $stmt = $this->conn->prepare('DELETE FROM ' . $tabla->tabla() . ' WHERE ' . $tabla->campo($campo) . " = :" . $tabla->campo($campo));

            $stmt->bindParam(':' . $tabla->campo(0), $tabla->{$tabla->campo(0)}, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public function db_actualizarRegistro($tabla, $campo)
    { //busca por id en la base de datos y actualiza todos los registros
        //UPDATE nombretabla SET NombreCampo = Valor WHERE uncampo = otroValor
        // echo ('UPDATE ' . $tabla->tabla() . ' SET ' . $this->todosLosCampos($tabla) . ' WHERE ' . $tabla->campo($campo) . " = :" . $tabla->campo($campo));
        try {
            $stmt = $this->conn->prepare('UPDATE ' . $tabla->tabla() . ' SET ' . $this->todosLosCampos($tabla) . ' WHERE ' . $tabla->campo($campo) . " = :" . $tabla->campo($campo));
            $stmt->bindParam(':' . $tabla->campo(0), $tabla->{$tabla->campo(0)}, PDO::PARAM_STR);
            // $tabla->db_vincular($stmt);


            $this->db_vincular($stmt, $tabla);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
    public function listar($tabla)
    {
        $result = $this->db_consulta("SELECT * FROM " . $tabla->tabla());
        return $result;
    }
    public function buscar($query, $tabla, $campo)
    {
        try {

            $stmt = $this->conn->prepare("SELECT * FROM " . $tabla->tabla() . " WHERE " . $tabla->campo($campo) . " LIKE :query");
            $likeQuery = "%$query%";
            $stmt->bindParam(':query', $likeQuery, PDO::PARAM_STR);
            $stmt->execute();

            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (PDOException $e) {
            // Log error instead of echoing
            error_log("Database error: " . $e->getMessage());
        }
    }

    public function getAlumnosMateria($idMateria)
    {
        $alumno = new Alumno;
        $cursada = new CursadaAlumnos;
        $result = $this->db_consulta(
            "SELECT * FROM " . $alumno->tabla() .
                " INNER JOIN " . $cursada->tabla() .
                " ON " . $alumno->tabla() . "." . $alumno->campo(0) . " = " . $cursada->tabla() . "." . $cursada->campo(1) .
                " WHERE " . $cursada->tabla() . "." . $cursada->campo(2) . " = " . $idMateria
        );
        return $result;
    }
    public function asistenciasTomadas($id_materia, $fecha)
    { //crea un array con los alumnos de la materia que ya tiene vectorListaAlumnos en un determinado dia
        $asistencia = new Asistencia;
        $asistenciastomadas = $this->db_BuscarRegistro($fecha, $asistencia, 1);
        $vectorListaAlumnos = [];
        foreach ($asistenciastomadas as $aux) {
            if ($aux['id_materia'] == $id_materia) {
                $auxi = ['id_alumno' => $aux['id_alumno'], 'id_asistencia' => $aux['id_asistencias']];
                array_push($vectorListaAlumnos, $auxi);
            }
        }

        return $vectorListaAlumnos;
    }

    public function tomarAsistencia($materia_id, $array, $fecha)
    {
        //$array que contiene arrays estructurados de la siguiente forma:
        //[id_alumno,bolean]
        $asistencia = new Asistencia;


        $vectorListaAlumnos = $this->asistenciasTomadas($materia_id, $fecha);

        // foreach($array as $index => $n){echo $n["estado"]." array ",$index."<br>";}
        foreach ($array as $alumno) {
            /*
                si MP y A = Ingresar       1 0 = 1
                si MP y P = nada           1 1 = 0
                si MA y A = nada           0 0 = 0
                si MA y P = elimino        0 1 = 1
                
                */


            $aux = $this->En_Array(intval($alumno["id_alumno"]), $vectorListaAlumnos, "id_alumno");
            // echo $aux." Aux";

            if ($alumno["estado"] && !$aux) {
                $asistencia->cargaRapida(0, intval($materia_id), intval($alumno["id_alumno"]), $fecha);
                // echo " Ingresado <br>";
                $this->db_insertarRegistro($asistencia);
            }
            if (!$alumno["estado"] && $aux) {

                foreach ($vectorListaAlumnos as $p) {

                    if ($p['id_alumno'] === $alumno['id_alumno']) {
                        $asistencia->cargaRapida(intval($p['id_asistencia']), intval($materia_id), intval($alumno["id_alumno"]), $fecha);
                        $this->db_eliminarElemento($asistencia, 0);
                        //  echo "Borrado <br>";
                    }
                }
            }
        }
        $vectorListaAlumnos = $this->asistenciasTomadas($materia_id, $fecha);
        return $vectorListaAlumnos;
    }
    /////////////////////////////////////////////////////////////////
    public function db_CargarDatosAlumnos($datos)
    {
        $nuevoAlumno = new Alumno;
        $this->cargarDatos($nuevoAlumno, $datos);
        if ($this->db_insertarRegistro($nuevoAlumno)) {
            return ["resultadoOperacion" => "exito"];
        } else {
            return ["resultadoOperacion" => "error"];
        }
    }
    public function db_CargarDatosProfesor($datos)
    {
        $nuevoProfesor = new Profesor;
        $this->cargarDatos($nuevoProfesor, $datos);
        if ($this->db_insertarRegistro($nuevoProfesor)) {
            return ["resultadoOperacion" => "exito"];
        } else {
            return ["resultadoOperacion" => "error"];
        }
    }
    public function db_CargarDatosInstituto($datos)
    {
        $ram = new RAM;
        $nuevoInstituto = new Instituto;
        $this->cargarDatos($nuevoInstituto, $datos);
        $this->cargarDatos($ram, $datos);
        if ($this->db_insertarRegistro($nuevoInstituto)) {
            $this->db_insertarRegistro($ram);
            return ["resultadoOperacion" => "exito"];
        } else {
            return  ["resultadoOperacion" => "error"];
        }
    }
    public function actualizarInstituto($datos)
    {
        $instituto = new Instituto;
        $ram = new RAM;
        $this->cargarDatos($instituto, $datos);
        $this->cargarDatos($ram, $datos);
        $instituto->id_instituto = $datos['id_instituto'];
        $ram->id_ram = $datos['id_ram'];
        if ($this->db_actualizarRegistro($instituto, 0) && $this->db_actualizarRegistro($ram, 0)) {
            return ["resultadoOperacion" => "exito"];
        } else {
            return  ["resultadoOperacion" => "error"];
        }
    }
    public function db_CargarDatosMateria($datos)
    {
        $materia = new Materia;
        $this->cargarDatos($materia, $datos);

        if ($this->db_insertarRegistro($materia)) {
            return ["resultadoOperacion" => "exito"];
        } else {
            return  ["resultadoOperacion" => "error"];
        }
    }
    public function db_EditarDatosProfesor($datos)
    {
        $profesor = new Profesor;
        $this->cargarDatos($profesor, $datos);
        $profesor->id_profesores = $datos['id_profesores'];
        if ($this->db_actualizarRegistro($profesor, 0)) {
            return ["resultadoOperacion" => "exito"];
        } else {
            return  ["resultadoOperacion" => "error"];
        }
    }
    public function db_EditarDatosAlumnos($datos)
    {
        $Alumnos = new Profesor;
        $this->cargarDatos($Alumnos, $datos);
        $Alumnos->id_profesores = $datos['id_alumno'];
        if ($this->db_actualizarRegistro($Alumnos, 0)) {
            return ["resultadoOperacion" => "exito"];
        } else {
            return  ["resultadoOperacion" => "error"];
        }
    }
    /////////////////////ASISTENCIAS////////////////////////////////////////////
    public function db_MateriaTotalDias($id_materia)
    {
        $results = $this->db_consulta(
            "SELECT COUNT(DISTINCT fecha) total 
            FROM asistencias 
            WHERE id_materia = $id_materia"
        );
        return array_pop($results[0]);
    }
    public function db_MateriaAlumnoTotalAsistencias($id_materia, $id_alumno)
    {

        $results = $this->db_consulta(
            "SELECT COUNT(DISTINCT fecha) total
                FROM asistencias
                WHERE id_materia = $id_materia and id_alumno = $id_alumno"
        );
        return array_pop($results[0]);
    }
    public function porcentajeAsistencias($id_materia, $id_alumno)
    {
        $asistenciasAlumno = $this->db_MateriaAlumnoTotalAsistencias($id_materia, $id_alumno);
        $diasDeClase = $this->db_MateriaTotalDias($id_materia);
        $porcentaje = $asistenciasAlumno / $diasDeClase;
        return  ["dias_clases" => $diasDeClase, "asistencias" => $asistenciasAlumno, "porcentaje" => $porcentaje];
    }
    public function todosPorcentajeAsistencias($id_materia)
    {
        $aux = [];
        $listaAlumnos = $this->getAlumnosMateria($id_materia);
        $diasDeClase = $this->db_MateriaTotalDias($id_materia);
        foreach ($listaAlumnos as $alumno) {
            $asistencias = $this->db_MateriaAlumnoTotalAsistencias($id_materia, $alumno['id_alumno']);
            $porcentaje = $asistencias / $diasDeClase;
            $nuevosDatos = ["dias_clases" => $diasDeClase, "asistencias" => $asistencias, "porcentaje" => $porcentaje];
            array_push($aux, array_merge($alumno, $nuevosDatos));
        }
        return $aux;
    }
    public function listarFechaAsistencias($id_materia)
    {
        $results = $this->db_consulta(
            "SELECT DISTINCT fecha FROM asistencias WHERE id_materia= $id_materia"
        );
        return $results;
    }
    ///////////////////////////////////////////////////////////////
    public function db_inscribirAlumnoMateria($id_materia, $id_alumno)
    {
        $cursada = new CursadaAlumnos;
        $cursada->id_cursadasalumnos = 0;
        $cursada->id_materia = $id_materia;
        $cursada->id_alumno = $id_alumno;
        if ($this->db_insertarRegistro($cursada)) {
            return ["resultadoOperacion" => "exito"];
        } else {
            return  ["resultadoOperacion" => "error"];
        }
    }
    public function inscribirAlumnosMateria($id_materia, $array)
    {
        $resultados = [];
        $cursada = new CursadaAlumnos;
        $aux = $this->getAlumnosInscriptos($id_materia);
        // var_dump(($aux));
        foreach ($array as $key => $alumno) {
            $inscripto = $this->En_Array(intval($alumno["id_alumno"]), $aux, "id_alumno");
            if ($alumno['estado'] && !$inscripto) {

                $res = $this->db_inscribirAlumnoMateria($id_materia, $alumno['id_alumno']);
                array_push($resultados, [$alumno["id_alumno"], 'inscripto']);
            }
            if (!$alumno['estado'] && $inscripto) {
                foreach ($aux as $alumnoInscriptos) {
                    if ($alumno['id_alumno'] === $alumnoInscriptos['id_alumno']) {
                        $cursada->cargaRapida($alumnoInscriptos['id_cursadasalumnos'], 0, 0);
                        $this->db_eliminarElemento($cursada, 0);
                    }
                }
                array_push($resultados, [$alumno["id_alumno"], 'dado de baja']);
            }
        }


        return $resultados;
    }


    public function listaMateriasPorInstitutoProfesor($id_profesor, $id_instituto)
    {

        $conditions = [];

        // Add conditions based on whether each parameter is provided
        if (!empty($id_profesor)) {
            $conditions[] = "id_profesor = $id_profesor";
        }
        if (!empty($id_instituto)) {
            $conditions[] = "id_instituto = $id_instituto";
        }

        // Base query
        $consulta = "SELECT * FROM materia";

        // If there are any conditions, append them to the query
        if (!empty($conditions)) {
            $consulta .= " WHERE " . implode(" AND ", $conditions);
        }

        $result = $this->db_consulta($consulta);
        return $result;
    }

    public function getAlumnosInscriptos($id_materia)
    {
        $result = $this->db_consulta("SELECT * FROM cursadasalumnos WHERE $id_materia= id_materia");
        return $result;
    }
    ///Manejo Notas y evaluaciones////
    public function db_CargarDatosNotas($id_alumno, $id_instanciaEvaluativa, $calificacion)
    {
        $aux = [];
        $nota = new Nota();
        $nota->cargaRapida($id_alumno, $id_instanciaEvaluativa, $calificacion);
        $CalificacioesGuardadas = $this->getNotasDeInstanciaEvaluativa($id_instanciaEvaluativa);
        if ($this->En_Array($id_alumno, $CalificacioesGuardadas, 'id_alumno', $aux)) {
            $nota->id_notas = $aux[0]['id_notas'];

            if ($this->db_actualizarRegistro($nota, 0)) {
                return ["resultadoOperacion" => "exito", 'id_alumno' => $id_alumno];
            } else {
                return  ["resultadoOperacion" => "error", 'id_alumno' => $id_alumno];
            }
        } else {

            if ($this->db_insertarRegistro($nota)) {
                return ["resultadoOperacion" => "exito", 'id_alumno' => $id_alumno];
            } else {
                return  ["resultadoOperacion" => "error", 'id_alumno' => $id_alumno];
            }
        }
    }
    public function db_CargarDatosInstanciaEvaluativa($datos)
    {
        $InstanciaEvaluativa = new InstanciaEvaluativa;
        $this->cargarDatos($InstanciaEvaluativa, $datos);
        //$InstanciaEvaluativa->cargaRapida($id_materia, $titulo, $descripcion, $fecha,$id_recuperatorio);
        //$this->cargarDatos($InstanciaEvaluativa, $datos);
        if ($this->db_insertarRegistro($InstanciaEvaluativa)) {
            return ["resultadoOperacion" => "exito"];
        } else {
            return  ["resultadoOperacion" => "error"];
        }
    }
    public function db_eliminarElemento_Notas($id_notas)
    {
        $notas = new Nota();
        $notas->id_notas = $id_notas;
        $this->db_eliminarElemento($notas, 0);
    }
    public function db_eliminarElemento_InstanciaEvaluativa($id_instanciaEvaluativa)
    {
        $id_instanciaEvaluativa = new InstanciaEvaluativa;
        $id_instanciaEvaluativa->id = $id_instanciaEvaluativa;
        $this->db_eliminarElemento($id_instanciaEvaluativa, 0);
    }
    public function getInstancisasEvaluativas($id_materia)
    {
        $result = $this->db_consulta("SELECT * FROM instancias_evaluativas WHERE $id_materia= id_materia");
        return $result;
    }
    public function getNotasDeInstanciaEvaluativa($id_instanciaEvaluativa)
    {
        $result = $this->db_consulta("SELECT * FROM notas WHERE  notas.id_InstanciaEvaluativa=$id_instanciaEvaluativa");
        return $result;
    }

    public function db_getCalificacionesAlumno($id_alumno, $id_materia)
    {
        $resultado = $this->db_consulta("SELECT id_instanciaEvaluativa, titulo, id_recuperatorio, calificacion FROM instancias_evaluativas i 
        INNER JOIN notas n ON i.id_instancias_evaluativas=n.id_instanciaEvaluativa 
        WHERE i.id_materia=$id_materia AND n.id_alumno=$id_alumno
        ");
        return $resultado;
    }

    public function getNotasAlumno($id_alumno, $id_materia) //devuelve un array con las notas del almno, si hay un recuperatorio toma en cuenta solo la mas alta de los dos
    {

        $resultado = $this->db_getCalificacionesAlumno($id_alumno, $id_materia,);
        $notas = [];
        $recuperatorios = [];
        foreach ($resultado as $calificacion) {

            if ($calificacion['id_recuperatorio'] == 0) {
                array_push($notas, $calificacion);
                //var_dump($calificacion);
            } else {
                array_push($recuperatorios, $calificacion);
                //  var_dump($calificacion); 
            }
        }

        foreach ($notas as &$calific) { // & simbol referencia los elementos originales del array
            foreach ($recuperatorios as $recu) {
                if (($recu['id_recuperatorio'] == $calific['id_instanciaEvaluativa'])) {
                    if ($recu['calificacion'] > $calific['calificacion']) {
                        $calific = $recu;
                        //var_dump($calific);
                    }
                }
            }
        }

        return $notas;
    }

    public function IngresarNotas($id_instancisasEvaluativas, $notas)
    {

        $result = [];
        foreach ($notas as $alumno) {

            if ($alumno['calificacion'] > 0) {

                array_push($result, $this->db_CargarDatosNotas($alumno['id_alumno'], $id_instancisasEvaluativas, $alumno['calificacion']));
            }
        }
        return $result;
    }
    public function getRam($id_materia)
    {

        $materias = $this->db_consulta("SELECT * FROM materia WHERE materia.id_materia = $id_materia");
        $aux = $materias[0]['id_instituto'];
        $ram = $this->db_consulta("SELECT * FROM ram WHERE ram.id_ram =$aux ");
        return array_pop($ram);
    }
}
