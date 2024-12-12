<?php 
require_once('../../Config/db.php');

// Verifica que el método de la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener el valor de la categoría del formulario
    $categoria = $_POST['categoria'];

    try {
        // Definir la consulta para INSERTAR la categoría
        $queryCategoria = "INSERT INTO Categorias (nombre) VALUES (:categoria)"; // Uso de parámetros preparados para evitar inyección SQL

        // Preparar la consulta
        $stmtCategoria = $pdo->prepare($queryCategoria);

        // Vincular el valor de la categoría
        $stmtCategoria->bindParam(':categoria', $categoria, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmtCategoria->execute();

        // Redirigir a la página de gestión de categorías después de la inserción
        header("Location: ../../gestionarCategorias.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();  // Muestra el mensaje de error para depuración
        header("Location: ../index.php");   // Redirige a la página principal en caso de error
        exit();
    }
}
?>
