<?php 
    include('Config/db.php'); // Conexión a la base de datos
    session_start();

    // Verificar si el usuario está logueado
    if (!isset($_SESSION['usuarioId'])) {
        echo "No estás logueado.";
        exit();
    }

    $mensaje = '';  // Variable para mostrar el mensaje

    // Subir Foto de Perfil
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fotoPerfil"])) {
        $foto = $_FILES["fotoPerfil"];
        
        // Validar el tipo de archivo (solo imágenes)
        $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
        if (in_array($foto["type"], $allowedTypes)) {
            // Convertir la imagen a binario
            $imagenBinaria = file_get_contents($foto["tmp_name"]);

            // Guardar la imagen en la base de datos
            $usuarioId = $_SESSION['usuarioId']; // ID del usuario logueado
            try {
                $query = "UPDATE Usuarios SET fotoPerfil = :fotoPerfil WHERE id = :usuarioId";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':fotoPerfil', $imagenBinaria, PDO::PARAM_LOB);
                $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
                $stmt->execute();

                // Establecer el mensaje de éxito
                $mensaje = "Foto de perfil actualizada con éxito.";
            } catch (Exception $e) {
                // Establecer el mensaje de error
                $mensaje = "Error al subir la imagen: " . $e->getMessage();
            }
        } else {
            // Si el archivo no es una imagen permitida
            $mensaje = "Solo se permiten imágenes en formato JPG, PNG o GIF.";
        }
    }

    // Obtener la foto de perfil desde la base de datos
    $fotoPerfil = null;
    try {
        $query = "SELECT fotoPerfil FROM Usuarios WHERE id = :usuarioId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':usuarioId', $_SESSION['usuarioId'], PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fotoPerfil = $row['fotoPerfil'];
            $_SESSION['fotoPerfil'] = 'data:image/jpeg;base64,' . base64_encode($fotoPerfil);
            
        }
    } catch (Exception $e) {
        echo "Error al cargar la foto de perfil: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/styles.css">
    <title>Helplify - Usuario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<main>
    <?php include('views/partials/sidebar.php');?>

    <!-- Contenido del Dashboard -->
    <div class="content">
    <span class='tituloDashboard'>
            Mi Usuario
        </span>
        <p>Aquí podrás modificar tu imagen de perfil</p>

        <!-- Formulario para subir la foto de perfil -->
        <form action="gestionarUsuario.php" method="POST" enctype="multipart/form-data">
            <label for="fotoPerfil">Selecciona una imagen para tu foto de perfil:</label>
            <input type="file" name="fotoPerfil" id="fotoPerfil" accept="image/*" required>
            <button type="submit">Subir Foto</button>
        </form>

        <hr>

        <!-- Mostrar la foto de perfil actual si existe -->
        <h2>Foto de Perfil Actual</h2>
        <?php if ($fotoPerfil): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($fotoPerfil); ?>" alt="Foto de perfil" width="150" height="150">
        <?php else: ?>
            <p>No tienes una foto de perfil establecida.</p>
        <?php endif; ?>

        <!-- Mostrar el mensaje debajo de la foto de perfil -->
        <?php if ($mensaje): ?>
            <p><?php echo $mensaje; ?></p>
        <?php endif; ?>

    </div>
</main>
<?php include('views/partials/footer.php');?>
</body>
</html>
