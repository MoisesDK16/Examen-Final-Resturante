<?php

class Clase_Conectar {
    private $conexion;
    private $server = "localhost";
    private $usuario = "root"; 
    private $pass = ""; 
    private $base = "gestionrestaurante";

    public function conectar() {
        $this->conexion = new mysqli($this->server, $this->usuario, $this->pass, $this->base);
        
        if ($this->conexion->connect_error) {
            die("Error al conectar con MySQL: " . $this->conexion->connect_error);
        }

        if (!$this->conexion->set_charset("utf8")) {
            die("Error al establecer el charset UTF-8: " . $this->conexion->error);
        }
        return $this->conexion;
    }   
}
?>
