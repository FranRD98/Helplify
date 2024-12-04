<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helplify - Login</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <div class="containerForm">

        <form action="Controllers/loginController.php" method="POST">
            <h1>HELPLIFY</h1>
            <input type="email" name="email" id="email" placeholder="Indica tu email">
            <input type="password" name="password" id="password" placeholder="Indica tu contraseña">
            <input type="submit" name="IniciarSesion" id="btIniciarSesion" value="Iniciar Sesión">
            <a href="signin.php">No tengo cuenta. Quiero registrarme</a>
        </form>
        
    </div>

    
</body>
</html>