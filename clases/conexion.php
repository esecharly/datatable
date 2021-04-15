<?php
    class conectar{
        public function conexion(){
            $conexion = mysqli_connect('localhost', 'root', '', 'juegos');

            return $conexion;
        }
    }

    /* $obj = new conectar();

    if ($obj->conexion()) {
        echo "conectado";
    } */
?>