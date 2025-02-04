<?php

require_once __DIR__ . '/../core/Database.php';

class UsuarioModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Función para obtener todos los usuarios
    public function readUsuarios()
    {
        $stmt = $this->db->query("SELECT * FROM usuarios");
        return $stmt->fetchAll();
    }

    // Función para obtener un usuario por su ID
    public function readUsuarioPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Función para crear un nuevo usuario
    public function createUsuario($usuario, $cedula, $nombres, $apellidos, $correo, $telefono, $contraseña, $idRol)
    {
        $stmt = $this->db->prepare("
            INSERT INTO usuarios 
            (usuario, cedula, nombres, apellidos, correo, telefono, contraseña, id_rol) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$usuario, $cedula, $nombres, $apellidos, $correo, $telefono, $contraseña, $idRol]);
    }

    // Función para verificar credenciales de login
    public function verificarCredenciales($usuario, $contraseña)
    {
        $stmt = $this->db->prepare("
            SELECT u.*, r.nombre AS rol 
            FROM usuarios u 
            JOIN roles r ON u.id_rol = r.id_rol 
            WHERE u.usuario = ? AND u.contraseña = ?
        ");
        $stmt->execute([$usuario, $contraseña]);
        return $stmt->fetch();
    }
}
