<?php
// db.php

$servername = "localhost";
$username = "root"; // Usuario root
$password = ""; // Contraseña de root (deja vacío si no tienes contraseña)
$dbname = "mi_base_de_datos"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
