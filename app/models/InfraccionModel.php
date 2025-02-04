<?php

require_once __DIR__ . '/../core/Database.php';

class InfraccionModel {
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todas las infracciones
    public function readInfracciones(): array|false
    {
        try {
            $stmt = $this->db->query("SELECT * FROM infracciones");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readInfracciones: " . $e->getMessage());
            return false;
        }
    }

    // Obtener una infracción específica por su código
    public function readInfraccionPorCodigo(string $codigo_infraccion): array|false
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM infracciones WHERE codigo_infraccion = ?");
            $stmt->execute([$codigo_infraccion]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en readInfraccionPorCodigo: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva infracción
    public function createInfraccion(string $codigo_infraccion, string $detalle): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO infracciones (codigo_infraccion, detalle) VALUES (?, ?)");
            return $stmt->execute([$codigo_infraccion, $detalle]);
        } catch (PDOException $e) {
            error_log("Error en createInfraccion: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una infracción existente
    public function updateInfraccion(string $codigo_infraccion, string $detalle): bool
    {
        try {
            $stmt = $this->db->prepare("UPDATE infracciones SET detalle = ? WHERE codigo_infraccion = ?");
            return $stmt->execute([$detalle, $codigo_infraccion]);
        } catch (PDOException $e) {
            error_log("Error en updateInfraccion: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una infracción por su código
    public function deleteInfraccion(string $codigo_infraccion): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM infracciones WHERE codigo_infraccion = ?");
            return $stmt->execute([$codigo_infraccion]);
        } catch (PDOException $e) {
            error_log("Error en deleteInfraccion: " . $e->getMessage());
            return false;
        }
    }
}
