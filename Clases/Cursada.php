<?php
class CursadaAlumnos
{

    private $table = 'cursadasalumnos';

    public $id_cursadasalumnos;
    public $id_alumno;
    public $id_materia;
   

    public function tabla()
    {
        return $this->table;
    }
    // Método para bind Parametros un nuevo alumno
    public function cargaRapida($id,$id_materia,$id_alumno){
        $this->id_materia=$id_materia;
        $this->id_alumno=$id_alumno;
        $this->id_cursadasalumnos=$id;
    }
   
   
    public function campo($campo) 
    {
        switch($campo){
            case 0: return 'id_cursadasalumnos';break;
            case 1: return 'id_alumno';break;
            case 2: return 'id_materia';break;
          
        }
    }
    
}  

 
?>