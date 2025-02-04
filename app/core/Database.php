<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $configs = require __DIR__ . '/../config/configs.php';
        $db = $configs['database'];

        try {
            $this->pdo = new PDO(
                "mysql:host={$db['host']};dbname={$db['name']};port={$db['port']}",
                $db['user'],
                $db['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error en la conexión a la base de datos: " . $e->getMessage());
        }
    }

    // Método para obtener una única instancia de la base de datos (Patrón Singleton)
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Método para obtener la conexión PDO
    public function getConnection()
    {
        return $this->pdo;
    }
}
