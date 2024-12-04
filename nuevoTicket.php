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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helplify - Nuevo Ticket</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <div class="containerForm">
        
        <form action="Controllers/newTicketController.php" method="POST">
            <h1>Nuevo Ticket</h1>
            <input type="text" name="ticket" id="ticket" placeholder="Indica un título para el ticket" required>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50" placeholder="Escribe una descripción aquí..." required></textarea>
            
            <select id="prioridad" name="prioridad" required>
                <option value="bajo">Bajo</option>
                <option value="medio">Medio</option>
                <option value="alto">Alto</option>
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
</body>
</html>
