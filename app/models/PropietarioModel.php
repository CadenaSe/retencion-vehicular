<?php

require_once __DIR__ . '/../core/Database.php';

class PropietarioModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todos los propietarios
    public function readPropietarios(): array|false
    {
        try {
            $stmt = $this->db->query("
            SELECT 
                p.cedula_propietario AS cedula, 
                p.nombres, 
                p.apellidos, 
                p.telefono, 
                u.usuario, 
                u.correo, 
                u.id_rol, 
                u.creado_en
            FROM propietarios p
            LEFT JOIN usuarios u ON p.cedula_propietario = u.cedula
        ");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readPropietarios: " . $e->getMessage());
            return false;
        }
    }

    // Obtener un propietario por su cédula
    public function readPropietarioByCedula(string $cedula): array|false
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM propietarios WHERE cedula_propietario = ?");
            $stmt->execute([$cedula]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en readPropietarioByCedula: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo propietario
    public function createPropietario(string $cedula, string $nombres, string $apellidos, string $telefono, string $correo, string $contrasenia): bool
    {
        try {
            // Iniciar una transacción para asegurar que ambas inserciones sean exitosas
            $this->db->beginTransaction();

            // Insertar en la tabla propietarios
            $stmtPropietario = $this->db->prepare("
            INSERT INTO propietarios (cedula_propietario, nombres, apellidos, telefono) 
            VALUES (?, ?, ?, ?)
            ");
            $stmtPropietario->execute([$cedula, $nombres, $apellidos, $telefono]);

            // Determinar el rol de usuario (suponiendo que el ID del rol de usuario es 3)
            $idRolUsuario = 3;

            // Insertar en la tabla usuarios
            $stmtUsuario = $this->db->prepare("
            INSERT INTO usuarios (usuario, cedula, nombres, apellidos, correo, telefono, contraseña, id_rol) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmtUsuario->execute([$cedula, $cedula, $nombres, $apellidos, $correo, $telefono, $contrasenia, $idRolUsuario]);

            // Confirmar la transacción
            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            error_log("Error en createPropietario: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un propietario
    public function updatePropietario(
        string  $cedula,
        string  $nombres,
        string  $apellidos,
        string $telefono,
        string  $correo,
        ?string $contrasenia = null
    ): bool
    {
        try {
            $this->db->beginTransaction();

            $stmtPropietario = $this->db->prepare("
            UPDATE propietarios 
            SET nombres = ?, apellidos = ?, telefono = ?
            WHERE cedula_propietario = ?
            ");
            $stmtPropietario->execute([$nombres, $apellidos, $telefono, $cedula]);

            $stmtUsuario = $this->db->prepare("
            UPDATE usuarios 
            SET nombres = ?, apellidos = ?, correo = ?, telefono = ?
            WHERE cedula = ?
            ");
            $stmtUsuario->execute([$nombres, $apellidos, $correo, $telefono, $cedula]);

            if (!empty($contrasenia)) {
                $stmtContrasenia = $this->db->prepare("
                UPDATE usuarios 
                SET contraseña = ?
                WHERE cedula = ?
            ");
                $stmtContrasenia->execute([$contrasenia, $cedula]);
            }

            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error en updatePropietario: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un propietario
    public function deletePropietario(string $cedula): bool
    {
        try {
            // Iniciar una transacción para garantizar la integridad
            $this->db->beginTransaction();

            // Eliminar el usuario asociado
            $stmtUsuario = $this->db->prepare("DELETE FROM usuarios WHERE cedula = ?");
            $stmtUsuario->execute([$cedula]);

            // Eliminar el propietario
            $stmtPropietario = $this->db->prepare("DELETE FROM propietarios WHERE cedula_propietario = ?");
            $stmtPropietario->execute([$cedula]);

            // Confirmar la transacción
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            // En caso de error, revertir la transacción
            $this->db->rollBack();
            error_log("Error en deletePropietario: " . $e->getMessage());
            return false;
        }
    }
}
