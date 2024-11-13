<?php
class Alumno
{

    private $table = 'alumnos';

    public $id_alumno;
    public $nombre;
    public $apellido;
    public $dni;
    public $correo_electronico;
    public $telefono;
    public $fecha_nacimiento;


    public function tabla()
    {
        return $this->table;
    }
    // Método para bind Parametros un nuevo alumno
    
   
    public function campo($campo) 
    {
        switch($campo){
            case 0: return 'id_alumno';break;
            case 1: return 'nombre';break;
            case 2: return 'apellido';break;
            case 3: return 'dni';break;
            case 4: return 'correo_electronico';break;
            case 5: return 'telefono';break;
            case 6: return 'fecha_nacimiento';break;
            
        }
    }
    
}  
?>
