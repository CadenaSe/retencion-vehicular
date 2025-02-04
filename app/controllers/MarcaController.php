<?php

require_once 'app/models/MarcaModel.php';

class MarcaController {

    private MarcaModel $model;

    public function __construct() {
        $this->model = new MarcaModel();
    }

    // Listar todas las marcas
    public function listar()
    {
        try {
            $marcas = $this->model->readMarcas();
            return $marcas;
        } catch (\Exception $e) {
            error_log("Error en listar marcas: " . $e->getMessage());
            echo "Ocurrió un error al obtener las marcas.";
        }
    }

    // Agregar una nueva marca
    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_marca = $_POST['codigo_marca'] ?? null;
            $detalle = $_POST['detalle'] ?? null;

            if (!$codigo_marca || !$detalle) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/marcasDashboard.php';
                return;
            }

            // Verificar si ya existe una marca con el mismo código
            if ($this->model->readMarcaPorCodigo($codigo_marca)) {
                $mensajeError = "La marca con código $codigo_marca ya está registrada.";
                require_once 'app/views/admin/marcasDashboard.php';
                return;
            }

            if ($this->model->createMarca($codigo_marca, $detalle)) {
                header('Location: admin?action=marcasDashboard&success=Marca creada correctamente');
                exit;
            } else {
                $mensajeError = "Error al registrar la marca.";
                require_once 'app/views/admin/marcasDashboard.php';
            }
        } else {
            require_once 'app/views/admin/marcasDashboard.php';
        }
    }

    // Editar una marca existente
    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_marca = $_POST['codigo_marca'] ?? null;
            $detalle = $_POST['detalle'] ?? null;

            if (!$codigo_marca || !$detalle) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/marcasDashboard.php';
                return;
            }

            // Verificar si la marca existe antes de actualizar
            $marca = $this->model->readMarcaPorCodigo($codigo_marca);
            if (!$marca) {
                $mensajeError = "La marca con código $codigo_marca no existe.";
                require_once 'app/views/admin/marcasDashboard.php';
                return;
            }

            // Actualizar la marca en la base de datos
            if ($this->model->updateMarca($codigo_marca, $detalle)) {
                header('Location: admin?action=marcasDashboard&success=Marca actualizada correctamente');
                exit;
            } else {
                $mensajeError = "Error al actualizar la marca.";
                require_once 'app/views/admin/marcasDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }

    // Eliminar una marca
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo_marca = $_POST['codigo_marca'] ?? null;

            if (!$codigo_marca) {
                $mensajeError = "Código de marca no proporcionado.";
                require_once 'app/views/admin/marcasDashboard.php';
                return;
            }

            $marca = $this->model->readMarcaPorCodigo($codigo_marca);
            if (!$marca) {
                $mensajeError = "La marca con código $codigo_marca no existe.";
                require_once 'app/views/admin/marcasDashboard.php';
                return;
            }

            // Intentar eliminar la marca
            if ($this->model->deleteMarca($codigo_marca)) {
                header('Location: admin?action=marcasDashboard&success=Marca eliminada correctamente');
                exit;
            } else {
                $mensajeError = "Error al eliminar la marca.";
                require_once 'app/views/admin/marcasDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }
}
