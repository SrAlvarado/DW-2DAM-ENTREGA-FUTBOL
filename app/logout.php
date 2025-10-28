<?php
/**
 * @title: Proyecto integrador Ev01 - Salir sistema.
 * @description:  Script para salir borrando la sesión
 *
 * @version    0.3
 *
 * @author     Ander Frago & Miguel Goyena <miguel_goyena@cuatrovientos.org>
 * @Update:    Adaptado para proyecto Futbol
 */

// header.php ya inicia la sesión y carga SessionHelper
$dir = __DIR__;
require_once $dir . '/../templates/header.php';
// require_once $dir . '/../utils/SessionHelper.php'; // Ya incluido en header.php

if (SessionHelper::loggedIn()) // Mejor comprobar con la función
{
    SessionHelper::destroySession();
    // echo "<div class='main'>Has salido de tu sesión. " ; // No es necesario mostrar mensaje si redirigimos
    // redirección a la pantalla principal
    header('Location: ./../index.php');
    exit();
}
else {
    // Si no había sesión, simplemente redirigimos al inicio
    header('Location: ./../index.php');
    exit();
}
?>
<!-- El HTML restante no es necesario si siempre redirigimos -->
