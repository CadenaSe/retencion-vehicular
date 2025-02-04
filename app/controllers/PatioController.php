<?php

require_once 'app/models/PatioModel.php';

class PatioController {
    private PatioModel $model;

    public function __construct() {
        $this->model = new PatioModel();
    }

    // Listar todos los patios
    public function listar()
    {
        try {
            $patios = $this->model->readPatios();
            return $patios;
        } catch (\Exception $e) {
            error_log("Error en listar patios: " . $e->getMessage());
            echo "Ocurrió un error al obtener los patios.";
        }
    }

    // Buscar un patio por su código
    public function buscarPorCodigo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_patio = $_POST['codigo_patio'] ?? null;

            if ($codigo_patio) {
                $patio = $this->model->readPatioPorCodigo($codigo_patio);
                if ($patio) {
                    echo json_encode(["success" => true, "patio" => $patio]);
                } else {
                    echo json_encode(["success" => false, "message" => "No se encontró un patio con este código."]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Código de patio no proporcionado."]);
            }
        }
    }

    // Crear un nuevo patio
    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_patio = $_POST['codigo_patio'] ?? null;
            $detalle = $_POST['detalle'] ?? null;
            $direccion = $_POST['direccion'] ?? null;

            if (!$codigo_patio || !$detalle || !$direccion) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/patiosDashboard.php';
                return;
            }

            // Verificar si ya existe un patio con el mismo código
            if ($this->model->readPatioPorCodigo($codigo_patio)) {
                $mensajeError = "El patio con código $codigo_patio ya está registrado.";
                require_once 'app/views/admin/patiosDashboard.php';
                return;
            }

            if ($this->model->createPatio($codigo_patio, $detalle, $direccion)) {
                header('Location: admin?action=patiosDashboard&success=Patio creado correctamente');
                exit;
            } else {
                $mensajeError = "Error al registrar el patio.";
                require_once 'app/views/admin/patiosDashboard.php';
            }
        } else {
            require_once 'app/views/admin/patiosDashboard.php';
        }
    }

    // Editar un patio existente
    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_patio = $_POST['codigo_patio'] ?? null;
            $detalle = $_POST['detalle'] ?? null;
            $direccion = $_POST['direccion'] ?? null;

            if (!$codigo_patio || !$detalle || !$direccion) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/patiosDashboard.php';
                return;
            }

            // Verificar si el patio existe antes de actualizar
            $patio = $this->model->readPatioPorCodigo($codigo_patio);
            if (!$patio) {
                $mensajeError = "El patio con código $codigo_patio no existe.";
                require_once 'app/views/admin/patiosDashboard.php';
                return;
            }

            // Actualizar el patio en la base de datos
            if ($this->model->updatePatio($codigo_patio, $detalle, $direccion)) {
                header('Location: admin?action=patiosDashboard&success=Patio actualizado correctamente');
                exit;
            } else {
                $mensajeError = "Error al actualizar el patio.";
                require_once 'app/views/admin/patiosDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }

    // Eliminar un patio
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_patio = $_POST['codigo_patio'] ?? null;

            if (!$codigo_patio) {
                $mensajeError = "Código de patio no proporcionado.";
                require_once 'app/views/admin/patiosDashboard.php';
                return;
            }

            $patio = $this->model->readPatioPorCodigo($codigo_patio);
            if (!$patio) {
                $mensajeError = "El patio con código $codigo_patio no existe.";
                require_once 'app/views/admin/patiosDashboard.php';
                return;
            }

            // Intentar eliminar el patio
            if ($this->model->deletePatio($codigo_patio)) {
                header('Location: admin?action=patiosDashboard&success=Patio eliminado correctamente');
                exit;
            } else {
                $mensajeError = "Error al eliminar el patio.";
                require_once 'app/views/admin/patiosDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }
}
