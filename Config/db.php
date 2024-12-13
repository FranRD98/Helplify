<?php

$host = "localhost";
$usuario= "root";
$contraseña = "1234";

    try {
            $pdo = new PDO("mysql:host=$host;dbname=Helplify", $usuario, $contraseña);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("set names utf8");

            return $pdo;
        }

    catch(PDOException $error){
            echo "No se pudo conectar a la BD: " . $error->getMessage();
        }

?>
