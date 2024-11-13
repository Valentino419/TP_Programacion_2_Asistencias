<?php
class Materia
{
    private $table='materia';

    public $id_materia;
   
    public $nombre;   
    public $id_instituto;
    public $id_profesor;
   

    public function tabla(){ return $this->table; }

    // Método para bind Parametros un nuevo alumno
   
   
   
    public function campo($campo) 
    {
        switch($campo){
            case 0: return 'id_materia';break;         
            case 1: return 'nombre';break;        
            case 2: return 'id_instituto';break;
            case 3: return 'id_profesor';break;
            
        }
    }
}




?>