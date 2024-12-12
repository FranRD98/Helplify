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

        <?php include('Controllers/Tickets/abrirTicket.php');?>

    </div>
</main>

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
