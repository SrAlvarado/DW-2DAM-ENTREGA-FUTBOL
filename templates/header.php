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

  // Obtenemos el directorio del proyecto para establecer rutas relativas.
  $dir = __DIR__;
  require_once $dir . '/../utils/SessionHelper.php';
  $loggedin = SessionHelper::loggedIn();

  /// Gestión de la sesión de usuario:
  ///

  // String para almacenar el nombre de usuario, por defecto "Invitado"
  $user = '(Invitado)';

  // TODO Almacena en la variable $loggedin el valor retornado de la función loggedin de SessionHelper
  

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

$RUTA_CARPETA_APP = "/app/"; // Es mejor usar rutas absolutas desde la raíz del sitio
$RUTA_INDEX = "/index.php"; // Ruta a la raíz

// Para que funcione, asumimos que el proyecto está en la raíz del servidor web
// Si está en una subcarpeta (ej: /DW-2DAM-ENTREGA-FUTBOL/), habría que ajustar las rutas
// Dejémoslo relativo por ahora, puede ser más simple.
$RUTA_CARPETA_APP = "./app/";
$RUTA_INDEX = "./index.php";

// Si estamos en /app/ (ej: login.php), la ruta a index es ../index.php
// Si estamos en / (ej: index.php), la ruta a app es ./app/

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


// En caso de tener una sesión registrada con antelación mostramos las opciones avanzadas de la aplicación
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
            <ul class="navbar-nav ms-auto mt-2 mt-md-0"> <!-- ms-auto para alinear a la derecha -->
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
  // En caso de ser usuario no registrado, (Invitado)
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
            <ul class="navbar-nav ms-auto mt-2 mt-md-0"> <!-- ms-auto para alinear a la derecha -->
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
<!-- Ajustamos la ruta de Bootstrap JS -->
<script type="text/javascript" src="<?php echo $RUTA_ASSETS ?>bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
