<?php

require_once __DIR__ . '/../core/Database.php';

class VehiculoModel {
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todos los vehículos
    public function readVehiculos(): array|false
    {
        try {
            $stmt = $this->db->query("
            SELECT 
                v.placa,
                v.anio,
                v.estado,
                v.codigo_marca,
                m.detalle AS marca,
                v.codigo_modelo,
                mo.detalle AS modelo,
                v.cedula_propietario,
                CONCAT(p.nombres, ' ', p.apellidos) AS propietario,
                v.codigo_infraccion,
                i.detalle AS infraccion,
                v.codigo_patio,
                pa.detalle AS patio
            FROM vehiculos v
            LEFT JOIN marcas m ON v.codigo_marca = m.codigo_marca
            LEFT JOIN modelos mo ON v.codigo_modelo = mo.codigo_modelo
            LEFT JOIN propietarios p ON v.cedula_propietario = p.cedula_propietario
            LEFT JOIN infracciones i ON v.codigo_infraccion = i.codigo_infraccion
            LEFT JOIN patios pa ON v.codigo_patio = pa.codigo_patio
        ");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readVehiculos: " . $e->getMessage());
            return false;
        }
    }

    public function readVehiculoPorCedula(string $cedula): array|false
    {
        try {
            $stmt = $this->db->prepare("
            SELECT 
                v.placa,
                v.anio,
                v.estado AS estado_vehiculo,
                v.codigo_marca,
                m.detalle AS marca,
                v.codigo_modelo,
                mo.detalle AS modelo,
                v.cedula_propietario,
                CONCAT(p.nombres, ' ', p.apellidos) AS propietario,
                v.codigo_infraccion,
                i.detalle AS infraccion,
                v.codigo_patio,
                pa.detalle AS patio,
                r.estado AS estado_registro,
                r.codigo_registro AS codigo_registro,
                r.fecha_retener_hasta,
                r.total,
                fp.detalle AS forma_pago
            FROM vehiculos v
            LEFT JOIN marcas m ON v.codigo_marca = m.codigo_marca
            LEFT JOIN modelos mo ON v.codigo_modelo = mo.codigo_modelo
            LEFT JOIN propietarios p ON v.cedula_propietario = p.cedula_propietario
            LEFT JOIN infracciones i ON v.codigo_infraccion = i.codigo_infraccion
            LEFT JOIN patios pa ON v.codigo_patio = pa.codigo_patio
            LEFT JOIN registros r ON v.placa = r.placa_vehiculo
            LEFT JOIN formas_pago fp ON r.id_forma_pago = fp.id_forma_pago
            WHERE v.cedula_propietario = ?
            ORDER BY r.fecha DESC
        ");

            $stmt->execute([$cedula]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readVehiculoPorCedula: " . $e->getMessage());
            return false;
        }
    }

    // Obtener un vehículo por su placa
    public function readVehiculoPorPlaca(string $placa): array|false
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM vehiculos WHERE placa = ?");
            $stmt->execute([$placa]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en readVehiculoPorCodigo: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo vehículo
    public function createVehiculo(string $placa, int $anio, string $estado, string $codigo_marca, string $codigo_modelo, string $cedula_propietario, string $codigo_infraccion, string $codigo_patio): bool
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO vehiculos (placa, anio, estado, codigo_marca, codigo_modelo, cedula_propietario, codigo_infraccion, codigo_patio) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            return $stmt->execute([$placa, $anio, $estado, $codigo_marca, $codigo_modelo, $cedula_propietario, $codigo_infraccion, $codigo_patio]);
        } catch (PDOException $e) {
            error_log("Error en createVehiculo: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar un vehículo existente
    public function updateVehiculo(string $placa, int $anio, string $estado, string $codigo_marca, string $codigo_modelo, string $cedula_propietario, string $codigo_infraccion, string $codigo_patio): bool
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE vehiculos 
                SET anio = ?, estado = ?, codigo_marca = ?, codigo_modelo = ?, cedula_propietario = ?, codigo_infraccion = ?, codigo_patio = ? 
                WHERE placa = ?
            ");
            return $stmt->execute([$anio, $estado, $codigo_marca, $codigo_modelo, $cedula_propietario, $codigo_infraccion, $codigo_patio, $placa]);
        } catch (PDOException $e) {
            error_log("Error en updateVehiculo: " . $e->getMessage());
            return false;
        }
    }

    // Eliminar un vehículo por su placa
    public function deleteVehiculo(string $placa): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM vehiculos WHERE placa = ?");
            return $stmt->execute([$placa]);
        } catch (PDOException $e) {
            error_log("Error en deleteVehiculo: " . $e->getMessage());
            return false;
        }
    }
}
