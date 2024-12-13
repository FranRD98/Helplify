<?php
require_once('../Config/db.php');
session_start();

class Usuario {
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $fotoPerfil;
    private $pdo;

    // Constructor modificado para aceptar la imagen
    public function __construct($nombre, $apellido, $email = null, $password, $fotoPerfil = null) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;
        $this->fotoPerfil = $fotoPerfil;

        global $pdo; // Usa el objeto PDO global
        $this->pdo = $pdo; // Asigna el PDO a la propiedad de la clase
    }

    // Método para validar al usuario (sin cambios)
    public function validarUsuario() {
        echo "Iniciando validación de usuario...<br>";

        // Consultar en la base de datos si existe un usuario con el mismo email
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $this->email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            if (password_verify($this->password, $usuario['password'])) {
                echo "Usuario y contraseña válidos.<br>";
                return true;
            } else {
                $_SESSION['messageError'] = 'Contraseña incorrecta';
                throw new Exception("Contraseña incorrecta.");
            }
        } else {
            $_SESSION['messageError'] = 'Usuario no encontrado';
            throw new Exception("Usuario no encontrado.");
        }
    }

    // Método para registrar al usuario (modificado para manejar la imagen)
    public function registrarUsuario() {
        // Hash de la contraseña antes de guardarla
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        // Si la imagen de perfil existe, la convertimos en BLOB
        $fotoPerfil = $this->fotoPerfil ? $this->fotoPerfil : null;

        // Insertar el nuevo usuario en la base de datos
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password, fotoPerfil) VALUES (:nombre, :apellido, :email, :password, :foto_perfil)");
        $stmt->execute([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'password' => $hashedPassword, // Guardamos el hash en lugar de la contraseña en texto plano
            'foto_perfil' => $fotoPerfil  // Guardamos la imagen como BLOB (o NULL si no se proporciona)
        ]);

        return true;
    }

    // Método para obtener los datos del usuario (sin cambios)
    public function obtenerDatos() {
        // Consultar en la base de datos el nombre, apellido y rol del usuario
        $stmt = $this->pdo->prepare("SELECT id, nombre, apellido, rol, fotoPerfil FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $this->email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Almacenamos la información en la SESSION para utilizarla en el DASHBOARD
            $_SESSION['usuarioId'] = $usuario['id'];
            $_SESSION['correo'] = $this->email;
            $_SESSION['nombreCompleto'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
            $_SESSION['rolUsuario'] = $usuario['rol'];
            
            // Verificamos si 'fotoPerfil' no es nulo o vacío
            if (!empty($usuario['fotoPerfil'])) {
                $_SESSION['fotoPerfil'] = 'data:image/jpeg;base64,' . base64_encode($usuario['fotoPerfil']);
            } else {
                $_SESSION['fotoPerfil'] = null; 
            }


        } else {
            echo "Datos no encontrados.<br>";
            throw new Exception("Datos no encontrados.");
        }
    }
}
?>
