<?php
class Asistencia
{
    private $table = 'asistencias';

    public $id;
    public $fecha;
    public $id_alumno;
    public $id_materia;

    public function cargaRapida($id,$id_materia,$id_alumno,$fecha){
        $this->fecha=$fecha;
        $this->id_materia=$id_materia;
        $this->id_alumno=$id_alumno;
        $this->id=$id;
    }
    public function tabla()
    {
        return $this->table;
    }
    public function campo($campo) 
    {
        switch($campo){
            case 0: return 'id_asistencias';break;
            case 1: return 'fecha';break;
            case 2: return 'id_alumno';break;
            case 3: return 'id_materia';break;
        }
    }

}
?>