<?php
require 'Clases/conexion.php';
header('Content-Type: application/json');
$basededatos=new Database;
$profesor=new Profesor;
$alumno=new Alumno;
$materia=new Materia;
$aux=$_GET['tabla'];


/*switch($aux){
case 'profesor':$basededatos->Buscar($_GET['q'],$profesor,$_GET['campo']);break;
case 'alumno':$basededatos->Buscar($_GET['q'],$alumno,$_GET['campo']);break;
case 'materia':$basededatos->Buscar($_GET['q'],$materia,$_GET['campo']); break;

}



?>