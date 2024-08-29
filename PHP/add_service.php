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

// Insertar servicio
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        if (!empty($name) && !empty($description) && !empty($price) && is_numeric($price)) {
            $stmt = $conn->prepare("INSERT INTO servicios (name, description, price) VALUES (?, ?, ?)");
            $stmt->bind_param("ssd", $name, $description, $price);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Servicio agregado exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al agregar el servicio: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Por favor, complete todos los campos correctamente.</div>";
        }
    } elseif ($_POST['action'] == 'update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        if (!empty($id) && !empty($name) && !empty($description) && !empty($price) && is_numeric($price)) {
            $stmt = $conn->prepare("UPDATE servicios SET name = ?, description = ?, price = ? WHERE id = ?");
            $stmt->bind_param("ssdi", $name, $description, $price, $id);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Servicio actualizado exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al actualizar el servicio: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Por favor, complete todos los campos correctamente.</div>";
        }
    } elseif ($_POST['action'] == 'delete') {
        $id = $_POST['id'];

        if (!empty($id)) {
            $stmt = $conn->prepare("DELETE FROM servicios WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Servicio eliminado exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al eliminar el servicio: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>ID del servicio no válido.</div>";
        }
    }
}

// Obtener los servicios desde la base de datos
$sql = "SELECT * FROM servicios";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - Veterinaria</title>
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
            <h1 class="display-4">Administrar Servicios</h1>
            <p class="lead">Agregar, editar o eliminar servicios.</p>
        </div>

        <!-- Formulario de Agregar Servicio -->
        <h2>Agregar Nuevo Servicio</h2>
        <form method="post" action="">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Precio:</label>
                <input type="text" id="price" name="price" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Servicio</button>
        </form>

        <!-- Lista de Servicios -->
        <h2 class="mt-4">Servicios Disponibles</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td>
                                <!-- Editar Servicio -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal" data-id="<?php echo htmlspecialchars($row['id']); ?>" data-name="<?php echo htmlspecialchars($row['name']); ?>" data-description="<?php echo htmlspecialchars($row['description']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">Editar</button>
                                
                                <!-- Eliminar Servicio -->
                                <form method="post" action="" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay servicios disponibles.</p>
        <?php endif; ?>

        <!-- Modal para Editar Servicio -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Servicio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="post" action="">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" id="editId">
                            <div class="form-group">
                                <label for="editName">Nombre:</label>
                                <input type="text" id="editName" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="editDescription">Descripción:</label>
                                <textarea id="editDescription" name="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="editPrice">Precio:</label>
                                <input type="text" id="editPrice" name="price" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Servicio</button>
                        </form>
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
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var description = button.data('description');
            var price = button.data('price');
            
            var modal = $(this);
            modal.find('#editId').val(id);
            modal.find('#editName').val(name);
            modal.find('#editDescription').val(description);
            modal.find('#editPrice').val(price);
        });
    </script>
</body>
</html>
