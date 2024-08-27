<?php
session_start();

// Conexión a la base de datos
$servername = "localhost"; // Cambia esto si es necesario
$username = "veteadmin"; // Cambia esto si es necesario
$password = "123456"; // Cambia esto si es necesario
$dbname = "clinica_veterinaria"; // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Procesar la reserva
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];

    // Insertar la reserva en la base de datos
    $sql = "INSERT INTO reservas (user_id, service_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $service_id);
    $stmt->execute();

    // Redirigir a la página de éxito o de visualización de reservas
    header('Location: my_services.php');
    exit();
}

$conn->close();
?>
