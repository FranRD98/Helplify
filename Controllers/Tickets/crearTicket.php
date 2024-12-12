<?php 
require_once('../../Config/db.php');

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
