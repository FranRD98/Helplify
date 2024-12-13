<?php 
    require_once('../../Config/db.php'); // Conexión a la base de datos
    require_once('../enviarMail.php');

    session_start();

    // Verificar si las variables de sesión están correctamente configuradas
    if (!isset($_SESSION['ticketId']) || !isset($_SESSION['usuarioId'])) {
        echo "No se ha encontrado el ticket o el usuario.";
        exit();
    }

    // Verifica que el método de la solicitud sea POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtener los valores del formulario
        $idTicket = $_POST['idTicket'];
        $usuario = $_POST['usuarioId'];
        $mensaje = $_POST['mensaje'];

        try {
            // Verificar si el comentario ya existe para evitar duplicados
            $queryCheck = "SELECT COUNT(*) FROM respuestas WHERE idTicket = :idTicket AND usuarioId = :usuarioId AND mensaje = :mensaje";
            $stmtCheck = $pdo->prepare($queryCheck);
            $stmtCheck->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
            $stmtCheck->bindParam(':usuarioId', $usuario, PDO::PARAM_INT);
            $stmtCheck->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);
            $stmtCheck->execute();

            if ($stmtCheck->fetchColumn() > 0) {
                echo "<p>Este comentario ya ha sido agregado.</p>";
            } else {
                // Definir la consulta para insertar la respuesta
                $queryTicket = "INSERT INTO respuestas (idTicket, usuarioId, mensaje) VALUES (:idTicket, :usuarioId, :mensaje)"; 

                // Preparar la consulta
                $stmtTicket = $pdo->prepare($queryTicket);

                // Vincular los parámetros
                $stmtTicket->bindParam(':idTicket', $idTicket, PDO::PARAM_INT);
                $stmtTicket->bindParam(':usuarioId', $usuario, PDO::PARAM_INT);
                $stmtTicket->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);

                // Ejecutar la consulta
                $stmtTicket->execute();

                // Aquí después de la ejecución de la consulta
                $query = "SELECT r.created_at, r.idticket, CONCAT(u.nombre, ' ', u.apellido) as usuario, u.email, r.mensaje FROM Respuestas r LEFT JOIN Usuarios U on r.usuarioId = u.id WHERE r.idTicket = :id ORDER BY r.created_at DESC LIMIT 1;";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':id', $idTicket, PDO::PARAM_INT);
                $stmt->execute();
                $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

                // Llamamos a la función para enviar el correo de notificación
                $accion = 'nuevaRespuesta'; // Acción que ha ocurrido: 'creado', 'actualizado', etc.
                enviarCorreo($accion, $ticket);

            // Redirigir al detalle del ticket después de la actualización
            header("Location: ../../ticketDetalle.php?id=" . $idTicket);
            exit();  
            }

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();  // Muestra el mensaje de error para depuración
            exit();  // Salir del script en caso de error
        }
    }
?>
