<?php
/**
 * @title: Página de Partidos por Equipo
 * @description: Muestra el historial de partidos de un equipo específico.
 * Guarda el equipo consultado en la sesión.
 *
 * @version    1.0
 *
 * @author    Markel Alvarado
 */

$rootDirPartidosEquipo = __DIR__;
require_once $rootDirPartidosEquipo . '/templates/header.php';
require_once $rootDirPartidosEquipo . '/persistence/DAO/EquipoDAO.php';
require_once $rootDirPartidosEquipo . '/persistence/DAO/PartidoDAO.php';

if (!SessionHelper::loggedIn()) {
    header('Location: ./app/login.php');
    exit();
}

$id_equipo = $_GET['id_equipo'] ?? null;

if ($id_equipo === null || !is_numeric($id_equipo)) {
    header('Location: equipos.php');
    exit();
}

SessionHelper::startSessionIfNotStarted();
$_SESSION['equipo_consultado'] = $id_equipo;

$equipoDAO = new EquipoDAO();
$equipo = $equipoDAO->selectById($id_equipo);

$partidoDAO = new PartidoDAO();
$partidos = $partidoDAO->selectByEquipo($id_equipo);

if ($equipo === null) {
    header('Location: equipos.php');
    exit();
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="display-5">Partidos de: <?php echo htmlspecialchars($equipo['nombre']); ?></h2>
            <h4 class="text-muted">Estadio: <?php echo htmlspecialchars($equipo['estadio']); ?></h4>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                <tr>
                    <th>Jornada</th>
                    <th>Equipo Local</th>
                    <th>Equipo Visitante</th>
                    <th>Resultado (1X2)</th>
                    <th>Estadio del Partido</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($partidos as $partido): ?>
                    <tr>
                        <td><?php echo $partido['jornada']; ?></td>

                        <!-- Resaltamos el nombre de nuestro equipo -->
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

                        <td>
                            <?php if ($partido['resultado']): ?>
                                <span class="fw-bold fs-5"><?php echo $partido['resultado']; ?></span>
                            <?php else: ?>
                                <span class="text-muted">Pendiente</span>
                            <?php endif; ?>
                        </td>
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

            <a href="equipos.php" class="btn btn-secondary mt-3">Volver a la lista de equipos</a>
        </div>
    </div>
</div>
