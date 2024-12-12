<?php
include('Config/db.php'); // Conexión a la base de datos

// Obtener el ID del ticket desde la URL
if (isset($_GET['id'])) {
    $ticketId = $_GET['id'];

    $_SESSION['ticketId'] = $ticketId;

    try {
        // Preparar la consulta para obtener los detalles del ticket
        $query = "SELECT 
            t.id,
            t.titulo, 
            t.descripcion, 
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
        WHERE t.id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $ticketId, PDO::PARAM_INT);
        $stmt->execute();

        // Mostrar los detalles del ticket
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            echo "<div class='cabeceraDetallesTicket'>";
                    echo "<div>";
                        echo "<span>";
                            echo "<p class='numTicket'>Ticket #" . htmlspecialchars($row['id']) . "</p>";
                            echo "<p class='prioridadTicket " . htmlspecialchars($row['prioridad']) . "'>" . htmlspecialchars($row['prioridad']) . "</p>";
                        echo "</span>";
                    echo "</div>";

                    echo "<div>";
                        echo "<span>";
                            echo "<p class='ticket'>" . htmlspecialchars($row['titulo']) . "</p>";
                            echo "<p class='estadoTicket " . htmlspecialchars($row['estado']) . "'>" . htmlspecialchars($row['estado']) . "</p>";
                            echo "<p class='fechaTicket'>" . htmlspecialchars($row['created_at']) . "</p>";
                        echo "</span>";
                    echo "</div>";

                    echo "<div>";
                        echo "<span>";
                            echo "<p class='categoriaTicket'><strong>Categoría:</strong> " . htmlspecialchars($row['categoria']) . "</p>";
                            echo "<p class='asignadoTicket'><strong>Asignado a:</strong> " . htmlspecialchars($row['usuario']) . "</p>";
                        echo "</span>";
                    echo "</div>";
 
            echo "</div>";

            echo "<div class='containerDescripcion'>";
                echo "<p class='descripcionTicket'>" . htmlspecialchars($row['descripcion']) . "</p>";
            echo "</div>";

            echo "<hr>";


        } else {
            echo "<p>No se encontró el ticket con el ID proporcionado.</p>";
        }

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<p>No se ha especificado un ID de ticket.</p>";
}
?>
