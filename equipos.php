<?php
/**
 * @title: Página de Equipos
 * @description: Muestra la lista de equipos y permite añadir nuevos.
 *
 * @version    1.1
 *
 * @author     Markel Alvarado
 */


$rootDir = __DIR__;

require_once $rootDir . '/templates/header.php';

require_once $rootDir . '/persistence/DAO/EquipoDAO.php';

if (!SessionHelper::loggedIn()) {
    header('Location: ./app/login.php');
    exit();
}

$equipoDAO = new EquipoDAO();
$error = $nombre = $estadio = "";

if (isset($_POST['action']) && $_POST['action'] == 'add_equipo') {
    $nombre = $_POST['nombre'];
    $estadio = $_POST['estadio'];

    if ($nombre == "" || $estadio == "") {
        $error = "Debes completar todos los campos.";
    } else {
        if ($equipoDAO->insert($nombre, $estadio)) {
            header('Location: equipos.php');
            exit();
        } else {
            $error = "Error al añadir el equipo (quizás ya existe).";
        }
    }
}

$equipos = $equipoDAO->selectAll();

?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h2>Equipos de la Competición</h2>
            <hr>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                <tr>
                    <th>Nombre del Equipo</th>
                    <th>Estadio</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($equipos as $equipo): ?>
                    <tr>
                        <td>
                            <!-- Enlace a PartidosEquipo.php -->
                            <a href="partidosEquipo.php?id_equipo=<?php echo $equipo['id_equipo']; ?>">
                                <?php echo htmlspecialchars($equipo['nombre']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($equipo['estadio']); ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($equipos)): ?>
                    <tr>
                        <td colspan="2">No hay equipos registrados todavía.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Columna para el formulario -->
        <div class="col-md-4">
            <h2>Añadir Equipo</h2>
            <hr>
            <div class="card bg-light p-3">
                <form role="form" method="POST" action="equipos.php">
                    <!-- Campo oculto para identificar la acción -->
                    <input type="hidden" name="action" value="add_equipo">

                    <div class="form-group mb-3">
                        <label for="nombre" class="form-label">Nombre del Equipo:</label>
                        <input type="text" name="nombre" class="form-control" id="nombre"
                               placeholder="Ej: Real Madrid" required
                               value="<?php echo htmlspecialchars($nombre); ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="estadio" class="form-label">Estadio:</label>
                        <input type="text" name="estadio" class="form-control" id="estadio"
                               placeholder="Ej: Santiago Bernabéu" required
                               value="<?php echo htmlspecialchars($estadio); ?>">
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-success w-100">
                        Añadir Equipo
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

