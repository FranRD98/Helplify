<?php
require_once('../../Config/db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['ticketId'];
    $nuevoNombre = $_POST['ticketNuevoNombre'];

    try {
        $query = "UPDATE tickets SET titulo = :nuevoNombre WHERE id = :id";
        $stmt = $pdo->prepare($query);

        // Vincular los parámetros
        $stmt->bindParam(':nuevoNombre', $nuevoNombre, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Redirigir de nuevo a la página de gestión de categorías después de la edición
        header("Location: ../../gestionarTickets.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
