<?php

require_once 'app/models/ModeloModel.php';

class ModeloController {
    private ModeloModel $model;

    public function __construct() {
        $this->model = new ModeloModel();
    }

    // Listar todos los modelos
    public function listar()
    {
        try {
            $modelos = $this->model->readModelos();
            return $modelos;
        } catch (\Exception $e) {
            error_log("Error en listar modelos: " . $e->getMessage());
            echo "Ocurrió un error al obtener los modelos.";
        }
    }

    // Agregar un nuevo modelo
    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_modelo = $_POST['codigo_modelo'] ?? null;
            $detalle = $_POST['detalle'] ?? null;

            if (!$codigo_modelo || !$detalle) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/modelosDashboard.php';
                return;
            }

            // Verificar si el modelo ya existe
            if ($this->model->readModeloPorCodigo($codigo_modelo)) {
                $mensajeError = "El modelo con código $codigo_modelo ya está registrado.";
                require_once 'app/views/admin/modelosDashboard.php';
                return;
            }

            if ($this->model->createModelo($codigo_modelo, $detalle)) {
                header('Location: admin?action=modelosDashboard&success=Modelo creado correctamente');
                exit;
            } else {
                $mensajeError = "Error al registrar el modelo.";
                require_once 'app/views/admin/modelosDashboard.php';
            }
        } else {
            require_once 'app/views/admin/modelosDashboard.php';
        }
    }

    // Editar un modelo existente
    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_modelo = $_POST['codigo_modelo'] ?? null;
            $detalle = $_POST['detalle'] ?? null;

            if (!$codigo_modelo || !$detalle) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/modelosDashboard.php';
                return;
            }

            // Verificar si el modelo existe antes de actualizar
            $modelo = $this->model->readModeloPorCodigo($codigo_modelo);
            if (!$modelo) {
                $mensajeError = "El modelo con código $codigo_modelo no existe.";
                require_once 'app/views/admin/modelosDashboard.php';
                return;
            }

            // Actualizar el modelo en la base de datos
            if ($this->model->updateModelo($codigo_modelo, $detalle)) {
                header('Location: admin?action=modelosDashboard&success=Modelo actualizado correctamente');
                exit;
            } else {
                $mensajeError = "Error al actualizar el modelo.";
                require_once 'app/views/admin/modelosDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }

    // Eliminar un modelo
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_modelo = $_POST['codigo_modelo'] ?? null;

            if (!$codigo_modelo) {
                $mensajeError = "Código de modelo no proporcionado.";
                require_once 'app/views/admin/modelosDashboard.php';
                return;
            }

            $modelo = $this->model->readModeloPorCodigo($codigo_modelo);
            if (!$modelo) {
                $mensajeError = "El modelo con código $codigo_modelo no existe.";
                require_once 'app/views/admin/modelosDashboard.php';
                return;
            }

            // Intentar eliminar el modelo
            if ($this->model->deleteModelo($codigo_modelo)) {
                header('Location: admin?action=modelosDashboard&success=Modelo eliminado correctamente');
                exit;
            } else {
                $mensajeError = "Error al eliminar el modelo.";
                require_once 'app/views/admin/modelosDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }
}
