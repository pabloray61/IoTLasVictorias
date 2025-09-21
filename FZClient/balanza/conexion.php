<?php

class conexion {
    const servidor = 'localhost';
    const user = 'u456949381_pablo';
    const pass ='Pablo-2025';
    const bd = 'u456949381_sensores';


    public function conectarbd() {
        $conectar = new mysqli(self::servidor, self::user, self::pass, self::bd);
        if ($conectar->connect_errno){
            die("Error de conexión: " . $conectar->connect_error);  
        }
        return $conectar;           
    }
}
?>

