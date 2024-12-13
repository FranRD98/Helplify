<?php 
require_once('../../Config/db.php');
require_once('../enviarMail.php');

// Verifica que el método de la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener el valor de la categoría del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = 'Abierto';
    $prioridad = $_POST['prioridad'];
    $usuario = $_POST['usuario'];
    $categoria = $_POST['categoria'];

    try {
        // Definir la consulta para INSERTAR la categoría
        $queryTicket = "INSERT INTO Tickets (titulo, descripcion, estado, prioridad, idusuario, idcategoria) VALUES (:titulo, :descripcion, :estado, :prioridad, :usuario, :categoria)"; // Uso de parámetros preparados para evitar inyección SQL

        // Preparar la consulta
        $queryTicket = $pdo->prepare($queryTicket);

        // Vincular el valor de la categoría
        $queryTicket->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $queryTicket->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $queryTicket->bindParam(':estado', $estado, PDO::PARAM_STR);
        $queryTicket->bindParam(':prioridad', $prioridad, PDO::PARAM_STR);
        $queryTicket->bindParam(':usuario', $usuario, PDO::PARAM_INT);
        $queryTicket->bindParam(':categoria', $categoria, PDO::PARAM_INT);

        // Ejecutar la consulta
        $queryTicket->execute();

        // Aquí después de la ejecución de la consulta
        // Obtener el último ticket insertado (usando su ID) para pasarlo a la función enviarCorreo
        $query = "SELECT t.id, t.titulo, t.descripcion, t.estado, t.idUsuario, t.idcategoria, c.nombre as categoria, CONCAT(u.nombre, ' ', u.apellido) as usuario, u.email, t.prioridad, DATE_FORMAT(t.created_at, '%d/%m/%Y %H:%i') as created_at FROM tickets t INNER JOIN Usuarios u ON t.idUsuario = u.id LEFT JOIN Categorias c ON t.idcategoria = c.id WHERE titulo = :titulo AND descripcion = :descripcion AND idusuario = :usuario ORDER BY id DESC LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
        $stmt->execute();
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        // Llamamos a la función para enviar el correo de notificación
        $accion = 'creado'; // Acción que ha ocurrido: 'creado', 'actualizado', etc.
        enviarCorreo($accion, $ticket);

        // Redirigir a la página de gestión de categorías después de la inserción
        header("Location: ../../gestionarTickets.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();  // Muestra el mensaje de error para depuración
        header("Location: ../../gestionarTickets.php");
        exit();
    }
}
?>
