<?php
/**
 * @title: Proyecto integrador Ev01 - Página principal
 * @description:  Bienvenida a la aplicación
 *
 * @version    0.1
 *
 * @author ander_frago@cuatrovientos.org
 */


$dir = __DIR__;
require_once $dir . '/templates/header.php';
//require_once $dir . '/utils/SessionHelper.php';

$loggedIn = SessionHelper::loggedIn();
$user = $_SESSION['user'];
?>
<html lang="es">
<body>

<link rel="stylesheet" href="./assets/bootstrap-5.3.8-dist/css/bootstrap.css">
<script src="assets/bootstrap-5.3.8-dist/js/bootstrap.js"></script>


<div class="container-fluid py-5 my-5 bg-light">
    <div id="bienvenida" class="container">
        <h1 class='display-3'>Bienvenid@ a Artean</h1>
        <?php
        if ($loggedIn) {
            echo "<p class='display-6'> Has iniciado sesión: " . $user . "</p>";
        }
        else
            echo "<p class='display-6'> por favor, regístrate o inicia sesión.</p>";
        ?>
    </div>
</div>
<script src="assets/bootstrap-5.3.8-dist/css/bootstrap.css"></script>

</body>

</html>