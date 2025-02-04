<?php
require_once 'app/models/UsuarioModel.php';
require_once 'app/controllers/RegistroController.php';

class Usuario {
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
        require_once 'app/views/usuario/loginUsuario.php';
    }

    public function usuarioDashboard()
    {
        require_once 'app/views/usuario/usuarioDashboard.php';
    }

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar credenciales
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['cedula'] ?? null;
            $password = $_POST['password'] ?? null;

            $model = new UsuarioModel();
            $usuario = $model->verificarCredenciales($username, $password);

            if ($usuario) {
                $_SESSION['usuario'] = $usuario['usuario'];
                $_SESSION['rol'] = $usuario['rol'];

                if ($usuario['rol'] === 'Usuario') {
                    header('Location: usuario?action=usuarioDashboard');
                }
                exit;
            } else {
                // Credenciales incorrectas: mostrar mensaje de error
                $mensajeError = 'Usuario o contraseña incorrectos.';
                require_once 'app/views/usuario/loginUsuario.php';
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

        header('Location: usuario');
        exit;
    }

    public function realizarPago() {
        $registroController = new RegistroController();
        $registroController->realizarPago();
    }
}

new Usuario();