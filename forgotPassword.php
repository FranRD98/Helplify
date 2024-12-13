<?php 

session_start();
$_SESSION['messageError'] = 'Esta funcionalidad no esta habilitada actualmente. Intentelo mas adelante';

header("Location: index.php"); // Redirigir de vuelta al formulario para mostrar el error
exit();
?>