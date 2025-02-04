<?php

require_once 'app/models/ResponsableModel.php';

class ResponsableController {
    private ResponsableModel $model;

    public function __construct() {
        $this->model = new ResponsableModel();
    }

    // Listar todos los responsables
    public function listar()
    {
        try {
            return $this->model->readResponsables();
        } catch (\Exception $e) {
            error_log("Error en listar responsables: " . $e->getMessage());
            echo "Ocurrió un error al obtener los responsables.";
        }
    }

    // Agregar un nuevo responsable
    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula_responsable'] ?? null;
            $nombres = $_POST['nombres_responsable'] ?? null;
            $apellidos = $_POST['apellidos_responsable'] ?? null;
            $email = $_POST['email_responsable'] ?? null;

            if (!$cedula || !$nombres || !$apellidos || !$email) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/responsablesDashboard.php';
                return;
            }

            // Verificar si ya existe un responsable con la misma cédula
            if ($this->model->readResponsablePorCedula($cedula)) {
                $mensajeError = "El responsable con cédula $cedula ya está registrado.";
                require_once 'app/views/admin/responsablesDashboard.php';
                return;
            }

            if ($this->model->createResponsable($cedula, $nombres, $apellidos, $email)) {
                header('Location: admin?action=responsablesDashboard&success=Responsable creado correctamente');
                exit;
            } else {
                $mensajeError = "Error al registrar responsable.";
                require_once 'app/views/admin/responsablesDashboard.php';
            }
        } else {
            require_once 'app/views/admin/responsablesDashboard.php';
        }
    }

    // Editar un responsable existente
    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula_responsable'] ?? null;
            $nombres = $_POST['nombres_responsable'] ?? null;
            $apellidos = $_POST['apellidos_responsable'] ?? null;
            $email = $_POST['email_responsable'] ?? null;

            if (!$cedula || !$nombres || !$apellidos || !$email) {
                $mensajeError = "Todos los campos son obligatorios.";
                require_once 'app/views/admin/responsablesDashboard.php';
                return;
            }

            // Verificar si el responsable existe antes de actualizar
            $responsable = $this->model->readResponsablePorCedula($cedula);
            if (!$responsable) {
                $mensajeError = "El responsable con cédula $cedula no existe.";
                require_once 'app/views/admin/responsablesDashboard.php';
                return;
            }

            // Actualizar el responsable en la base de datos
            if ($this->model->updateResponsable($cedula, $nombres, $apellidos, $email)) {
                header('Location: admin?action=responsablesDashboard&success=Responsable actualizado correctamente');
                exit;
            } else {
                $mensajeError = "Error al actualizar responsable.";
                require_once 'app/views/admin/responsablesDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }

    // Eliminar un responsable
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula_responsable'] ?? null;

            if (!$cedula) {
                $mensajeError = "Cédula de responsable no proporcionada.";
                require_once 'app/views/admin/responsablesDashboard.php';
                return;
            }

            $responsable = $this->model->readResponsablePorCedula($cedula);
            if (!$responsable) {
                $mensajeError = "El responsable con cédula $cedula no existe.";
                require_once 'app/views/admin/responsablesDashboard.php';
                return;
            }

            // Intentar eliminar el responsable
            if ($this->model->deleteResponsable($cedula)) {
                header('Location: admin?action=responsablesDashboard&success=Responsable eliminado correctamente');
                exit;
            } else {
                $mensajeError = "Error al eliminar responsable.";
                require_once 'app/views/admin/responsablesDashboard.php';
            }
        } else {
            echo "Método no permitido.";
        }
    }
}
