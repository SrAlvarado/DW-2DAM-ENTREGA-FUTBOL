<?php
/**
 * @title: Página de Partidos (por Jornada)
 * @description: Muestra partidos filtrados por jornada y permite añadir nuevos.
 *
 * @version    1.2 - Estilos mejorados
 *
 * @author    Markel Alvarado
 */

$rootDir = __DIR__;
require_once $rootDir . '/templates/header.php';
require_once $rootDir . '/persistence/DAO/EquipoDAO.php';
require_once $rootDir . '/persistence/DAO/PartidoDAO.php';

if (!SessionHelper::loggedIn()) {
    header('Location: ./app/login.php');
    exit();
}

// 2. Inicializar DAOs
$partidoDAO = new PartidoDAO();
$equipoDAO = new EquipoDAO();
$error = "";

if (isset($_POST['action']) && $_POST['action'] == 'add_partido') {
    $jornada = $_POST['jornada'];
    $id_local = $_POST['id_local'];
    $id_visitante = $_POST['id_visitante'];
    $resultado = $_POST['resultado'];

    // Validaciones
    if (empty($jornada) || empty($id_local) || empty($id_visitante) || empty($resultado)) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($id_local == $id_visitante) {
        $error = "Un equipo no puede jugar contra sí mismo.";
    } elseif ($partidoDAO->checkPartidoExists($id_local, $id_visitante)) {
        $error = "Estos dos equipos ya han jugado un partido.";
    } elseif (!$partidoDAO->saberSiLaJornadaIntroducidaSigueElOrdenDeJornadas($jornada)) {
        $error = "Introduce una jornada igual o mayor a la ultima";
    } else {

        if ($partidoDAO->insert($jornada, $id_local, $id_visitante, $resultado)) {
            header('Location: partidos.php?jornada=' . $jornada);
            exit();
        } else {
            $error = "Error al guardar el partido en la BBDD.";
        }
    }
}


// 4. Lógica de MOSTRAR PARTIDOS (se ejecuta siempre)
$jornadas = $partidoDAO->getJornadas();

if (isset($_GET['jornada'])) {
    $jornada_actual = $_GET['jornada'];
} else {
    // Si no hay jornada en GET, usa la primera de la lista, o 1 por defecto
    $jornada_actual = $jornadas[0]['jornada'] ?? 1;
}

$partidos_jornada = $partidoDAO->selectByJornada($jornada_actual);
$equipos = $equipoDAO->selectAll(); // Para los dropdowns del formulario

?>

<!-- Jumbotron / Bloque de bienvenida -->
<div class="container">
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <div class="container-fluid py-3">
            <h1 class="display-5 fw-bold">Gestión de Partidos</h1>
            <p class="col-md-8 fs-4">Consulta los resultados por jornada y añade nuevos partidos al calendario.</p>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h2 class="h5 mb-0">Resultados de la Jornada <?php echo htmlspecialchars($jornada_actual); ?></h2>
                </div>
                <div class="card-body">
                    <form method="GET" action="partidos.php" class="mb-3">
                        <div class="input-group">
                            <label class="input-group-text" for="jornadaSelect">Seleccionar Jornada:</label>
                            <select class="form-select" id="jornadaSelect" name="jornada" onchange="this.form.submit()">
                                <?php foreach ($jornadas as $j): ?>
                                    <option value="<?php echo $j['jornada']; ?>"
                                        <?php echo ($j['jornada'] == $jornada_actual) ? 'selected' : ''; ?>>
                                        Jornada <?php echo $j['jornada']; ?>
                                    </option>
                                <?php endforeach; ?>
                                <?php if (empty($jornadas)): ?>
                                    <option value="1" selected>Jornada 1</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Equipo Local</th>
                                <th>Equipo Visitante</th>
                                <th>Resultado (1X2)</th>
                                <th>Estadio</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($partidos_jornada as $partido): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($partido['nombre_local']); ?></td>
                                    <td><?php echo htmlspecialchars($partido['nombre_visitante']); ?></td>
                                    <td class="fw-bold fs-5 text-center"><?php echo htmlspecialchars($partido['resultado']); ?></td>
                                    <td><?php echo htmlspecialchars($partido['estadio_partido']); ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($partidos_jornada)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay partidos registrados para esta jornada.</td>
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
                    <h2 class="h5 mb-0">Añadir Nuevo Partido</h2>
                </div>
                <div class="card-body">
                    <form role="form" method="POST" action="partidos.php">
                        <input type="hidden" name="action" value="add_partido">

                        <div class="form-group mb-3">
                            <label for="jornada" class="form-label">Jornada:</label>
                            <input type="number" name="jornada" class="form-control" id="jornada"
                                   placeholder="Ej: 3" required min="1"
                                   value="<?php echo $jornada_actual; ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_local" class="form-label">Equipo Local:</label>
                            <select class="form-select" id="id_local" name="id_local" required>
                                <option value="">Selecciona...</option>
                                <?php foreach ($equipos as $equipo): ?>
                                    <option value="<?php echo $equipo['id_equipo']; ?>">
                                        <?php echo htmlspecialchars($equipo['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_visitante" class="form-label">Equipo Visitante:</label>
                            <select class="form-select" id="id_visitante" name="id_visitante" required>
                                <option value="">Selecciona...</option>
                                <?php foreach ($equipos as $equipo): ?>
                                    <option value="<?php echo $equipo['id_equipo']; ?>">
                                        <?php echo htmlspecialchars($equipo['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="resultado" class="form-label">Resultado (1, X, 2):</label>
                            <select class="form-select" id="resultado" name="resultado" required>
                                <option value="1">1 (Gana Local)</option>
                                <option value="X">X (Empate)</option>
                                <option value="2">2 (Gana Visitante)</option>
                            </select>
                        </div>

                        <?php if ($error): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <button type="submit" class="btn bg-dark btn-success w-100">
                            Añadir Partido
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

