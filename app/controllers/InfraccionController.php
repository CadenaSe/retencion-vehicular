<?php

require_once 'app/models/InfraccionModel.php';

class InfraccionController {
    private InfraccionModel $model;

    public function __construct() {
        $this->model = new InfraccionModel();
    }

    // Listar todas las infracciones
    public function listar()
    {
        try {
            $infracciones = $this->model->readInfracciones();
            return $infracciones;
        } catch (\Exception $e) {
            error_log("Error en listar infracciones: " . $e->getMessage());
            echo "Ocurrió un error al obtener las infracciones.";
        }
    }

    // Buscar una infracción por su código
    public function buscarPorCodigo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_infraccion = $_POST['codigo_infraccion'] ?? null;

            if ($codigo_infraccion) {
                $infraccion = $this->model->readInfraccionPorCodigo($codigo_infraccion);
                if ($infraccion) {
                    echo json_encode(["success" => true, "infraccion" => $infraccion]);
                } else {
                    echo json_encode(["success" => false, "message" => "No se encontró una infracción con este código."]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Código de infracción no proporcionado."]);
            }
        }
    }

    // Crear una nueva infracción
    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_infraccion = $_POST['codigo_infraccion'] ?? null;
            $detalle = $_POST['detalle'] ?? null;

            if (!$codigo_infraccion || !$detalle) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/infraccionesDashboard.php';
                return;
            }

            // Verificar si ya existe una infracción con el mismo código
            if ($this->model->readInfraccionPorCodigo($codigo_infraccion)) {
                $mensajeError = "La infracción con código $codigo_infraccion ya está registrada.";
                require_once 'app/views/admin/infraccionesDashboard.php';
                return;
            }

            if ($this->model->createInfraccion($codigo_infraccion, $detalle)) {
                header('Location: admin?action=infraccionesDashboard&success=Infracción creada correctamente');
                exit;
            } else {
                $mensajeError = "Error al registrar la infracción.";
                require_once 'app/views/admin/infraccionesDashboard.php';
            }
        } else {
            require_once 'app/views/admin/infraccionesDashboard.php';
        }
    }

    // Editar una infracción existente
    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_infraccion = $_POST['codigo_infraccion'] ?? null;
            $detalle = $_POST['detalle'] ?? null;

            if (!$codigo_infraccion || !$detalle) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/infraccionesDashboard.php';
                return;
            }

            // Verificar si la infracción existe antes de actualizar
            $infraccion = $this->model->readInfraccionPorCodigo($codigo_infraccion);
            if (!$infraccion) {
                $mensajeError = "La infracción con código $codigo_infraccion no existe.";
                require_once 'app/views/admin/infraccionesDashboard.php';
                return;
            }

            // Actualizar la infracción en la base de datos
            if ($this->model->updateInfraccion($codigo_infraccion, $detalle)) {
                header('Location: admin?action=infraccionesDashboard&success=Infracción actualizada correctamente');
                exit;
            } else {
                $mensajeError = "Error al actualizar la infracción.";
                require_once 'app/views/admin/infraccionesDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }

    // Eliminar una infracción
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_infraccion = $_POST['codigo_infraccion'] ?? null;

            if (!$codigo_infraccion) {
                $mensajeError = "Código de infracción no proporcionado.";
                require_once 'app/views/admin/infraccionesDashboard.php';
                return;
            }

            $infraccion = $this->model->readInfraccionPorCodigo($codigo_infraccion);
            if (!$infraccion) {
                $mensajeError = "La infracción con código $codigo_infraccion no existe.";
                require_once 'app/views/admin/infraccionesDashboard.php';
                return;
            }

            // Intentar eliminar la infracción
            if ($this->model->deleteInfraccion($codigo_infraccion)) {
                header('Location: admin?action=infraccionesDashboard&success=Infracción eliminada correctamente');
                exit;
            } else {
                $mensajeError = "Error al eliminar la infracción.";
                require_once 'app/views/admin/infraccionesDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }
}
