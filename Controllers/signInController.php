<?php
require_once('../Models/Usuario.php');
require_once('../Config/db.php');

// Iniciamos la sesión
//session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenemos los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];    

    try {
        $usuario = new Usuario($nombre, $apellido, $email, $password);
    
        // Registrar usuario
        if ($usuario->registrarUsuario()) {
            // Usuario registrado, redirigir a 'Login'
            header("Location: ../index.php");
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();  // Muestra el mensaje de error para depuración
        header("Location: ../index.php");   // Redirigir de vuelta al formulario para mostrar el error
        exit();
    }
    

}



?>