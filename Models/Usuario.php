<?php
require_once('../Config/db.php');
session_start();

class Usuario {
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $pdo;

    public function __construct($nombre, $apellido, $email = null, $password) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;

        global $pdo; // Usa el objeto PDO global
        $this->pdo = $pdo; // Asigna el PDO a la propiedad de la clase
    }

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
                echo "Contraseña incorrecta.<br>";
                throw new Exception("Contraseña incorrecta.");
            }
        } else {
            echo "Usuario no encontrado.<br>";
            throw new Exception("Usuario no encontrado.");
        }
    }

    public function registrarUsuario() {
        // Hash de la contraseña antes de guardarla
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        // Inserta el nuevo usuario en la base de datos
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password) VALUES (:nombre, :apellido, :email, :password)");
        $stmt->execute([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'password' => $hashedPassword // Guardamos el hash en lugar de la contraseña en texto plano
        ]);

        return true;
    }

    public function obtenerDatos() {
        // Consultar en la base de datos el nombre, apellido y rol del usuario
        $stmt = $this->pdo->prepare("SELECT nombre, apellido, rol FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $this->email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {

            // Almacenamos la información en la SESSION para utilizarla en el DASHBOARD
            $_SESSION['nombreCompleto'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
            $_SESSION['rolUsuario'] = $usuario['rol'];

        } else {
            echo "Datos no encontrados.<br>";
            throw new Exception("Datos no encontrados.");
        }
    }
}
?>
