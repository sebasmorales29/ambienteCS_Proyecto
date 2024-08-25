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

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtén el ID de la reserva desde la URL
if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Recupera los detalles de la reserva
    $sql = "SELECT reservas.id AS reserva_id, servicios.nombre, servicios.descripcion, servicios.precio 
            FROM reservas 
            JOIN servicios ON reservas.service_id = servicios.id 
            WHERE reservas.id = ? AND reservas.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $reservation_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Reserva no encontrada o no autorizada.");
    }

    $reservation = $result->fetch_assoc();
} else {
    die("ID de reserva no proporcionado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva - Veterinaria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
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

    <div class="container mt-4">
        <h2>Editar Reserva</h2>
        <form method="post" action="update_reservation.php">
            <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['reserva_id']); ?>">
            <div class="form-group">
                <label for="service_name">Nombre del Servicio</label>
                <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo htmlspecialchars($reservation['nombre']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" readonly><?php echo htmlspecialchars($reservation['descripcion']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Precio</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($reservation['precio']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="new_date">Nueva Fecha</label>
                <input type="date" class="form-control" id="new_date" name="new_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Reserva</button>
        </form>
    </div>

    <!-- Aquí van los scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
