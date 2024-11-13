<?php
class Educaen
{
    private $table = 'educaen';

    public $id_educaen;
    public $legajoProfesor;
    public $codigoMateria;
    public $instituto_id;
    public $horas;

    public function tabla()
    {
        return $this->table;
    }
    public function campo($campo) 
    {
        switch($campo){
            case 0: return 'id_educaen';break;
            case 1: return 'legajoProfesor';break;
            case 2: return 'codigoMateria';break;
            case 3: return 'instituto_id';break;
            case 4:return 'horas';break;
        }
    }

}
?>