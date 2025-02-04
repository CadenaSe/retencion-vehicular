<?php
require_once __DIR__ . '/../core/Database.php';

class ResponsableModel {
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todos los responsables
    public function readResponsables(): array|false
    {
        try {
            $stmt = $this->db->query("SELECT * FROM responsables");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readResponsables: " . $e->getMessage());
            return false;
        }
    }

    // Obtener un responsable específico por cédula
    public function readResponsablePorCedula(string $cedula_responsable): array|false
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM responsables WHERE cedula_responsable = ?");
            $stmt->execute([$cedula_responsable]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en readResponsablePorCedula: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo responsable
    public function createResponsable(string $cedula_responsable, string $nombres, string $apellidos, string $email): bool
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO responsables (cedula_responsable, nombres_responsable, apellidos_responsable, email_responsable) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$cedula_responsable, $nombres, $apellidos, $email]);
        } catch (PDOException $e) {
            error_log("Error en createResponsable: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un responsable existente
    public function updateResponsable(string $cedula_responsable, string $nombres, string $apellidos, string $email): bool
    {
        try {
            $stmt = $this->db->prepare("UPDATE responsables SET nombres_responsable = ?, apellidos_responsable = ?, email_responsable = ? WHERE cedula_responsable = ?");
            return $stmt->execute([$nombres, $apellidos, $email, $cedula_responsable]);
        } catch (PDOException $e) {
            error_log("Error en updateResponsable: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un responsable por su cédula
    public function deleteResponsable(string $cedula_responsable): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM responsables WHERE cedula_responsable = ?");
            return $stmt->execute([$cedula_responsable]);
        } catch (PDOException $e) {
            error_log("Error en deleteResponsable: " . $e->getMessage());
            return false;
        }
    }
}
