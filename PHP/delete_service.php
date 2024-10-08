<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "veteadmin";
$password = "123456";
$dbname = "clinica_veterinaria";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar el rol del usuario
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Eliminar el servicio
$id = $_GET['id'];
$sql = "DELETE FROM servicios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: services.php');
    exit();
} else {
    echo "Error al eliminar el servicio: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Servicio - Veterinaria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: var(--color-verde-claro);">
    <a class="navbar-brand" href="index.php">Veterinaria</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="my_services.php">Mis Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Iniciar Sesión</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="services.php">Servicios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contacto</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Opciones
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="option1.php">Opción 1</a>
                    <a class="dropdown-item" href="option2.php">Opción 2</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2>Eliminar Servicio</h2>
        <p>El servicio ha sido eliminado.</p>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
