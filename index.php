<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helplify - Login</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body style='background-color: #313131'>
    <div class="containerForm">

        <div class='containerForm-image'> 

        </div>

        <div class='containerForm-form'> 

            <form action="Controllers/loginController.php" method="POST">
                <h1>HELPLIFY</h1>
                <h2>Bienvenido de nuevo</h2>

                <label for='email'>Login</label>
                <input type="email" name="email" id="email" placeholder="Indica tu email">

                <label for='password'>Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Ingresa tu contraseña">

                <div>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round">Remember me</span>
                    </label>

                    <a href="forgotPassword.php">¿No te acuerdas de la contraseña?</a>
                </div>

                <input type="submit" name="IniciarSesion" id="btIniciarSesion" value="Iniciar Sesión">

                <hr>

                <span class='register'>¿No tienes una cuenta?<a href="signin.php">Registrarme</a></span>
            </form>

            <div class='containerForm-footer'>
                <p>Fran Riera</p>
                <p>Helplify 2024</p>
            </div>
        </div>
    </div>

 <script src='js/functions.js'></script>

</body>
</html>