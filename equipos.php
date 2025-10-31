<?php
/**
 * @title: Página de Equipos
 * @description: Muestra la lista de equipos y permite añadir nuevos.
 *
 * @version    1.3 - Estilos mejorados
 *
 * @author    Markel Alvarado
 */

rutasDeDirectorios();

enviarALoginSiNoHaIniciadoSesion();

$equipoDAO = new EquipoDAO();
$error = $nombre = $estadio = "";

list($nombre, $estadio, $error) = validacionDeIntroduccionDeEquipos($nombre, $estadio, $error, $equipoDAO);

$equipos = $equipoDAO->selectAll();

?>

<div class="container">
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <div class="container-fluid py-3">
            <h1 class="display-5 fw-bold">Gestión de Equipos</h1>
            <p class="col-md-8 fs-4">Añade nuevos equipos a la competición y consulta la lista de participantes.</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h2 class="h5 mb-0">Equipos de la Competición</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Nombre del Equipo</th>
                                <th>Estadio</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($equipos as $equipo): ?>
                                <tr>
                                    <td>
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
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h2 class="h5 mb-0">Añadir Nuevo Equipo</h2>
                </div>
                <div class="card-body">
                    <form role="form" method="POST" action="equipos.php">
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

                        <button type="submit" class="btn btn-success bg-dark w-100">
                            Añadir Equipo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

/**
 * @return void
 */
function rutasDeDirectorios(): void
{
    $rootDir = __DIR__;
    require_once $rootDir . '/templates/header.php';
    require_once $rootDir . '/persistence/DAO/EquipoDAO.php';
}
/**
 * @return void
 */
function enviarALoginSiNoHaIniciadoSesion(): void
{
    if (!SessionHelper::loggedIn()) {
        header('Location: ./app/login.php');
        exit();
    }
}



/**
 * @param $nombre
 * @param $estadio
 * @param string $error
 * @param EquipoDAO $equipoDAO
 * @return array|void
 */
function validacionDeIntroduccionDeEquipos($nombre, $estadio, string $error, EquipoDAO $equipoDAO)
{
    if (isset($_POST['action']) && $_POST['action'] == 'add_equipo') {
        $nombre = $_POST['nombre'];
        $estadio = $_POST['estadio'];

        if ($nombre == "" || $estadio == "") {
            $error = "Debes completar todos los campos.";
        } elseif ($equipoDAO->checkEquipoExists($nombre)) {
            $error = "Este equipo ya existe.";
        } else {
            if ($equipoDAO->insert($nombre, $estadio)) {
                header('Location: equipos.php');
                exit();
            } else {
                $error = "Error al añadir el equipo (quizás ya existe).";
            }
        }
    }
    return array($nombre, $estadio, $error);
}