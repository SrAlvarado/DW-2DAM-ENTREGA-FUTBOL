<?php
/**
 * @title: Proyecto Futbol - Página principal (Router)
 * @description:  Redirige al usuario según su estado de sesión.
 *
 * @version    1.0
 *
 * @author     Markel Alvarado
 */

$dir = __DIR__;

require_once $dir . '/utils/SessionHelper.php';

SessionHelper::startSessionIfNotStarted();

if (!SessionHelper::loggedIn()) {
    header('Location: ./app/login.php');
    exit();
} else {
    if (isset($_SESSION['equipo_consultado'])) {
        $id_equipo = $_SESSION['equipo_consultado'];
        header('Location: partidosEquipo.php?id_equipo=' . $id_equipo);
        exit();
    } else {
        header('Location: equipos.php');
        exit();
    }
}
?>
