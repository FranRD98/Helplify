<?php
    // Iniciar la sesión para acceder a las variables de sesión
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helplify - Cerrar sesión</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <div class="containerForm">

    <?php
        // Eliminar la cookie de sesión si existe
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }

    // Destruir la sesión (eliminar las variables de sesión)
    session_unset();
    session_destroy(); // Destruye la sesión

    // Redirigir a index.php
    header("Location: index.php");
    exit();
    ?>

    </div>

    
</body>
</html>