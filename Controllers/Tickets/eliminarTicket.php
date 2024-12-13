<?php 
require_once('../../Config/db.php');

// Verifica que el método de la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Obtener el valor de idCategoría del formulario
    $id = $_GET['id'];

    try {
        // Definir la consulta para ELIMINAR la categoría
        $queryTicket = "delete FROM tickets WHERE id = :id"; // Uso de parámetros preparados para evitar inyección SQL
        $queryRespuestas = "delete FROM respuestas WHERE idTicket = :id"; // Elimina las respuestas del ticket

        // Preparar la consulta
        $queryTicket = $pdo->prepare($queryTicket);
        $queryRespuestas = $pdo->prepare($queryRespuestas);


        // Vincular el valor de la categoría
        $queryTicket->bindParam(':id', $id, PDO::PARAM_STR);
        $queryRespuestas->bindParam(':id', $id, PDO::PARAM_STR);

        // Ejecutar la consulta
        $queryTicket->execute();
        $queryRespuestas->execute();

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
