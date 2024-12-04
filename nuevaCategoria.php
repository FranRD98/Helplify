<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helplify - Registrarse</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <div class="containerForm">
        
        <form action="Controllers/nuevaCategoriaController.php" method="POST">
            <h1>Nueva Categoria</h1>
            <input type="text" name="categoria" id="categoria" placeholder="Indica el nombre de la nueva categoria" required>
            <input type="submit" name="nuevaCategoria" id="btRegistrarUsuario" value="Crear categoria">
        </form>

    </div>

    
</body>
</html>