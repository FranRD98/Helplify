<?php 
require_once('Config/db.php'); // Conexión a la base de datos

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
    <title>Helplify - Categorias</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<main>
    <?php include('views/partials/sidebar.php');?>

    <!-- Contenido del Dashboard -->
    <div class="content">

        <?php include('Controllers/Tickets/abrirTicket.php');?>

        <?php include('Controllers/Tickets/cargarComentarios.php');?>

        <form action="Controllers/Tickets/añadirComentario.php" method="POST">
            <!-- Campo oculto para enviar el id del ticket -->
            <input type="hidden" name="idTicket" value="<?php echo $_SESSION['ticketId']; ?>">
            
            <!-- Campo oculto para enviar el id del usuario -->
            <input type="hidden" name="usuarioId" value="<?php echo $_SESSION['usuarioId']; ?>">
            
            <!-- Campo de texto para escribir el mensaje -->
            <label for="mensaje">Mensaje:</label>
            <textarea name="mensaje" id="mensaje" rows="4" cols="50" required></textarea>
            
            <br><br>
            
            <!-- Botón para enviar el formulario -->
            <button class='btnEnviarRespuesta' type="submit">Enviar Respuesta</button>
        </form>

    </div>
</main>

<!-- Modal de edición -->
<div id="editarTicketPopup" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="cerrarEditarTicket()">&times;</span>
        <h2>Editar Ticket</h2>
        <form id="editForm" action="Controllers/Tickets/editarTicket.php" method="POST">
            <input type="hidden" id="ticketId" name="ticketId">

            <label for="ticketNuevoNombre">Ticket:</label>
            <input type="text" id="ticketNuevoNombre" name="ticketNuevoNombre" required>
           
            <label for="ticketNuevaDescripcion">Descripción:</label>
            <textarea id="ticketNuevaDescripcion" name="ticketNuevaDescripcion" rows="4" cols="50" required></textarea>
            
            <label for="ticketNuevaPrioridad">Prioridad:</label>
            <select id="ticketNuevaPrioridad" name="ticketNuevaPrioridad" required>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
            </select>

            <label for="ticketNuevoUsuario">Asignar a:</label>
            <select id="ticketNuevoUsuario" name="ticketNuevoUsuario" required>
                <!-- Generar opciones de usuarios desde la base de datos -->
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nombre']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="ticketNuevaCategoria">Categoria:</label>
            <select id="ticketNuevaCategoria" name="ticketNuevaCategoria" required>
                <!-- Generar opciones de categorías desde la base de datos -->
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="ticketEstado">Estado:</label>
            <select id="ticketEstado" name="ticketEstado" required>
                <option value="abierto">Abierto</option>
                <option value="en_progreso">En progreso</option>
                <option value="cerrado">Cerrado</option>
            </select>

            <button type="submit">Guardar cambios</button>
        </form>
    </div>
</div>

<script src='js/functions.js'></script>
</body>
</html>
