<?php

require_once __DIR__ . '/../core/Database.php';

class MarcaModel {
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todas las marcas de vehículos
    public function readMarcas(): array|false
    {
        try {
            $stmt = $this->db->query("SELECT * FROM marcas");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readMarcas: " . $e->getMessage());
            return false;
        }
    }

    // Obtener una marca específica por su código
    public function readMarcaPorCodigo(string $codigo_marca): array|false
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM marcas WHERE codigo_marca = ?");
            $stmt->execute([$codigo_marca]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en readMarcaPorCodigo: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva marca
    public function createMarca(string $codigo_marca, string $detalle): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO marcas (codigo_marca, detalle) VALUES (?, ?)");
            return $stmt->execute([$codigo_marca, $detalle]);
        } catch (PDOException $e) {
            error_log("Error en createMarca: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una marca existente
    public function updateMarca(string $codigo_marca, string $detalle): bool
    {
        try {
            $stmt = $this->db->prepare("UPDATE marcas SET detalle = ? WHERE codigo_marca = ?");
            return $stmt->execute([$detalle, $codigo_marca]);
        } catch (PDOException $e) {
            error_log("Error en updateMarca: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una marca por su código
    public function deleteMarca(string $codigo_marca): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM marcas WHERE codigo_marca = ?");
            return $stmt->execute([$codigo_marca]);
        } catch (PDOException $e) {
            error_log("Error en deleteMarca: " . $e->getMessage());
            return false;
        }
    }
}
