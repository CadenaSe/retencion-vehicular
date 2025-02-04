<?php

require_once __DIR__ . '/../core/Database.php';

class ModeloModel {
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todos los modelos de vehículos
    public function readModelos(): array|false
    {
        try {
            $stmt = $this->db->query("SELECT * FROM modelos");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readModelos: " . $e->getMessage());
            return false;
        }
    }

    // Obtener un modelo específico por su código
    public function readModeloPorCodigo(string $codigo_modelo): array|false
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM modelos WHERE codigo_modelo = ?");
            $stmt->execute([$codigo_modelo]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en readModeloPorCodigo: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo modelo
    public function createModelo(string $codigo_modelo, string $detalle): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO modelos (codigo_modelo, detalle) VALUES (?, ?)");
            return $stmt->execute([$codigo_modelo, $detalle]);
        } catch (PDOException $e) {
            error_log("Error en createModelo: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un modelo existente
    public function updateModelo(string $codigo_modelo, string $detalle): bool
    {
        try {
            $stmt = $this->db->prepare("UPDATE modelos SET detalle = ? WHERE codigo_modelo = ?");
            return $stmt->execute([$detalle, $codigo_modelo]);
        } catch (PDOException $e) {
            error_log("Error en updateModelo: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un modelo por su código
    public function deleteModelo(string $codigo_modelo): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM modelos WHERE codigo_modelo = ?");
            return $stmt->execute([$codigo_modelo]);
        } catch (PDOException $e) {
            error_log("Error en deleteModelo: " . $e->getMessage());
            return false;
        }
    }
}
