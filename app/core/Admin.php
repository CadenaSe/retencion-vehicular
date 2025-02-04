<?php

require_once 'app/controllers/PropietarioController.php';
require_once 'app/controllers/PatioController.php';
require_once 'app/controllers/InfraccionController.php';
require_once 'app/controllers/ModeloController.php';
require_once 'app/controllers/MarcaController.php';
require_once 'app/controllers/ActividadController.php';
require_once 'app/controllers/RegistroController.php';
require_once 'app/controllers/ResponsableController.php';
require_once 'app/controllers/VehiculoController.php';
require_once 'app/models/UsuarioModel.php';

class Admin
{
    private $action;
    public function __construct()
    {
        // Determinar la acción a realizar
        $this->action = $_GET['action'] ?? 'index';

        if (method_exists($this, $this->action)) {
            $this->{$this->action}();
        } else {
            http_response_code(404);
            echo "<h1>Error 404 - Acción no encontrada</h1>";
        }
    }

    public function index()
    {
        require_once 'app/views/admin/loginAdmin.php';
    }

    public function propietariosDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: admin?action=index');
            exit;
        }

        require_once 'app/views/admin/propietariosDashboard.php';
    }

    public function patiosDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: admin?action=index');
            exit;
        }

        require_once 'app/views/admin/patiosDashboard.php';
    }
    public function infraccionesDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: admin?action=index');
            exit;
        }

        require_once 'app/views/admin/infraccionesDashboard.php';
    }

    public function vehiculosDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: admin?action=index');
            exit;
        }

        require_once 'app/views/admin/vehiculosDashboard.php';
    }

    public function modelosDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: admin?action=index');
            exit;
        }

        require_once 'app/views/admin/modelosDashboard.php';
    }

    public function marcasDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: admin?action=index');
            exit;
        }

        require_once 'app/views/admin/marcasDashboard.php';
    }

    public function actividadesDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: admin?action=index');
            exit;
        }

        require_once 'app/views/admin/actividadesDashboard.php';
    }

    public function registrosDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: admin?action=index');
            exit;
        }

        require_once 'app/views/admin/registrosDashboard.php';
    }

    public function responsablesDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: admin?action=index');
            exit;
        }

        require_once 'app/views/admin/responsablesDashboard.php';
    }

    public function agregarPropietario() {
        $propietarioController = new PropietarioController();
        $propietarioController->agregar();
    }

    public function editarPropietario() {
        $propietarioController = new PropietarioController();
        $propietarioController->editar();
    }

    public function eliminarPropietario() {
        $propietarioController = new PropietarioController();
        $propietarioController->eliminar();
    }

    public function agregarPatio() {
        $patioController = new PatioController();
        $patioController->agregar();
    }
    public function editarPatio() {
        $patioController = new PatioController();
        $patioController->editar();
    }

    public function eliminarPatio() {
        $patioController = new PatioController();
        $patioController->eliminar();
    }

    public function agregarInfraccion() {
        $infraccionController = new InfraccionController();
        $infraccionController->agregar();
    }

    public function editarInfraccion() {
        $infraccionController = new InfraccionController();
        $infraccionController->editar();
    }

    public function eliminarInfraccion() {
        $infraccionController = new InfraccionController();
        $infraccionController->eliminar();
    }

    public function agregarModelo() {
        $modeloController = new ModeloController();
        $modeloController->agregar();
    }

    public function editarModelo() {
        $modeloController = new ModeloController();
        $modeloController->editar();
    }

    public function eliminarModelo() {
        $modeloController = new ModeloController();
        $modeloController->eliminar();
    }

    public function agregarMarca() {
        $marcaController = new MarcaController();
        $marcaController->agregar();
    }

    public function editarMarca() {
        $marcaController = new MarcaController();
        $marcaController->editar();
    }

    public function eliminarMarca() {
        $marcaController = new MarcaController();
        $marcaController->eliminar();
    }

    public function agregarActividad() {
        $actividadController = new ActividadController();
        $actividadController->agregar();
    }

    public function editarActividad() {
        $actividadController = new ActividadController();
        $actividadController->editar();
    }

    public function eliminarActividad() {
        $actividadController = new ActividadController();
        $actividadController->eliminar();
    }

    public function agregarResponsable() {
        $respondableController = new ResponsableController();
        $respondableController->agregar();
    }

    public function editarResponsable() {
        $respondableController = new ResponsableController();
        $respondableController->editar();
    }

    public function eliminarResponsable() {
        $respondableController = new ResponsableController();
        $respondableController->eliminar();
    }

    public function agregarVehiculo() {
        $vehiculoController = new VehiculoController();
        $vehiculoController->agregar();
    }

    public function editarVehiculo() {
        $vehiculoController = new VehiculoController();
        $vehiculoController->editar();
    }

    public function eliminarVehiculo() {
        $vehiculoController = new VehiculoController();
        $vehiculoController->eliminar();
    }

    public function agregarRegistro() {
        $registroController = new RegistroController();
        $registroController->agregar();
    }

    public function editarRegistro() {
        $registroController = new RegistroController();
        $registroController->editar();
    }

    public function eliminarRegistro() {
        $registroController = new RegistroController();
        $registroController->eliminar();
    }

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar credenciales
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            $model = new UsuarioModel();
            $usuario = $model->verificarCredenciales($username, $password);

            if ($usuario) {
                $_SESSION['usuario'] = $usuario['usuario'];
                $_SESSION['rol'] = $usuario['rol'];

                if ($usuario['rol'] === 'Administrador') {
                    header('Location: admin?action=propietariosDashboard');
                }
                exit;
            } else {
                // Credenciales incorrectas: mostrar mensaje de error
                $mensajeError = 'Usuario o contraseña incorrectos.';
                require_once 'app/views/admin/loginAdmin.php';
            }
        } else {
            require 'app/views/home.php';
        }
    }

    public function logout()
    {
        // Destruir todas las variables de sesión
        $_SESSION = [];
        session_destroy();

        header('Location: admin');
        exit;
    }
}

new Admin();
