<?php
require_once('../Models/Usuario.php');
require_once('../Config/db.php');

session_start(); // Iniciar la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener valores del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $usuario = new Usuario("", "", $email, $password); 

        // Validar usuario
        if ($usuario->validarUsuario()) {

            $usuario->obtenerDatos();
            
            // Guardamos las variables en la session
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            // Usuario validado, redigir a 'Dashboard'
             header("Location: ../dashboard.php");
             exit();
        }
    } catch (Exception $e) {
        echo '<p>'.$e->getMessage().'</p>';

        header("Location: ../index.php"); // Redirigir de vuelta al formulario para mostrar el error
        exit();

    }
}
?>
