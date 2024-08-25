<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "veteadmin";
$password = "123456";
$dbname = "clinica_veterinaria";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $hashed_password, $role);

if ($stmt->execute()) {
    header('Location: create_user.php?success=1');
} else {
    header('Location: create_user.php?error=1');
}

$stmt->close();
$conn->close();
?>
