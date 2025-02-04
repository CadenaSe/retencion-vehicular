<?php

require_once 'app/models/PropietarioModel.php';

class PropietarioController {
    private $model;

    public function __construct() {
        $this->model = new PropietarioModel();
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
            require_once 'app/views/admin/propietariosDashboard.php';
        } elseif ($rolUsuario === 'Operador') {
            require_once 'app/views/operador/propietariosDashboard.php';
        } else {
            die("Acceso denegado.");
        }
    }

    private function redireccionar($mensaje)
    {
        $this->iniciarSesion();
        $rolUsuario = $_SESSION['rol'] ?? null;
        $ruta = ($rolUsuario === 'Administrador') ? 'admin' : 'operador';
        header("Location: $ruta?action=propietariosDashboard&success=$mensaje");
        exit;
    }

    public function listar()
    {
        try {
            return $this->model->readPropietarios();
        } catch (\Exception $e) {
            error_log("Error en listar propietarios: " . $e->getMessage());
            echo "Ocurrió un error al obtener los propietarios.";
        }
    }

    public function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula'] ?? null;
            $nombres = $_POST['nombres'] ?? null;
            $apellidos = $_POST['apellidos'] ?? null;
            $telefono = $_POST['telefono'] ?? null;
            $correo = $_POST['correo'] ?? null;
            $contrasenia = $_POST['password'] ?? null;

            if (!$cedula || !$nombres || !$apellidos || !$telefono || !$contrasenia || !$correo) {
                $this->cargarVista("Todos los campos son obligatorios.");
                return;
            }

            if ($this->model->readPropietarioByCedula($cedula)) {
                $this->cargarVista("El propietario con cédula $cedula ya está registrado.");
                return;
            }

            if ($this->model->createPropietario($cedula, $nombres, $apellidos, $telefono, $correo, $contrasenia)) {
                $this->redireccionar("Propietario creado correctamente");
            } else {
                $this->cargarVista("Error al registrar propietario.");
            }
        } else {
            $this->cargarVista();
        }
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula'] ?? null;
            $nombres = $_POST['nombres'] ?? null;
            $apellidos = $_POST['apellidos'] ?? null;
            $telefono = $_POST['telefono'] ?? null;
            $correo = $_POST['correo_editar'] ?? null;
            $contrasenia = $_POST['password_editar'] ?? null;

            if (!$cedula || !$nombres || !$apellidos || !$telefono || !$correo) {
                $this->cargarVista("Todos los campos son obligatorios.");
                return;
            }

            if (!$this->model->readPropietarioByCedula($cedula)) {
                $this->cargarVista("El propietario con cédula $cedula no existe.");
                return;
            }

            if ($this->model->updatePropietario($cedula, $nombres, $apellidos, $telefono, $correo, $contrasenia)) {
                $this->redireccionar("Propietario actualizado correctamente");
            } else {
                $this->cargarVista("Error al actualizar propietario.");
            }
        } else {
            echo "Método no permitido.";
        }
    }

    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula'] ?? null;

            if (!$cedula) {
                $this->cargarVista("Cédula de propietario no proporcionada.");
                return;
            }

            if (!$this->model->readPropietarioByCedula($cedula)) {
                $this->cargarVista("El propietario con cédula $cedula no existe.");
                return;
            }

            if ($this->model->deletePropietario($cedula)) {
                $this->redireccionar("Propietario eliminado correctamente");
            } else {
                $this->cargarVista("Error al eliminar propietario.");
            }
        } else {
            echo "Método no permitido.";
        }
    }
}