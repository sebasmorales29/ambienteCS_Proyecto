<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Clínica Veterinaria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/styles.css">
    <style>
        .product-card {
            margin-bottom: 20px;
        }
        .product-img {
            height: 200px;
            object-fit: cover;
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
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-4">
        <h1 class="mb-4">Productos para Mascotas</h1>
        <p>Aquí encontrarás información sobre los productos que ofrecemos para el cuidado y bienestar de tus mascotas.</p>

        <!-- Descripción de Productos -->
        <section class="mb-5">
            <h2>Descripción de Productos</h2>
            <div class="row">
                <!-- Tarjeta de Producto 1 -->
                <div class="col-md-4">
                    <div class="card product-card">
                        <img src="cute-beagle-dog-lying-near-600nw-2474332895.webp" class="card-img-top product-img" alt="Alimento para perros">
                        <div class="card-body">
                            <h5 class="card-title">Alimento para Perros</h5>
                            <p class="card-text">Comida seca y húmeda para perros, con opciones para diferentes edades y necesidades dietéticas.</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta de Producto 2 -->
                <div class="col-md-4">
                    <div class="card product-card">
                        <img src="8719138813957_1.jpg" class="card-img-top product-img" alt="Juguetes para mascotas">
                        <div class="card-body">
                            <h5 class="card-title">Juguetes para Mascotas</h5>
                            <p class="card-text">Diversos juguetes para el entretenimiento y estimulación de tus mascotas.</p>
                        </div>
                    </div>
                </div>
                <!-- Tarjeta de Producto 3 -->
                <div class="col-md-4">
                    <div class="card product-card">
                        <img src="16419796728097.jpg" class="card-img-top product-img" alt="Accesorios para mascotas">
                        <div class="card-body">
                            <h5 class="card-title">Accesorios para Mascotas</h5>
                            <p class="card-text">Collares, correas, camas y otros accesorios para el confort y seguridad de tus mascotas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
