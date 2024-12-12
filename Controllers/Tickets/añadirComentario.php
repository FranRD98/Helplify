<?php 
require_once('Config/db.php');
session_start();

// Verificar si las variables de sesión están correctamente configuradas
if (!isset($_SESSION['ticketId']) || !isset($_SESSION['usuarioId'])) {
    echo "No se ha encontrado el ticket o el usuario.";
    exit();
}

// Mostrar el formulario para agregar un comentario
?>

<form action="" method="POST">
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

<?php 
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

            // Recargar la página actual para reflejar los cambios, sin usar header()
            echo "<script>window.location.href = window.location.href;</script>";
            exit();  // Detener ejecución de código para evitar errores adicionales.
        }

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();  // Muestra el mensaje de error para depuración
        exit();  // Salir del script en caso de error
    }
}
?>
