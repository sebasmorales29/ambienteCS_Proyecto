<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica_veterinaria";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['reservation_id']) && isset($_SESSION['user_id'])) {
    $reservation_id = $_POST['reservation_id'];
    $stmt = $conn->prepare("DELETE FROM reservas WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $reservation_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        header("Location: my_services.php");
        exit();
    } else {
        echo "Error al eliminar la reserva.";
    }
}
?>
