<?php 
require_once('../../Config/db.php');

// Verifica que el método de la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Obtener el valor de idCategoría del formulario
    $id = $_GET['id'];

    try {
        // Definir la consulta para ELIMINAR la categoría
        $queryTickets = "delete FROM tickets WHERE id = :id"; // Uso de parámetros preparados para evitar inyección SQL

        // Preparar la consulta
        $queryTickets = $pdo->prepare($queryTickets);

        // Vincular el valor de la categoría
        $queryTickets->bindParam(':id', $id, PDO::PARAM_STR);

        // Ejecutar la consulta
        $queryTickets->execute();

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
