<?php
class Database {
    // configuracion
    private string $host = "db";
    private string $nombreBase = "pruebadb";
    private string $usuario = "root";
    private string $clave = "pass1234";
    private ?PDO $conexion = null;

    public function conectar(): ?PDO {
        $this->conexion = null;

        try {
            $param = "mysql:host=" . $this->host . ";dbname=" . $this->nombreBase . ";charset=utf8mb4";
            $this->conexion = new PDO($param, $this->usuario, $this->clave);

            // para depurar
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch(PDOException $excepcion) {
            echo "Error de conexion: " . $excepcion->getMessage();
        }

        return $this->conexion;
    }
}
