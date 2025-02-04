<?php

require_once 'app/models/VehiculoModel.php';

class VehiculoController {
    private VehiculoModel $model;

    public function __construct() {
        $this->model = new VehiculoModel();
    }

    private function iniciarSesion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function cargarVista($mensajeError = '')
    {
        $this->iniciarSesion();
        $rolUsuario = $_SESSION['rol'] ?? null;

        if ($rolUsuario === 'Administrador') {
            require_once 'app/views/admin/vehiculosDashboard.php';
        } elseif ($rolUsuario === 'Operador') {
            require_once 'app/views/operador/vehiculosDashboard.php';
        } else {
            die("Acceso denegado.");
        }
    }

    private function redireccionar($mensaje)
    {
        $this->iniciarSesion();
        $rolUsuario = $_SESSION['rol'] ?? null;
        $ruta = ($rolUsuario === 'Administrador') ? 'admin' : 'operador';
        header("Location: $ruta?action=vehiculosDashboard&success=$mensaje");
        exit;
    }

    public function listar()
    {
        try {
            return $this->model->readVehiculos();
        } catch (\Exception $e) {
            error_log("Error en listar vehículos: " . $e->getMessage());
            echo "Ocurrió un error al obtener los vehículos.";
        }
    }

    public function listarVehiculosRetenidos($cedula)
    {
        try {
            return $this->model->readVehiculoPorCedula($cedula);
        } catch (\Exception $e) {
            error_log("Error en listar vehículos retenidos: " . $e->getMessage());
            echo "Ocurrió un error al obtener los vehículos retenidos.";
        }
    }

    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $placa = $_POST['placa'] ?? null;
            $anio = $_POST['anio'] ?? null;
            $estado = $_POST['estado'] ?? null;
            $codigo_marca = $_POST['codigo_marca'] ?? null;
            $codigo_modelo = $_POST['codigo_modelo'] ?? null;
            $cedula_propietario = $_POST['cedula_propietario'] ?? null;
            $codigo_infraccion = $_POST['codigo_infraccion'] ?? null;
            $codigo_patio = $_POST['codigo_patio'] ?? null;

            if (!$placa || !$anio || !$estado) {
                $this->cargarVista("Los campos placa, año y estado son obligatorios.");
                return;
            }

            if ($this->model->createVehiculo($placa, $anio, $estado, $codigo_marca, $codigo_modelo, $cedula_propietario, $codigo_infraccion, $codigo_patio)) {
                $this->redireccionar("Vehículo agregado correctamente");
            } else {
                $this->cargarVista("Error al agregar el vehículo.");
            }
        } else {
            $this->cargarVista();
        }
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $placa = $_POST['placa'] ?? null;
            $anio = $_POST['anio'] ?? null;
            $estado = $_POST['estado'] ?? null;
            $codigo_marca = $_POST['codigo_marca'] ?? null;
            $codigo_modelo = $_POST['codigo_modelo'] ?? null;
            $cedula_propietario = $_POST['cedula_propietario'] ?? null;
            $codigo_infraccion = $_POST['codigo_infraccion'] ?? null;
            $codigo_patio = $_POST['codigo_patio'] ?? null;

            if (!$placa || !$anio || !$estado) {
                $this->cargarVista("Los campos placa, año y estado son obligatorios.");
                return;
            }

            if ($this->model->updateVehiculo($placa, $anio, $estado, $codigo_marca, $codigo_modelo, $cedula_propietario, $codigo_infraccion, $codigo_patio)) {
                $this->redireccionar("Vehículo actualizado correctamente");
            } else {
                $this->cargarVista("Error al actualizar el vehículo.");
            }
        } else {
            echo "Método no permitido.";
        }
    }

    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $placa = $_POST['placa'] ?? null;

            if (!$placa) {
                $this->cargarVista("Placa no proporcionada.");
                return;
            }

            if ($this->model->deleteVehiculo($placa)) {
                $this->redireccionar("Vehículo eliminado correctamente");
            } else {
                $this->cargarVista("Error al eliminar el vehículo.");
            }
        } else {
            echo "Método no permitido.";
        }
    }
}