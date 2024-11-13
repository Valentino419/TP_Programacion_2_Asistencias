<?php
class Nota
{
    private $table='notas';

    public $id_notas;
    public $id_alumno;
    public $id_instanciaEvaluativa;  
    public $calificacion; 
   
    
    public function cargaRapida($id_alumno,$id_instanciaEvaluativa,$calificacion)
    {
      $this->id_alumno=$id_alumno;
      $this->id_instanciaEvaluativa=$id_instanciaEvaluativa;
      $this->calificacion=$calificacion;
     
    }
    public function tabla(){ return $this->table; }
    
    public function campo($campo) 
    {
        switch($campo){
            case 0: return 'id_notas';break;
            case 1: return 'id_alumno';break;
            case 2: return 'id_instanciaEvaluativa';break;        
            case 3: return 'calificacion';break;
           
        }
    }
}
class InstanciaEvaluativa {
private $table="instancias_evaluativas";

public $id;
public $id_materia;
public $titulo;
public $descripcion;
public $fecha;
public $id_recuperatorio;

public function tabla(){ return $this->table; }
public function cargaRapida($id_materia,$titulo,$descripcion,$fecha,$id_recuperatorio)
{
  $this->id_materia=$id_materia;
  $this->titulo=$titulo;
  $this->descripcion=$descripcion;
  $this->fecha=$fecha; 
  $this->id_recuperatorio=$id_recuperatorio;
}  
public function campo($campo) 
{
    switch($campo){
        case 0: return 'id';break;
        case 1: return 'id_materia';break;
        case 2: return 'titulo';break;        
        case 3: return 'descripcion';break;
        case 4: return 'fecha';break;
        case 5: return 'id_recuperatorio';break;
       
    }
}

}