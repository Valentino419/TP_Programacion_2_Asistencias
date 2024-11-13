<?php
class Instituto
{
    private $table='instituto';
    public $id_instituto;
    public $cue;
    public $nombre;
    public $direccion;
    public $telefono;
    public $correo_electronico;
    

    public function tabla()
    {
        return $this->table;
    }
    // Método para bind Parametros un nuevo alumno
   
  
    public function campo($campo) 
    {
        switch($campo){
            case 0: return 'id_instituto';break;
            case 1: return 'CUE'; break;
            case 2: return 'nombre';break;
            case 3: return 'direccion';break;
            case 4: return 'correo_electronico';break;
            case 5: return 'telefono';break;
           
        }
    }
}

class RAM {

    private $table='ram';
    public $id_ram;
    public $id_instituto;
    public $notaPromocion;
    public $notaRegularizacion;
    public $pAsisPromocion;
    public $pAsisRegularizacion;

    public function tabla()
    {
        return $this->table;
    }

    public function campo($campo) 
    {
        switch($campo){
            case 0:return 'id_ram';break;
            case 1: return 'id_instituto';break;            
            case 2: return 'notaPromocion';break;
            case 3: return 'notaRegularizacion';break;
            case 4: return 'pAsisPromocion' ;break;
            case 5: return 'pAsisRegularizacion';break;
        }
    }
}