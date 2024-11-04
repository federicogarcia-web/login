<?php
require 'db.php';

if (isset($_GET['correo'])) {
    $correo = htmlspecialchars($_GET['correo']);

    // Aquí podrías implementar la lógica de actualización, como agregar un campo 'confirmado'
    // Por ejemplo, si decidiste añadir un campo `confirmado` a tu tabla:
    $sql = "UPDATE usuarios SET confirmado = 1 WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);

    if ($stmt->execute()) {
        echo "¡Gracias por confirmar tu registro!";
    } else {
        echo "Error al confirmar el registro: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
}
$conn->close();
?>
