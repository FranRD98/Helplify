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
    <title>Helplify - Simplify Support, Amplify Solutions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<main>
    <?php include('views/partials/sidebar.php');?>

    <!-- Contenido del Dashboard -->
    <div class="content">
        <h1 style="color: #505050">Dashboard</h1>
        <p>Welcome to the Helpify Dashboard. Here you can manage tickets, categories, users, and more.</p>

        <!-- Ejemplo de contenido adicional -->
        <div class='tituloPagina'>
            <h2 style="color: #505050">Last Tickets</h1>
            <ul>
                <li>Ticket #1234 - Issue with login</li>
                <li>Ticket #1235 - Feature request</li>
                <li>Ticket #1236 - Bug in report generation</li>
            </ul>
        </div>
    </div>
</main>
</body>
</html>
