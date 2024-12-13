<?php
require_once('../../Config/db.php');

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

        // Redirigir al detalle del ticket después de la actualización
        header("Location: ../../ticketDetalle.php?id=" . $id);
        exit();  
    } catch (Exception $e) {
        // Capturar errores y mostrarlos
        echo "Error: " . $e->getMessage();
    }
}
?>
