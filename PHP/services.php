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
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Obtener los servicios desde la base de datos
$sql = "SELECT * FROM servicios";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Veterinaria</title>
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
                <?php if ($isLoggedIn): ?>
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
                <li class="nav-item">
                    <a class="nav-link" href="my_services.php">Ver mis Servicios</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-4">
        <h1>Servicios</h1>
        
        <?php if ($isAdmin): ?>
            <a href="add_service.php" class="btn btn-primary mb-3">Agregar Servicio</a>
        <?php endif; ?>
        
        <!-- Mostrar servicios -->
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                <p class="card-text">Precio: $<?php echo htmlspecialchars($row['price']); ?></p>
                                <?php if ($isLoggedIn): ?>
                                    <form action="reserve_service.php" method="post">
                                        <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button type="submit" class="btn btn-primary">Reservar</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay servicios disponibles.</p>
            <?php endif; ?>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Veterinaria. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></
