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

// Verifica si el usuario ha iniciado sesión y si es admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (!$isAdmin) {
    header("Location: services.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO servicios (name, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $description, $price);

    if ($stmt->execute()) {
        header("Location: services.php");
        exit();
    } else {
        echo "Error al agregar el servicio: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Servicio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">Veterinaria</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-4">
        <h1>Agregar Servicio</h1>
        <form action="add_service.php" method="post">
            <div class="form-group">
                <label for="name">Nombre del Servicio</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Servicio</button>
        </form>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Veterinaria. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
