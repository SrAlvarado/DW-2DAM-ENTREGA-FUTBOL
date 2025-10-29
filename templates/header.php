<?php
/**
 * @title: Proyecto integrador Ev01 - Cabecera y barrra de navegación.
 * @description:  Script PHP para la gestión de la sesión de usuario.
 *                Dependiendo si el usuario esta registrado o no aparecen unas
 *   opciones en la barra de navegación.
 *
 * @version    0.2
 *
 * @author     Ander Frago & Miguel Goyena <miguel_goyena@cuatrovientos.org>
 */

  $dir = __DIR__;
  require_once $dir . '/../utils/SessionHelper.php';
  $loggedin = SessionHelper::loggedIn();

  $user = '(Invitado)';

?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo "$user" ?></title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/bootstrap-5.3.8-dist/css/bootstrap.css">
</head>
<body>
<?php

$RUTA_CARPETA_APP = "./app/";
$RUTA_INDEX = "./index.php";

// Detectamos dónde estamos para ajustar las rutas
$current_dir = basename(getcwd());
if ($current_dir == 'app') {
    $RUTA_CARPETA_APP = "./";
    $RUTA_INDEX = "../index.php";
    $RUTA_ASSETS = "../assets/";
} else {
    $RUTA_CARPETA_APP = "./app/";
    $RUTA_INDEX = "./index.php";
    $RUTA_ASSETS = "./assets/";
}

if ($loggedin)
{
?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler navbar-toggler-right" type="button"
                data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarToggler" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo $RUTA_INDEX ?>">FutbolApp</a>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Equipos</a> <!-- TODO: Enlace futuro -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Partidos</a> <!-- TODO: Enlace futuro -->
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mt-2 mt-md-0"> 
                <li class="nav-item">
                    <span class="navbar-text">
                        Hola, <?php echo $user; ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $RUTA_CARPETA_APP?>logout.php">Salir</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
}
else {
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler navbar-toggler-right" type="button"
                data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarToggler" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo $RUTA_INDEX ?>">FutbolApp</a>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto mt-2 mt-md-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $RUTA_CARPETA_APP?>signup.php">Registrarse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $RUTA_CARPETA_APP?>login.php">Entrar</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
}
?>
</body>
</html>
<script type="text/javascript" src="<?php echo $RUTA_ASSETS ?>bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
