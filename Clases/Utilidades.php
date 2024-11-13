<?php
trait Utilidades{
   

    public function clean_input($data)
    {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    private function todosLosCampos($tabla) //crea un string para una consulta html
    {
        $aux = $tabla->campo(1) . " = :" . $tabla->campo(1);
        for ($i = 2; $i <= 10; $i++) {
            if ($tabla->campo($i) <> '') {
                $aux = $aux . ' , ' . $tabla->campo($i) . " = :" . $tabla->campo($i);
            }
        }
        return $aux;
    }
    public function vincularP($tabla)
    { //(nombre, apellido, dni, correo_electronico, telefono, fecha_nacimiento) 
        //VALUES (:nombre, :apellido, :dni, :correo_electronico, :telefono, :fecha_nacimiento)

        $aux = '(' . $tabla->campo(1);
        for ($i = 2; $i <= 12; $i++) {
            if ($tabla->campo($i) <> '') {
                $aux = $aux . ', ' . $tabla->campo($i);
            }
        }
        $aux = $aux . ') VALUES (:' . $tabla->campo(1);
        for ($i = 2; $i <= 12; $i++) {
            if ($tabla->campo($i) <> '') {
                $aux = $aux . ', :' . $tabla->campo($i);
            }
        }
        $aux = $aux . ')';
        return $aux;
    }
    public function cargarDatos($tabla, $aux) //asigna array de base de datos al ojeto seleccionado
    {
        for ($i = 0; $i <= 10; $i++) {
            if ($tabla->campo($i) <> '' and isset($aux[$tabla->campo($i)])) {
                $tabla->{$tabla->campo($i)} = $this-> clean_input( $aux[$tabla->campo($i)]);
            }
        }
    }
    public function En_Array($valor, $array, $llave, &$elementos=[])//devuelve verdadero si el elemento se encuentra en el array.
    {
        $resultado = False;
       
        foreach ($array as $elemento) {
            if ($valor == $elemento[$llave]) {
                $resultado = True;
                array_push($elementos,$elemento);
            }
        }

        return $resultado;
    }

   

}


