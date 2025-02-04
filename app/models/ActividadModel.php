<?php
require_once __DIR__ . '/../core/Database.php';

class ActividadModel {
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todas las actividades con su valor
    public function readActividades(): array|false
    {
        try {
            $stmt = $this->db->query("SELECT id_actividad, detalle, valor FROM actividades");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readActividades: " . $e->getMessage());
            return false;
        }
    }

    // Obtener una actividad específica por su ID con su valor
    public function readActividadPorId(int $id_actividad): array|false
    {
        try {
            $stmt = $this->db->prepare("SELECT id_actividad, detalle, valor FROM actividades WHERE id_actividad = ?");
            $stmt->execute([$id_actividad]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en readActividadPorId: " . $e->getMessage());
            return false;
        }
    }

    // Crear una nueva actividad con su valor
    public function createActividad(string $detalle, float $valor): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO actividades (detalle, valor) VALUES (?, ?)");
            return $stmt->execute([$detalle, $valor]);
        } catch (PDOException $e) {
            error_log("Error en createActividad: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una actividad existente con su valor
    public function updateActividad(int $id_actividad, string $detalle, float $valor): bool
    {
        try {
            $stmt = $this->db->prepare("UPDATE actividades SET detalle = ?, valor = ? WHERE id_actividad = ?");
            return $stmt->execute([$detalle, $valor, $id_actividad]);
        } catch (PDOException $e) {
            error_log("Error en updateActividad: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar una actividad por su ID
    public function deleteActividad(int $id_actividad): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM actividades WHERE id_actividad = ?");
            return $stmt->execute([$id_actividad]);
        } catch (PDOException $e) {
            error_log("Error en deleteActividad: " . $e->getMessage());
            return false;
        }
    }
}