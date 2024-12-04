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
    <h1>HAS CERRADO SESIÓN CORRECTAMENTE</h1>

    <?php 
    
        session_destroy();

        session_abort();

        header("Location: index.php"); // Redirigir de vuelta al formulario para mostrar el error
        exit();
    
    ?>

    </div>

    
</body>
</html>