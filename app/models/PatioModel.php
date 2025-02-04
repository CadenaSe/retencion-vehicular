<?php

require_once __DIR__ . '/../core/Database.php';

class PatioModel {
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todos los patios
    public function readPatios(): array|false
    {
        try {
            $stmt = $this->db->query("SELECT * FROM patios");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readPatios: " . $e->getMessage());
            return false;
        }
    }

    // Obtener un patio por su código
    public function readPatioPorCodigo(string $codigo_patio): array|false
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM patios WHERE codigo_patio = ?");
            $stmt->execute([$codigo_patio]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en readPatioPorCodigo: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo patio
    public function createPatio(string $codigo_patio, string $detalle, string $direccion): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO patios (codigo_patio, detalle, direccion) VALUES (?, ?, ?)");
            return $stmt->execute([$codigo_patio, $detalle, $direccion]);
        } catch (PDOException $e) {
            error_log("Error en createPatio: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un patio existente
    public function updatePatio(string $codigo_patio, string $detalle, string $direccion): bool
    {
        try {
            $stmt = $this->db->prepare("UPDATE patios SET detalle = ?, direccion = ? WHERE codigo_patio = ?");
            return $stmt->execute([$detalle, $direccion, $codigo_patio]);
        } catch (PDOException $e) {
            error_log("Error en updatePatio: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un patio por su código
    public function deletePatio(string $codigo_patio): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM patios WHERE codigo_patio = ?");
            return $stmt->execute([$codigo_patio]);
        } catch (PDOException $e) {
            error_log("Error en deletePatio: " . $e->getMessage());
            return false;
        }
    }
}
