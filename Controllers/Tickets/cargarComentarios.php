<?php
    require_once('Config/db.php'); // Conexión a la base de datos

    try {
        // Preparar la consulta para obtener los detalles del ticket
        $query = "SELECT r.idTicket, r.usuarioId, r.mensaje, r.created_at, u.nombre, u.apellido, u.fotoPerfil, DATE_FORMAT(u.created_at, '%d/%m/%Y - %H:%i') as created_at
  FROM respuestas r 
                LEFT JOIN Usuarios u on r.usuarioId = u.id
                WHERE r.idTicket = :id
                ORDER BY r.created_at";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $ticketId, PDO::PARAM_INT);
        $stmt->execute();

        // Mostrar los detalles del ticket
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $imagenBinaria = $row['fotoPerfil'];  // El contenido binario de la imagen
            $imagenBase64 = base64_encode($imagenBinaria);

            echo "<div class='mensajeTicket'>";
                echo "<div class='fotoUsuarioTicket'>";
                    echo "<img src='data:image/jpeg;base64," . $imagenBase64 . "' alt='User Picture'>";
                echo "</div>";

                echo "<div>";
                    echo "<p class='usuarioTicket'>" . htmlspecialchars($row['nombre']) . ' ' . htmlspecialchars($row['apellido']) . "</p>";
                    echo "<p class='respuestaTicket'>" . htmlspecialchars($row['mensaje']) . "</p>";
                    echo "<p class='horaRespuestaTicket'>" . htmlspecialchars($row['created_at']) . "</p>";
                echo "</div>";
            echo "</div>";
        } 

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
?>










