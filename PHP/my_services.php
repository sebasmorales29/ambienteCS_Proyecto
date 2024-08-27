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

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT reservas.id AS reserva_id, servicios.nombre, servicios.descripcion, servicios.precio 
        FROM reservas 
        JOIN servicios ON reservas.service_id = servicios.id 
        WHERE reservas.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Servicios - Veterinaria</title>
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
        <h2>Mis Servicios Reservados</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td>$<?php echo $row['precio']; ?></td>
                        <td>
                            <form method="post" action="update_reservation.php" style="display:inline;">
                                <input type="hidden" name="reservation_id" value="<?php echo $row['reserva_id']; ?>">
                                <button type="submit" class="btn btn-warning btn-sm">Actualizar</button>
                            </form>
                            <form method="post" action="delete_reservation.php" style="display:inline;">
                                <input type="hidden" name="reservation_id" value="<?php echo $row['reserva_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Aquí van los scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
