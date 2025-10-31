<?php
/**
 * @title: Página de Partidos por Equipo
 * @description: Muestra los partidos de un equipo específico.
 *
 * @version    1.2 - Estilos mejorados
 *
 * @author    Markel Alvarado
 */

rutasFicheros();

redirigirALoginSiNoIniciadoSesion();


if (!isset($_GET['id_equipo']) || !is_numeric($_GET['id_equipo'])) {
    header('Location: equipos.php');
    exit();
}

$id_equipo = $_GET['id_equipo'];

$_SESSION['last_team_visited'] = $id_equipo;

$equipoDAO = new EquipoDAO();
$partidoDAO = new PartidoDAO();

$equipo = $equipoDAO->selectById($id_equipo);
$partidos = $partidoDAO->selectByEquipo($id_equipo);

if (!$equipo) {
    header('Location: equipos.php');
    exit();
}

?>

<div class="container">
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <div class="container-fluid py-3">
            <h1 class="display-5 fw-bold"><?php echo htmlspecialchars($equipo['nombre']); ?></h1>
            <p class="col-md-8 fs-4">
                Estadio: <?php echo htmlspecialchars($equipo['estadio']); ?>
            </p>
            <a href="equipos.php" class="btn btn-primary btn-lg">&larr; Volver a Equipos</a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h2 class="h5 mb-0">Partidos del <?php echo htmlspecialchars($equipo['nombre']); ?></h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Jornada</th>
                                <th>Equipo Local</th>
                                <th>Equipo Visitante</th>
                                <th>Resultado (1X2)</th>
                                <th>Estadio</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($partidos as $partido): ?>
                                <tr>
                                    <td>Jornada <?php echo htmlspecialchars($partido['jornada']); ?></td>

                                    <td>
                                        <?php if ($partido['nombre_local'] == $equipo['nombre']): ?>
                                            <strong><?php echo htmlspecialchars($partido['nombre_local']); ?></strong>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($partido['nombre_local']); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($partido['nombre_visitante'] == $equipo['nombre']): ?>
                                            <strong><?php echo htmlspecialchars($partido['nombre_visitante']); ?></strong>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($partido['nombre_visitante']); ?>
                                        <?php endif; ?>
                                    </td>

                                    <td classD="fw-bold fs-5 text-center"><?php echo htmlspecialchars($partido['resultado']); ?></td>
                                    <td><?php echo htmlspecialchars($partido['estadio_partido']); ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($partidos)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Este equipo no ha jugado ningún partido todavía.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * @return void
 */
function rutasFicheros(): void
{
    $rootDir = __DIR__;
    require_once $rootDir . '/templates/header.php';
    require_once $rootDir . '/persistence/DAO/EquipoDAO.php';
    require_once $rootDir . '/persistence/DAO/PartidoDAO.php';
}

/**
 * @return void
 */
function redirigirALoginSiNoIniciadoSesion(): void
{
    if (!SessionHelper::loggedIn()) {
        header('Location: ./app/login.php');
        exit();
    }
}