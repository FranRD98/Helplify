<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helplify - Registrarse</title>
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <div class="signInForm">
        <form action="Controllers/signInController.php" method="POST" enctype="multipart/form-data">
            <h1>HELPLIFY</h1>

                <!-- Mostrar mensaje si hay un error -->
                <?php   

                    if (isset($_SESSION['messageError'])): ?>
                    <div class="messageError">
                        <?php echo $_SESSION['messageError']; ?>
                    </div>

                    <?php unset($_SESSION['messageError']); // Eliminar el mensaje después de mostrarlo ?>
                <?php endif; ?>
                
            <input type="text" name="nombre" id="nombre" placeholder="Indica tu nombre" required>
            <input type="text" name="apellido" id="apellido" placeholder="Indica tu apellido" required>
            <input type="email" name="email" id="email" placeholder="Indica tu email" required>
            <input type="password" name="password" id="password" placeholder="Indica tu contraseña" required>
            <input type="password" name="passwordConfirm" id="passwordConfirm" placeholder="Repite tu contraseña" required>
            <input type="file" name="foto_perfil" id="foto_perfil">
            <input type="submit" name="RegistrarUsuario" id="btRegistrarUsuario" value="Registrarse">
            
            <p>Sí que tengo cuenta. <a href="index.php">Quiero iniciar sesión</a></p>
        </form>
    </div>
</body>
</html>
