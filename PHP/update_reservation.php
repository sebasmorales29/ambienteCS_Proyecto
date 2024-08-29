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

if (isset($_POST['reservation_id']) && isset($_POST['new_date']) && isset($_SESSION['user_id'])) {
    $reservation_id = $_POST['reservation_id'];
    $new_date = $_POST['new_date'];
    $user_id = $_SESSION['user_id'];

    // Validar que la nueva fecha no esté vacía
    if (!empty($new_date)) {
        // Actualiza la reserva en la base de datos
        $sql = "UPDATE reservas SET reservation_date = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $new_date, $reservation_id, $user_id);

        if ($stmt->execute()) {
            header("Location: my_services.php?success=update");
        } else {
            echo "Error al actualizar la reserva: " . $conn->error;
        }
    } else {
        echo "La fecha de la reserva no puede estar vacía.";
    }
} else {
    echo "Datos incompletos.";
}

$stmt->close();
$conn->close();
?>
