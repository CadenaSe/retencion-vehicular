<?php

require_once __DIR__ . '/../core/Database.php';

class RegistroModel {
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todas las formas de pago
    public function readFormasPago(): array|false
    {
        try {
            $stmt = $this->db->query("SELECT * FROM formas_pago");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readFormasPago: " . $e->getMessage());
            return false;
        }
    }

    public function readRegistros(): array|false
    {
        try {
            $stmt = $this->db->query("
        SELECT 
            r.codigo_registro,
            r.fecha,
            r.estado,
            r.total,
            r.fecha_retener_hasta,
            fp.detalle AS forma_pago,
            fp.id_forma_pago AS id_forma_pago,
            v.placa AS vehiculo,
            r.placa_vehiculo,
            r.cedula_responsable,
            CONCAT(res.nombres_responsable, ' ', res.apellidos_responsable) AS responsable,
            GROUP_CONCAT(a.id_actividad ORDER BY a.id_actividad SEPARATOR ',') AS actividades
        FROM registros r
        LEFT JOIN formas_pago fp ON r.id_forma_pago = fp.id_forma_pago
        INNER JOIN vehiculos v ON r.placa_vehiculo = v.placa
        INNER JOIN responsables res ON r.cedula_responsable = res.cedula_responsable
        LEFT JOIN detalle_registro dr ON r.codigo_registro = dr.codigo_registro
        LEFT JOIN actividades a ON dr.id_actividad = a.id_actividad
        GROUP BY r.codigo_registro, r.placa_vehiculo, r.cedula_responsable
        ORDER BY r.fecha DESC
    ");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en readRegistros: " . $e->getMessage());
            return false;
        }
    }

    // Crear un nuevo registro (forma de pago es opcional)
    public function createRegistro(
        ?int   $id_forma_pago,
        string $placa_vehiculo,
        string $cedula_responsable,
        string $fecha_retener_hasta,
        string $estado,
        array  $actividades
    ): int|false {
        try {
            $this->db->beginTransaction();

            // Insertar el registro principal en la tabla registros
            $stmt = $this->db->prepare("
            INSERT INTO registros (id_forma_pago, placa_vehiculo, cedula_responsable, estado, fecha_retener_hasta, total) 
            VALUES (?, ?, ?, ?, ?, 0)
            ");
            $stmt->execute([
                $id_forma_pago ?? null,  // Si no se selecciona, se inserta NULL
                $placa_vehiculo,
                $cedula_responsable,
                $estado,
                $fecha_retener_hasta
            ]);

            $codigo_registro = $this->db->lastInsertId();
            if (!$codigo_registro) {
                throw new Exception("Error al insertar en registros.");
            }

            // Insertar en detalle_registro todas las actividades seleccionadas
            $total = 0;
            $stmtDetalle = $this->db->prepare("
            INSERT INTO detalle_registro (codigo_registro, id_actividad) 
            VALUES (?, ?)
            ");

            foreach ($actividades as $id_actividad) {
                // Obtener el valor de la actividad
                $stmtValor = $this->db->prepare("SELECT valor FROM actividades WHERE id_actividad = ?");
                $stmtValor->execute([$id_actividad]);
                $valor = $stmtValor->fetchColumn();

                // Acumular el total con el valor de la actividad
                $total += $valor;

                // Insertar en detalle_registro
                $stmtDetalle->execute([$codigo_registro, $id_actividad]);
            }

            // Actualizar el total en la tabla registros
            $stmtUpdateTotal = $this->db->prepare("
            UPDATE registros SET total = ? WHERE codigo_registro = ?
            ");
            $stmtUpdateTotal->execute([$total, $codigo_registro]);

            $this->db->commit();
            return $codigo_registro;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error en createRegistro: " . $e->getMessage());
            return false;
        }
    }

    public function updateRegistro(
        int    $codigo_registro,
        string $placa_vehiculo,
        string $cedula_responsable,
        string $fecha_retener_hasta,
        string $estado,
        ?int   $id_forma_pago,
        array  $actividades
    ): bool {
        try {
            $this->db->beginTransaction();

            // Actualizar el registro principal
            $stmt = $this->db->prepare("
            UPDATE registros 
            SET placa_vehiculo = ?, cedula_responsable = ?, fecha_retener_hasta = ?, estado = ?, id_forma_pago = ?
            WHERE codigo_registro = ?
        ");
            $stmt->execute([
                $placa_vehiculo,
                $cedula_responsable,
                $fecha_retener_hasta,
                $estado,
                $id_forma_pago ?? null, // Puede ser NULL si no se especifica forma de pago
                $codigo_registro
            ]);

            // Eliminar detalles de actividades existentes para el registro
            $stmtDelete = $this->db->prepare("DELETE FROM detalle_registro WHERE codigo_registro = ?");
            $stmtDelete->execute([$codigo_registro]);

            // Insertar los nuevos detalles de actividades
            $total = 0;
            $stmtDetalle = $this->db->prepare("
            INSERT INTO detalle_registro (codigo_registro, id_actividad) 
            VALUES (?, ?)
        ");

            foreach ($actividades as $id_actividad) {
                // Obtener el valor de la actividad
                $stmtValor = $this->db->prepare("SELECT valor FROM actividades WHERE id_actividad = ?");
                $stmtValor->execute([$id_actividad]);
                $valor = $stmtValor->fetchColumn();

                // Sumar el total
                $total += $valor;

                // Insertar en detalle_registro
                $stmtDetalle->execute([$codigo_registro, $id_actividad]);
            }

            // Actualizar el total en la tabla registros
            $stmtUpdateTotal = $this->db->prepare("
            UPDATE registros SET total = ? WHERE codigo_registro = ?
        ");
            $stmtUpdateTotal->execute([$total, $codigo_registro]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error en updateRegistro: " . $e->getMessage());
            return false;
        }
    }

    public function deleteRegistro(int $codigo_registro): bool
    {
        try {
            $this->db->beginTransaction();

            // Eliminar primero los detalles del registro
            $stmtDetalle = $this->db->prepare("DELETE FROM detalle_registro WHERE codigo_registro = ?");
            $stmtDetalle->execute([$codigo_registro]);

            // Luego eliminar el registro principal
            $stmtRegistro = $this->db->prepare("DELETE FROM registros WHERE codigo_registro = ?");
            $stmtRegistro->execute([$codigo_registro]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error en deleteRegistro: " . $e->getMessage());
            return false;
        }
    }

    public function procesarPago(int $codigoRegistro, string $placaVehiculo, int $idFormaPago): bool
    {
        try {
            $this->db->beginTransaction();

            // Actualizar el estado del registro a "pagado" y asignar la forma de pago
            $stmtRegistro = $this->db->prepare("
            UPDATE registros 
            SET estado = 'pagado', id_forma_pago = ? 
            WHERE codigo_registro = ?
            ");
            $stmtRegistro->execute([$idFormaPago, $codigoRegistro]);

            // Actualizar el estado del vehículo a "Liberado"
            $stmtVehiculo = $this->db->prepare("
            UPDATE vehiculos 
            SET estado = 'Liberado' 
            WHERE placa = ?
            ");
            $stmtVehiculo->execute([$placaVehiculo]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error en procesarPago: " . $e->getMessage());
            return false;
        }
    }
}
