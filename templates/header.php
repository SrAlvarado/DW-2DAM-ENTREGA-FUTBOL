<?php
/**
 * @title: Proyecto integrador Ev01 - Cabecera y barrra de navegación.
 * @description:  Script PHP para la gestión de la sesión de usuario.
 *
 * @version    1.2 - Estilos mejorados
 *
 * @author     Ander Frago & Miguel Goyena (Modificado por Tu Nombre)
 */

rutaASessionHelper();

list($path_to_app, $path_to_assets, $path_to_root) = declaracionDeRutasUtilizadasEnElFichero();

SessionHelper::startSessionIfNotStarted();
$loggedin = SessionHelper::loggedIn();
$user = $_SESSION['user'] ?? '(Invitado)';

/**
 * @return void
 */
function rutaASessionHelper(): void
{
    $dir = __DIR__;
    require_once $dir . '/../utils/SessionHelper.php';
}


/**
 * @return string[]
 */
function declaracionDeRutasUtilizadasEnElFichero(): array
{
    $current_folder = basename(dirname($_SERVER['PHP_SELF']));
    $base_path = ($current_folder == 'app') ? '../' : './';

    $path_to_app = $base_path . 'app/';
    $path_to_assets = $base_path . 'assets/';
    $path_to_root = $base_path;
    return array($path_to_app, $path_to_assets, $path_to_root);
}

?>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Futbol - <?php echo htmlspecialchars($user); ?></title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" href="<?php echo $path_to_assets; ?>bootstrap-5.3.8-dist/css/bootstrap.css">


    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">

<?php
if ($loggedin)
{
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $path_to_root; ?>index.php">Fútbol App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $path_to_root; ?>equipos.php">Equipos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $path_to_root; ?>partidos.php">Partidos</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <span class="navbar-text me-2">
                      Hola, <?php echo htmlspecialchars($user); ?>
                    </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-warning btn-sm" href="<?php echo $path_to_app; ?>logout.php">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
}
else {
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $path_to_root; ?>index.php">Fútbol App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $path_to_app; ?>signup.php">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $path_to_app; ?>login.php">Entrar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
}
?>

<script type="text/javascript" src="<?php echo $path_to_assets; ?>bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
