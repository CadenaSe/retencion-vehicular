<?php

require_once 'app/models/RegistroModel.php';

class RegistroController {
    private RegistroModel $model;

    public function __construct()
    {
        $this->model = new RegistroModel();
    }

    private function iniciarSesion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function obtenerVista()
    {
        $this->iniciarSesion();
        $rol = $_SESSION['rol'] ?? null;

        if ($rol === 'Administrador') return 'admin';
        if ($rol === 'Operador') return 'operador';
        if ($rol === 'Usuario') return 'usuario';

        die("Acceso denegado.");
    }

    private function redireccionar($mensaje, $vista)
    {
        header("Location: $vista?action=registrosDashboard&success=$mensaje");
        exit;
    }

    private function validarCamposRequeridos($campos)
    {
        foreach ($campos as $campo) {
            if (!$campo) return false;
        }
        return true;
    }

    public function listarOpcionesPagos()
    {
        try {
            return $this->model->readFormasPago();
        } catch (\Exception $e) {
            error_log("Error en listarOpcionesPagos: " . $e->getMessage());
            return [];
        }
    }

    public function listarRegistros()
    {
        try {
            return $this->model->readRegistros();
        } catch (\Exception $e) {
            error_log("Error en listarRegistros: " . $e->getMessage());
            return [];
        }
    }

    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_forma_pago = $_POST['id_forma_pago'] ?? null;
            $placa_vehiculo = $_POST['placa'] ?? null;
            $cedula_responsable = $_POST['responsable'] ?? null;
            $fecha_retener_hasta = $_POST['retener_hasta'] ?? null;
            $estado = $_POST['estado_pago'] ?? null;
            $actividades = $_POST['actividades'] ?? [];

            if (!$this->validarCamposRequeridos([$placa_vehiculo, $cedula_responsable, $fecha_retener_hasta, $estado]) || empty($actividades)) {
                $mensajeError = "Todos los campos son obligatorios excepto la forma de pago.";
                require_once $this->obtenerVista();
                return;
            }

            $codigo_registro = $this->model->createRegistro(
                $id_forma_pago ? intval($id_forma_pago) : null,
                $placa_vehiculo,
                $cedula_responsable,
                $fecha_retener_hasta,
                $estado,
                $actividades
            );

            if ($codigo_registro) {
                $this->redireccionar("Registro creado correctamente", $this->obtenerVista());
            } else {
                $mensajeError = "Error al registrar la entrada.";
                require_once $this->obtenerVista();
            }
        } else {
            require_once $this->obtenerVista();
        }
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_registro = $_POST['codigo_registro'] ?? null;
            $placa_vehiculo = $_POST['placa'] ?? null;
            $cedula_responsable = $_POST['responsable'] ?? null;
            $fecha_retener_hasta = $_POST['retener_hasta'] ?? null;
            $estado = $_POST['estado_pago'] ?? null;
            $id_forma_pago = $_POST['id_forma_pago'] ?? null;
            $actividades = $_POST['actividades'] ?? [];

            if (!$this->validarCamposRequeridos([$codigo_registro, $placa_vehiculo, $cedula_responsable, $fecha_retener_hasta, $estado])) {
                $mensajeError = "Todos los campos son obligatorios excepto la forma de pago.";
                require_once $this->obtenerVista();
                return;
            }

            $resultado = $this->model->updateRegistro(
                $codigo_registro,
                $placa_vehiculo,
                $cedula_responsable,
                $fecha_retener_hasta,
                $estado,
                $id_forma_pago ? intval($id_forma_pago) : null,
                $actividades
            );

            if ($resultado) {
                $this->redireccionar("Registro actualizado correctamente", $this->obtenerVista());
            } else {
                $mensajeError = "Error al actualizar el registro.";
                require_once $this->obtenerVista();
            }
        } else {
            echo "Método no permitido.";
        }
    }

    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_registro = $_POST['codigo_registro'] ?? null;

            if (!$codigo_registro) {
                $mensajeError = "Código de registro no proporcionado.";
                require_once $this->obtenerVista();
                return;
            }

            if ($this->model->deleteRegistro($codigo_registro)) {
                $this->redireccionar("Registro eliminado correctamente", $this->obtenerVista());
            } else {
                $mensajeError = "Error al eliminar el registro.";
                require_once $this->obtenerVista();
            }
        } else {
            echo "Método no permitido.";
        }
    }

    public function realizarPago()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigoRegistro = $_POST['codigo_registro'] ?? null;
            $placaVehiculo = $_POST['placa'] ?? null;
            $idFormaPago = $_POST['id_forma_pago'] ?? null;

            if (!$this->validarCamposRequeridos([$codigoRegistro, $placaVehiculo, $idFormaPago])) {
                $mensajeError = "Error: Todos los campos son obligatorios.";
                require_once 'app/views/usuario/usuarioDashboard.php';
                return;
            }

            if ($this->model->procesarPago($codigoRegistro, $placaVehiculo, $idFormaPago)) {
                header('Location: usuario?action=usuarioDashboard&success=El pago se realizó correctamente y el vehículo fue liberado.');
                exit;
            } else {
                $mensajeError = "Error al procesar el pago.";
                require_once 'app/views/usuario/usuarioDashboard.php';
            }
        } else {
            $_SESSION['mensaje_error'] = "Método no permitido.";
            header("Location: usuario?action=usuarioDashboard");
            exit;
        }
    }
}
