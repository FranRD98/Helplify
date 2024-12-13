<?php
require_once('../../Config/db.php');
require_once('../enviarMail.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibimos los datos del formulario
    $id = $_POST['ticketId'];
    $nuevoNombre = $_POST['ticketNuevoNombre'];
    $nuevaDescripcion = $_POST['ticketNuevaDescripcion'];
    $nuevaPrioridad = $_POST['ticketNuevaPrioridad'];
    $nuevoUsuario = $_POST['ticketNuevoUsuario'];
    $nuevaCategoria = $_POST['ticketNuevaCategoria'];
    $ticketEstado = $_POST['ticketEstado'];

    try {
        // Actualizar los datos del ticket en la base de datos
        $query = "UPDATE tickets 
                  SET titulo = :nuevoNombre, 
                      descripcion = :nuevaDescripcion, 
                      prioridad = :nuevaPrioridad, 
                      idUsuario = :nuevoUsuario, 
                      idCategoria = :nuevaCategoria,
                      estado = :ticketEstado
                  WHERE id = :id";

        $stmt = $pdo->prepare($query);

        // Vinculamos los parámetros con los valores recibidos
        $stmt->bindParam(':nuevoNombre', $nuevoNombre, PDO::PARAM_STR);
        $stmt->bindParam(':nuevaDescripcion', $nuevaDescripcion, PDO::PARAM_STR);
        $stmt->bindParam(':nuevaPrioridad', $nuevaPrioridad, PDO::PARAM_STR);
        $stmt->bindParam(':nuevoUsuario', $nuevoUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':nuevaCategoria', $nuevaCategoria, PDO::PARAM_INT);
        $stmt->bindParam(':ticketEstado', $ticketEstado, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Aquí después de la ejecución de la consulta
        $query = "SELECT t.id, t.titulo, t.descripcion, t.estado, t.idUsuario, t.idcategoria, c.nombre as categoria, CONCAT(u.nombre, ' ', u.apellido) as usuario, u.email, t.prioridad, DATE_FORMAT(t.created_at, '%d/%m/%Y %H:%i') as created_at FROM tickets t INNER JOIN Usuarios u ON t.idUsuario = u.id LEFT JOIN Categorias c ON t.idcategoria = c.id WHERE t.id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        // Llamamos a la función para enviar el correo de notificación
        $accion = 'modificado'; // Acción que ha ocurrido: 'creado', 'actualizado', etc.
        enviarCorreo($accion, $ticket);

        // Redirigir al detalle del ticket después de la actualización
        header("Location: ../../ticketDetalle.php?id=" . $id);
        exit();  
    } catch (Exception $e) {
        // Capturar errores y mostrarlos
        echo "Error: " . $e->getMessage();
    }
}
?>
