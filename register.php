<?php
// Configuración de la base de datos
$servername = "localhost"; // Cambia esto si es necesario
$username = "Root"; // Reemplaza con tu usuario de base de datos
$password = ""; // Reemplaza con tu contraseña de base de datos
$dbname = "mi_base_de_datos"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre-reg'];
$correo = $_POST['correo'];
$contraseña = password_hash($_POST['contraseña-reg'], PASSWORD_DEFAULT); // Encriptar la contraseña
$telefono = $_POST['telefono']; // Obtener el número de teléfono del formulario
$token = bin2hex(random_bytes(50)); // Generar un token aleatorio
$verified = 0; // Asumir que el usuario no está verificado al registrarse
$fecha_ingreso = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual

// Insertar datos en la base de datos
$sql = "INSERT INTO usuarios (nombre, correo, contraseña, telefono, token, verified, fecha_ingreso) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssis", $nombre, $correo, $contraseña, $telefono, $token, $verified, $fecha_ingreso); // Cambia el tipo a "sssssis" para incluir el teléfono

if ($stmt->execute()) {
    echo "Registro exitoso.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar conexiones
$stmt->close();
$conn->close();
?>

