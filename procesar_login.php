<?php
require 'Clases/conexion.php';


$data = $_POST;
$baseDeDatos = new Database;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
$baseDeDatos->logindb($data);
} else {
    // Si no se recibieron los valores por POST, mostrar un mensaje de error
    echo "Error: No se recibieron los valores por POST.";
}

