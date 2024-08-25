<?php
session_start();
$servername = "localhost";
$username = "veteadmin";
$password = "123456";
$dbname = "clinica_veterinaria";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['service_id']) && isset($_SESSION['user_id'])) {
    $service_id = $_POST['service_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO reservas (user_id, service_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $service_id);
    
    if ($stmt->execute()) {
        header("Location: my_services.php");
        exit();
    } else {
        echo "Error al reservar el servicio.";
    }
}
?>
