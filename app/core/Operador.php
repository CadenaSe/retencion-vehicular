<?php
require_once 'app/controllers/VehiculoController.php';
require_once 'app/controllers/RegistroController.php';
require_once 'app/controllers/PropietarioController.php';
require_once 'app/models/UsuarioModel.php';

class Operador {
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
        require_once 'app/views/operador/loginOperador.php';
    }

    public function propietariosDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: operador?action=index');
            exit;
        }

        require_once 'app/views/operador/propietariosDashboard.php';
    }

    public function vehiculosDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: operador?action=index');
            exit;
        }

        require_once 'app/views/operador/vehiculosDashboard.php';
    }

    public function registrosDashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: operador?action=index');
            exit;
        }

        require_once 'app/views/operador/registrosDashboard.php';
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

                if ($usuario['rol'] === 'Operador') {
                    header('Location: operador?action=propietariosDashboard');
                }
                exit;
            } else {
                // Credenciales incorrectas: mostrar mensaje de error
                $mensajeError = 'Usuario o contraseña incorrectos.';
                require_once 'app/views/operador/loginOperador.php';
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

        header('Location: operador');
        exit;
    }
}

new Operador();