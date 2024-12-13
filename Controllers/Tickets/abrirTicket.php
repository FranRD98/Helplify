<?php
    require_once('Config/db.php'); // Conexión a la base de datos

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
            t.idUsuario,
            t.idcategoria, 
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


            echo "<div class='cabeceraTicket'>";
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

                echo "<div class='cabeceraAcciones'>";
                    // SVG de "Editar" como botón
                    echo '<a href="#" class="edit-icon" onclick="editarTicket(' . htmlspecialchars($row['id']) . ', \'' . htmlspecialchars($row['titulo']) . '\', \'' . htmlspecialchars($row['descripcion']) . '\', \'' . htmlspecialchars($row['prioridad']) . '\', \'' . htmlspecialchars($row['idUsuario']) . '\', \'' . htmlspecialchars($row['idcategoria']) . '\')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.1213 2.70705C19.9497 1.53548 18.0503 1.53547 16.8787 2.70705L15.1989 4.38685L7.29289 12.2928C7.16473 12.421 7.07382 12.5816 7.02986 12.7574L6.02986 16.7574C5.94466 17.0982 6.04451 17.4587 6.29289 17.707C6.54127 17.9554 6.90176 18.0553 7.24254 17.9701L11.2425 16.9701C11.4184 16.9261 11.5789 16.8352 11.7071 16.707L19.5556 8.85857L21.2929 7.12126C22.4645 5.94969 22.4645 4.05019 21.2929 2.87862L21.1213 2.70705ZM18.2929 4.12126C18.6834 3.73074 19.3166 3.73074 19.7071 4.12126L19.8787 4.29283C20.2692 4.68336 20.2692 5.31653 19.8787 5.70705L18.8622 6.72357L17.3068 5.10738L18.2929 4.12126ZM15.8923 6.52185L17.4477 8.13804L10.4888 15.097L8.37437 15.6256L8.90296 13.5112L15.8923 6.52185ZM4 7.99994C4 7.44766 4.44772 6.99994 5 6.99994H10C10.5523 6.99994 11 6.55223 11 5.99994C11 5.44766 10.5523 4.99994 10 4.99994H5C3.34315 4.99994 2 6.34309 2 7.99994V18.9999C2 20.6568 3.34315 21.9999 5 21.9999H16C17.6569 21.9999 19 20.6568 19 18.9999V13.9999C19 13.4477 18.5523 12.9999 18 12.9999C17.4477 12.9999 17 13.4477 17 13.9999V18.9999C17 19.5522 16.5523 19.9999 16 19.9999H5C4.44772 19.9999 4 19.5522 4 18.9999V7.99994Z" fill="#000000"/>
                            </svg>
                        </a>';

                    // SVG de "Eliminar" como botón
                    echo '<a href="Controllers/Tickets/eliminarTicket.php?id=' . htmlspecialchars($row['id']) . '" class="delete-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                        <path d="M10 12V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14 12V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    </a>';
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
