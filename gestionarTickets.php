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
    <title>Helplify - Tickets</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<main>
    <?php include('views/partials/sidebar.php');?>

    <!-- Contenido del Dashboard -->
    <div class="content">
        <h1 class='tituloDashboard'>Tickets</h1>
        <p>Welcome to the Helpify Dashboard. Here you can manage tickets, categories, users, and more.</p>

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
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#1</td>
                <td>Soporte técnico para la aplicación</td>
                <td>En progreso</td>
                <td>Alta</td>
                <td>Problema técnico</td>
                <td>Juan Pérez</td>
                <td>03-12-2024</td>
            </tr>
            <tr>
                <td>#2</td>
                <td>Solicitud de cambio de contraseña</td>
                <td>Cerrado</td>
                <td>Baja</td>
                <td>Solicitud de servicio</td>
                <td>Ana Gómez</td>
                <td>02-12-2024</td>
            </tr>
            <tr>
                <td>#3</td>
                <td>Problema con el sistema de pagos</td>
                <td>Abierto</td>
                <td>Baja</td>
                <td>Error de sistema</td>
                <td>Carlos Martínez</td>
                <td>01-12-2024</td>
            </tr>
        </tbody>
    </table>

    </div>
</main>
</body>
</html>
