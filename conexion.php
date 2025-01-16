<?php

class Conexion
{
    private $host = 'localhost'; // Cambia según tu configuración
    private $dbname = 'tarifas_envio_cliente'; // Nombre de la base de datos
    private $username = 'root'; // Usuario de la base de datos
    private $password = ''; // Contraseña del usuario
    private $charset = 'utf8mb4'; // Codificación de caracteres
    private $pdo;

    public function conectar() {
        try {
            // Establecer conexión usando PDO
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}",
                $this->username,
                $this->password
            );

            // Configurar opciones de PDO
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $this->pdo; // Retornar la conexión
        } catch (PDOException $e) {
            // Manejo de errores
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}