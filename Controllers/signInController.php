<?php
require_once('../Models/Usuario.php');
require_once('../Config/db.php');

// Iniciar sesión (si es necesario para manejo de errores o redirección)
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenemos los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    // Verificar si las contraseñas coinciden
    if ($password !== $passwordConfirm) {
        $_SESSION['messageError'] = 'Las contraseñas no coinciden.';
        header("Location: ../signin.php");
        exit();
    }

    // Verificar si el email ya está registrado
    try {

        // Consultar si el email ya existe
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Si el email ya existe, mostrar un error
        if ($stmt->rowCount() > 0) {
            $_SESSION['messageError'] = 'Este correo electrónico ya está registrado.';
            header("Location: ../signin.php");
            exit();
        }

    } catch (Exception $e) {
        $_SESSION['messageError'] = 'Error al verificar el correo electrónico: ' . $e->getMessage();
        header("Location: ../signin.php");
        exit();
    }

    // Comprobar si se subió una imagen
    $fotoPerfil = null; // Inicializar foto como null

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        // Verificar el tipo de archivo
        $archivoTipo = $_FILES['foto_perfil']['type'];
        if (strpos($archivoTipo, 'image') === false) {
            $_SESSION['messageError'] = 'Por favor, sube una imagen válida.';
            header("Location: ../signin.php");
            exit(); // Asegurarse de detener la ejecución si hay un error
        }

        // Leer el contenido del archivo de imagen y almacenarlo como BLOB
        $fotoPerfil = file_get_contents($_FILES['foto_perfil']['tmp_name']);
    } else {
        // Si no se sube una imagen, asignar la imagen por defecto
        $fotoPerfil = file_get_contents('/images/user_default.png'); // Ruta a la imagen por defecto
    }

    try {
        // Crear una instancia de Usuario con la foto de perfil (pasar foto a la clase)
        $usuario = new Usuario($nombre, $apellido, $email, $password, $fotoPerfil);

        // Registrar el usuario
        if ($usuario->registrarUsuario()) {
            // Usuario registrado, redirigir a la página de login
            $_SESSION['success'] = 'Usuario registrado correctamente. Puedes iniciar sesión.';
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['messageError'] = 'Hubo un error al registrar el usuario.';
            header("Location: ../signin.php");
            exit();
        }
    } catch (Exception $e) {
        // Si hubo un error durante la ejecución, manejarlo
        $_SESSION['messageError'] = 'Error al registrar el usuario: ' . $e->getMessage();
        header("Location: ../signin.php");
        exit(); // Detener la ejecución en caso de error
    }
}
?>
