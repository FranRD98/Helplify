<?php 
// Incluir el archivo de configuración de la base de datos
require_once('Config/db.php');

// Obtener usuarios desde la base de datos
$queryUsuarios = "SELECT id, nombre FROM usuarios"; // Cambia según tu estructura de base de datos
$stmtUsuarios = $pdo->prepare($queryUsuarios);
$stmtUsuarios->execute();
$usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

// Obtener categorías desde la base de datos
$queryCategorias = "SELECT id, nombre FROM categorias"; // Cambia según tu estructura de base de datos
$stmtCategorias = $pdo->prepare($queryCategorias);
$stmtCategorias->execute();
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/styles.css">
    <title>Helplify - Tickets</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<main>
    <?php include('views/partials/sidebar.php');?>

    <!-- Contenido del Dashboard -->
    <div class="content">
        <span class='tituloDashboard'>
            Tickets
            <a href='#' onclick="crearTicket()">
                <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22ZM12 8.25C12.4142 8.25 12.75 8.58579 12.75 9V11.25H15C15.4142 11.25 15.75 11.5858 15.75 12C15.75 12.4142 15.4142 12.75 15 12.75H12.75L12.75 15C12.75 15.4142 12.4142 15.75 12 15.75C11.5858 15.75 11.25 15.4142 11.25 15V12.75H9C8.58579 12.75 8.25 12.4142 8.25 12C8.25 11.5858 8.58579 11.25 9 11.25H11.25L11.25 9C11.25 8.58579 11.5858 8.25 12 8.25Z" fill="darkcyan"/></svg>
            </a>
        </span>
        <p>Aquí dispones de un listado de todos los tickets creados en el sistema.</p>

        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Ticket</th>
                <th>Estado</th>
                <th>Prioridad</th>
                <th>Categoria</th>
                <th>Asignado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php include('Controllers/Tickets/cargarTickets.php');?>
        </tbody>
    </table>

    </div>
</main>

<!-- Modal de creación -->
<div id="nuevoTicketPopup" class="modal" style="display: none;">
    <div class="modal-content modal-crear-ticket">
        <span class="close" onclick="cerrarCrearTicket()">&times;</span>
        <h2>Nuevo Ticket</h2>
        <form action="Controllers/Tickets/crearTicket.php" method="POST">
            <input type="text" name="titulo" id="titulo" placeholder="Indica un título para el ticket" required>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50" placeholder="Escribe una descripción aquí..." required></textarea>
            
            <select id="prioridad" name="prioridad" required>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
            </select>

            <select id="usuario" name="usuario" required>
                <!-- Generar opciones de usuarios desde la base de datos -->
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nombre']; ?></option>
                <?php endforeach; ?>
            </select>

            <select id="categoria" name="categoria" required>
                <!-- Generar opciones de categorías desde la base de datos -->
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" name="CrearTicket" id="btRegistrarUsuario" value="Crear Ticket">
        </form>
    </div>
</div>

<!-- Modal de edición -->
<div id="editarTicketPopup" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="cerrarEditarTicket()">&times;</span>
        <h2>Editar Ticket</h2>
        <form id="editForm" action="Controllers/Tickets/editarTicket.php" method="POST">
            <input type="hidden" id="ticketId" name="ticketId">
            <label for="ticketNuevoNombre">Nuevo nombre:</label>
            <input type="text" id="ticketNuevoNombre" name="ticketNuevoNombre" required>
            <button type="submit">Guardar cambios</button>
        </form>
    </div>
</div>


<script src='js/functions.js'></script>
</body>
</html>
