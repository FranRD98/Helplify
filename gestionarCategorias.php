<?php 
    include('Config/db.php'); // Conexión a la base de datos
    
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/styles.css">
    <title>Helplify - Categorias</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<main>
    <?php include('views/partials/sidebar.php');?>

    <!-- Contenido del Dashboard -->
    <div class="content">
        <span class='tituloDashboard'>
            Categorias
            <a href='#' onclick="crearCategoria()">
                <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22ZM12 8.25C12.4142 8.25 12.75 8.58579 12.75 9V11.25H15C15.4142 11.25 15.75 11.5858 15.75 12C15.75 12.4142 15.4142 12.75 15 12.75H12.75L12.75 15C12.75 15.4142 12.4142 15.75 12 15.75C11.5858 15.75 11.25 15.4142 11.25 15V12.75H9C8.58579 12.75 8.25 12.4142 8.25 12C8.25 11.5858 8.58579 11.25 9 11.25H11.25L11.25 9C11.25 8.58579 11.5858 8.25 12 8.25Z" fill="darkcyan"/></svg>
            </a>
        </span>

        <p>Aquí dispones de un listado de todas las categorias creadas actualmente en el sistema.</p>
        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoria</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php include('Controllers/Categorias/cargarCategorias.php');?>
        </tbody>
    </table>

    </div>
</main>

<!-- Modal de creación -->
<div id="nuevaCategoriaPopup" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="cerrarCrearCategoria()">&times;</span>
        <h2>Nueva Categoría</h2>
        <form id="createForm" action="Controllers/Categorias/crearCategoria.php" method="POST">
            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" required>
            <button type="submit">Crear categoría</button>
        </form>
    </div>
</div>

<!-- Modal de edición -->
<div id="editarCategoriaPopup" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="cerrarEditarCategoria()">&times;</span>
        <h2>Editar Categoría</h2>
        <form id="editForm" action="Controllers/Categorias/editarCategoria.php" method="POST">
            <input type="hidden" id="categoriaId" name="categoriaId">
            <label for="categoriaNuevoNombre">Nuevo nombre:</label>
            <input type="text" id="categoriaNuevoNombre" name="categoriaNuevoNombre" required>
            <button type="submit">Guardar cambios</button>
        </form>
    </div>
</div>

<script src='js/functions.js'></script>
</body>
</html>
