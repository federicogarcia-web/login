<?php
// login.php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];

    // Verificar usuario
    $sql = "SELECT id, contraseña FROM usuarios WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hash_contraseña);
        $stmt->fetch();
        
        // Verificar la contraseña
        if (password_verify($contraseña, $hash_contraseña)) {
            echo "Inicio de sesión exitoso!";
            // Aquí puedes iniciar sesión y redirigir al usuario
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
    
    $stmt->close();
    $conn->close();
}
?>
