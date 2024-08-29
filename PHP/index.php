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

// Obtener los servicios desde la base de datos
$sql = "SELECT * FROM servicios";
$result = $conn->query($sql);

// Inicia una sesión si no está ya iniciada
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Clínica Veterinaria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/styles.css">
    <style>
        .section {
            padding: 20px 0;
        }
        .section h2 {
            margin-bottom: 20px;
        }
        .profile-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
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
                
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Iniciar Sesión</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="services.php">Servicios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="add_pet.php">Gestionar Mascotas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contacto</a>
            </li>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Opciones
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="products.php">Productos</a>
                    
                </div>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
        </ul>
    </div>
</nav>

    <!-- Main Content -->
    <main class="container mt-4">
        <div class="jumbotron text-center">
            <h1 class="display-4">Bienvenidos a nuestra Clínica Veterinaria</h1>
            <p id="textoNos" class="lead">Ofrecemos los mejores servicios para tus mascotas.</p>
        </div>
        
        <!-- Sección Informativa -->
        <div class="section">
            <h2>Descripción de Servicios</h2>
            <p>En nuestra clínica ofrecemos una amplia gama de servicios para el cuidado y bienestar de sus mascotas:</p>
            <ul>
                <li><strong>Consultas:</strong> Evaluaciones y diagnósticos para mantener la salud de su mascota.</li>
                <li><strong>Cirugías:</strong> Procedimientos quirúrgicos realizados por veterinarios especializados.</li>
                <li><strong>Vacunas:</strong> Inmunizaciones esenciales para prevenir enfermedades.</li>
                <li><strong>Otros Tratamientos:</strong> Tratamientos diversos adaptados a las necesidades de cada mascota.</li>
            </ul>
        </div>
        <div class="section">
            <h2>Horarios de Atención</h2>
            <p>Nuestros horarios de atención son los siguientes:</p>
            <ul>
                <li><strong>Lunes a Viernes:</strong> 9:00 AM - 6:00 PM</li>
                <li><strong>Sábados:</strong> 9:00 AM - 2:00 PM</li>
                <li><strong>Domingos:</strong> Cerrado</li>
            </ul>
        </div>
        <div class="section">
            <h2>Perfiles de Profesionales</h2>
            <div class="row">
                <!-- Perfil 1 -->
                <div class="col-md-4">
                    <div class="profile-card">
                        <h4>Dr. Juan Pérez</h4>
                        <p>Veterinario con más de 10 años de experiencia en medicina interna y cirugía. Graduado en la Universidad de Medicina Veterinaria de Barcelona.</p>
                    </div>
                </div>
                <!-- Perfil 2 -->
                <div class="col-md-4">
                    <div class="profile-card">
                        <h4>Dra. Ana Gómez</h4>
                        <p>Especialista en dermatología y enfermedades infecciosas. Graduada en la Universidad de Medicina Veterinaria de Madrid.</p>
                    </div>
                </div>
                <!-- Perfil 3 -->
                <div class="col-md-4">
                    <div class="profile-card">
                        <h4>Dr. Luis Rodríguez</h4>
                        <p>Experto en odontología veterinaria y medicina preventiva. Graduado en la Universidad de Medicina Veterinaria de Valencia.</p>
                    </div>
                </div>
            </div>
        </div>
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

<?php
$conn->close();
?>
