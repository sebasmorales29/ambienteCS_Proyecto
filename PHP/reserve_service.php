<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica_veterinaria";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicia una sesión si no está ya iniciada
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

// Procesar la reserva
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reserve'])) {
    $user_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];
    $reservation_date = $_POST['reservation_date'];

    if (!empty($user_id) && !empty($service_id) && !empty($reservation_date)) {
        // Inicia una transacción
        $conn->begin_transaction();
        try {
            // Insertar la reserva
            $stmt = $conn->prepare("INSERT INTO reservas (user_id, service_id, reservation_date) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user_id, $service_id, $reservation_date);
            $stmt->execute();

            // Marcar el servicio como no disponible
            $stmt = $conn->prepare("UPDATE servicios SET available = FALSE WHERE id = ?");
            $stmt->bind_param("i", $service_id);
            $stmt->execute();

            // Confirmar la transacción
            $conn->commit();
            echo "<div class='alert alert-success'>Reserva realizada exitosamente.</div>";

            $stmt->close();
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollback();
            echo "<div class='alert alert-danger'>Error al realizar la reserva: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Por favor, complete todos los campos.</div>";
    }
}

// Obtener los servicios disponibles
$sql = "SELECT * FROM servicios WHERE available = TRUE";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Servicio - Veterinaria</title>
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
                <?php if ($isLoggedIn): ?>
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
    <main class="container mt-4">
        <div class="jumbotron text-center">
            <h1 class="display-4">Reservar Servicio</h1>
            <p class="lead">Selecciona un servicio y la fecha para realizar una reserva.</p>
        </div>

        <!-- Formulario de Reserva -->
        <h2>Reservar Servicio</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="service">Servicio:</label>
                <select id="service" name="service_id" class="form-control" required>
                    <option value="">Seleccione un servicio</option>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($row['id']); ?>">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="reservation_date">Fecha de Reserva:</label>
                <input type="datetime-local" id="reservation_date" name="reservation_date" class="form-control" required>
            </div>
            <button type="submit" name="reserve" class="btn btn-primary">Reservar Servicio</button>
        </form>
    </main>

    <!-- Footer -->
    <footer class="footer bg-dark text-white text-center py-3">
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
