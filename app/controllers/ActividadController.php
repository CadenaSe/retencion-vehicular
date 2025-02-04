<?php
require_once 'app/models/ActividadModel.php';

class ActividadController {
    private ActividadModel $model;

    public function __construct() {
        $this->model = new ActividadModel();
    }

    // Listar todas las actividades
    public function listar()
    {
        try {
            return $this->model->readActividades();
        } catch (\Exception $e) {
            error_log("Error en listar actividades: " . $e->getMessage());
            return [];
        }
    }

    // Agregar una nueva actividad con valor
    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $detalle = $_POST['detalle'] ?? null;
            $valor = isset($_POST['valor']) ? floatval($_POST['valor']) : null;

            if (!$detalle || $valor === null) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/actividadesDashboard.php';
                return;
            }

            if ($this->model->createActividad($detalle, $valor)) {
                header('Location: admin?action=actividadesDashboard&success=Actividad creada correctamente');
                exit;
            } else {
                $mensajeError = "Error al registrar la actividad.";
                require_once 'app/views/admin/actividadesDashboard.php';
            }
        } else {
            require_once 'app/views/admin/actividadesDashboard.php';
        }
    }

    // Editar una actividad existente con valor
    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_actividad = $_POST['id_actividad'] ?? null;
            $detalle = $_POST['detalle'] ?? null;
            $valor = isset($_POST['valor']) ? floatval($_POST['valor']) : null;

            if (!$id_actividad || !$detalle || $valor === null) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/actividadesDashboard.php';
                return;
            }

            $actividad = $this->model->readActividadPorId($id_actividad);
            if (!$actividad) {
                $mensajeError = "La actividad con ID $id_actividad no existe.";
                require_once 'app/views/admin/actividadesDashboard.php';
                return;
            }

            if ($this->model->updateActividad($id_actividad, $detalle, $valor)) {
                header('Location: admin?action=actividadesDashboard&success=Actividad actualizada correctamente');
                exit;
            } else {
                $mensajeError = "Error al actualizar la actividad.";
                require_once 'app/views/admin/actividadesDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }

    // Eliminar una actividad
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_actividad = $_POST['id_actividad'] ?? null;

            if (!$id_actividad) {
                $mensajeError = "ID de actividad no proporcionado.";
                require_once 'app/views/admin/actividadesDashboard.php';
                return;
            }

            $actividad = $this->model->readActividadPorId($id_actividad);
            if (!$actividad) {
                $mensajeError = "La actividad con ID $id_actividad no existe.";
                require_once 'app/views/admin/actividadesDashboard.php';
                return;
            }

            if ($this->model->deleteActividad($id_actividad)) {
                header('Location: admin?action=actividadesDashboard&success=Actividad eliminada correctamente');
                exit;
            } else {
                $mensajeError = "Error al eliminar la actividad.";
                require_once 'app/views/admin/actividadesDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }
}