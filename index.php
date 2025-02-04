<?php
session_start();

// Cargar configuraciones
$configs = require_once 'app/config/configs.php';

// Establecer la zona horaria
date_default_timezone_set($configs['app']['timezone']);

// Obtener la URL base y la ruta actual
$baseUrl = $configs['app']['base_url'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remover el prefijo de la ruta base
$route = str_replace(parse_url($baseUrl, PHP_URL_PATH), '', $requestUri);
$route = trim($route, '/');

// Manejo de rutas con switch
switch ($route) {
    case 'admin':
        require_once 'app/core/Admin.php';
        break;

    case 'operador':
        require_once 'app/core/Operador.php';
        break;

    case 'usuario':
        require_once 'app/core/Usuario.php';
        break;

    case '':
        // Cargar la página por defecto (home)
        require_once 'app/views/home.php';
        break;

    default:
        // Mostrar error 404 si la ruta no coincide con ninguna
        http_response_code(404);
        echo "<h1>Error 404 - Página no encontrada</h1>";
        break;
}
