<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica_veterinaria";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$editing_pet = null;

// Añadir una nueva mascota
if (isset($_POST['add_pet'])) {
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $edad = $_POST['edad'];
    $peso = $_POST['peso'];
    $dueño_id = $_POST['dueño_id'];
    $historial_medico = $_POST['historial_medico'];

    $sql = "INSERT INTO mascotas (nombre, especie, raza, edad, peso, dueño_id, historial_medico) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdisi", $nombre, $especie, $raza, $edad, $peso, $dueño_id, $historial_medico);
    $stmt->execute();
}

// Actualizar una mascota existente
if (isset($_POST['update_pet'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $edad = $_POST['edad'];
    $peso = $_POST['peso'];
    $dueño_id = $_POST['dueño_id'];
    $historial_medico = $_POST['historial_medico'];

    $sql = "UPDATE mascotas SET nombre=?, especie=?, raza=?, edad=?, peso=?, dueño_id=?, historial_medico=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdisii", $nombre, $especie, $raza, $edad, $peso, $dueño_id, $historial_medico, $id);
    $stmt->execute();
}

// Eliminar una mascota
if (isset($_POST['delete_pet'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM mascotas WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Cargar la mascota para editarla
if (isset($_POST['edit_pet'])) {
    $id = $_POST['id'];

    $sql = "SELECT * FROM mascotas WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editing_pet = $result->fetch_assoc();
}

// Obtener la lista de mascotas
$sql = "SELECT * FROM mascotas";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Mascotas - Veterinaria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: var(--color-verde-claro);">
    <a class="navbar-brand" href="index.php">Veterinaria</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="add_pet.php">Gestión de Mascotas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="my_services.php">Mis Servicios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-4">
    <h2><?php echo $editing_pet ? "Editar Mascota" : "Añadir Mascota"; ?></h2>
    <form method="post" action="add_pet.php">
        <input type="hidden" name="id" value="<?php echo $editing_pet['id'] ?? ''; ?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($editing_pet['nombre'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="especie">Especie:</label>
            <input type="text" class="form-control" id="especie" name="especie" value="<?php echo htmlspecialchars($editing_pet['especie'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="raza">Raza:</label>
            <input type="text" class="form-control" id="raza" name="raza" value="<?php echo htmlspecialchars($editing_pet['raza'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="edad">Edad:</label>
            <input type="number" class="form-control" id="edad" name="edad" value="<?php echo htmlspecialchars($editing_pet['edad'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="peso">Peso (kg):</label>
            <input type="number" step="0.01" class="form-control" id="peso" name="peso" value="<?php echo htmlspecialchars($editing_pet['peso'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="dueño_id">Dueño ID:</label>
            <input type="number" class="form-control" id="dueño_id" name="dueño_id" value="<?php echo htmlspecialchars($editing_pet['dueño_id'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="historial_medico">Historial Médico:</label>
            <textarea class="form-control" id="historial_medico" name="historial_medico"><?php echo htmlspecialchars($editing_pet['historial_medico'] ?? ''); ?></textarea>
        </div>
        <button type="submit" name="<?php echo $editing_pet ? "update_pet" : "add_pet"; ?>" class="btn btn-primary">
            <?php echo $editing_pet ? "Actualizar Mascota" : "Añadir Mascota"; ?>
        </button>
    </form>

    <h2 class="mt-4">Lista de Mascotas</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Especie</th>
                <th>Raza</th>
                <th>Edad</th>
                <th>Peso</th>
                <th>Dueño ID</th>
                <th>Historial Médico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['especie']); ?></td>
                <td><?php echo htmlspecialchars($row['raza']); ?></td>
                <td><?php echo htmlspecialchars($row['edad']); ?></td>
                <td><?php echo htmlspecialchars($row['peso']); ?></td>
                <td><?php echo htmlspecialchars($row['dueño_id']); ?></td>
                <td><?php echo htmlspecialchars($row['historial_medico']); ?></td>
                <td>
                    <form method="post" action="add_pet.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="edit_pet" class="btn btn-warning btn-sm">Editar</button>
                    </form>
                    <form method="post" action="add_pet.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_pet" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
