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

// Manejo del formulario de restablecimiento de contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['telefono'])) {
        $telefono = $_POST['telefono'];

        // Verificar si el número de teléfono existe en la base de datos
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE telefono = ?");
        $stmt->bind_param("s", $telefono);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Generar un código de verificación
            $codigo_verificacion = rand(100000, 999999); // Generar un código de 6 dígitos

            // Enviar el código al teléfono (simulando aquí)
            // sendSMS($telefono, $codigo_verificacion); // Descomenta y usa esta función con Twilio o similar.

            // Aquí puedes guardar el código en la sesión o en la base de datos para su validación posterior
            session_start();
            $_SESSION['codigo_verificacion'] = $codigo_verificacion;
            $_SESSION['telefono'] = $telefono;

            echo "<p>Se ha enviado un código a tu teléfono.</p>";
            echo '<form action="verify_code.php" method="post">
                    <input type="text" name="codigo" placeholder="Ingresa el código" required>
                    <button type="submit">Verificar Código</button>
                  </form>';
        } else {
            echo "<p style='color:red;'>El número de teléfono no está registrado.</p>";
        }
    }
}

$conn->close();

// Función para enviar SMS (ejemplo usando Twilio)
function sendSMS($numero, $codigo) {
    $account_sid = 'TU_ACCOUNT_SID';
    $auth_token = 'TU_AUTH_TOKEN';
    $twilio_number = 'TU_NUMERO_TWILIO';

    $client = new Twilio\Rest\Client($account_sid, $auth_token);
    $client->messages->create(
        $numero,
        [
            'from' => $twilio_number,
            'body' => "Tu código de verificación es: $codigo"
        ]
    );
}
?>
