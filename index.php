<?php
/**
 * @title: Proyecto Futbol - Página principal (Router)
 * @description:  Redirige al usuario según su estado de sesión.
 *
 * @version    1.0
 *
 * @author     Tu Nombre
 */

$dir = __DIR__;
// No necesitamos el header aquí, solo el SessionHelper
require_once $dir . '/utils/SessionHelper.php';

SessionHelper::startSessionIfNotStarted(); // Aseguramos que la sesión esté iniciada

if (!SessionHelper::loggedIn()) {
    // Requisito: "Si el usuario no tiene sesión la página principal es la de equipos."
    // PERO: Si no tiene sesión, no puede ver equipos. Lo mandamos a login.
    // Interpretamos que la página de equipos es la principal *una vez logueado*.
    header('Location: ./app/login.php');
    exit();
} else {
    // Usuario SÍ está logueado

    // Requisito: "Si el usuario ha consultado los partuidos de algún equipo en concreto,
    // su pagina principal son los partidos de ese equipo."

    if (isset($_SESSION['equipo_consultado'])) {
        $id_equipo = $_SESSION['equipo_consultado'];
        // (Esta página la crearemos en el siguiente paso)
        header('Location: partidosEquipo.php?id_equipo=' . $id_equipo);
        exit();
    } else {
        // Requisito: "La página de entrada mostrará un menu con 2 opciones: Equipos y Partidos"
        // Si está logueado y no ha visto ningún equipo, va a la lista de equipos.
        header('Location: equipos.php');
        exit();
    }
}

// El HTML de bienvenida ya no es necesario, este fichero solo redirige.
?>
