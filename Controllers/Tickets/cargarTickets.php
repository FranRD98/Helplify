<?php 
require_once('Config/db.php');

    try {
        // Definir la consulta para SELECT categorías
        $queryTickets = " SELECT
            t.id,
            t.titulo, 
            t.estado,
            c.nombre as categoria,
            CONCAT(u.nombre, ' ', u.apellido) as usuario, 
            t.prioridad, 
            DATE_FORMAT(t.created_at, '%d/%m/%Y %H:%i') as created_at
        FROM tickets t
        INNER JOIN Usuarios u 
            ON t.idUsuario = u.id
        LEFT JOIN Categorias c
            ON t.idcategoria = c.id
            order by created_at desc";

        // Preparar la consulta
        $queryTickets = $pdo->prepare($queryTickets);

        // Ejecutar la consulta
        $queryTickets->execute();

        // Iterar sobre los resultados y renderizar las filas de la tabla
        while ($row = $queryTickets->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr data-url='ticketDetalle.php?id=" . htmlspecialchars($row['id']) . "' onclick='handleRowClick(event, this)'>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
            echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
            echo "<td>" . htmlspecialchars($row['prioridad']) . "</td>";
            echo "<td>" . htmlspecialchars($row['categoria']) . "</td>";
            echo "<td>" . htmlspecialchars($row['usuario']) . "</td>";
            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            echo "</tr>";
        }

        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        }

?>