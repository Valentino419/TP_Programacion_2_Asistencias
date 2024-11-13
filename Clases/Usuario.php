<?php
class Usuario
{
    private $table = 'usuarios';
    public $id;
    public $nombre;
    public $apellido;
    public $correo_electronico;
    public $telefono;
    public $usuario;
    public $contrasena;

    public function tabla()
    {
        return $this->table;
    }
    public function campo($campo) 
    {
        switch($campo){
            case 0: return 'id';break;
            case 1: return 'nombre';break;
            case 2: return 'apellido';break;
            case 3: return 'correo_electronico';break;
            case 4: return 'telefono';break;
            case 5: return 'usuario';break;
            case 6: return 'contrasena';break;       
        }
    }
}

?>