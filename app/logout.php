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

$dir = __DIR__;
require_once $dir . '/../templates/header.php';

if (SessionHelper::loggedIn())
{
    SessionHelper::destroySession();

    header('Location: ./../index.php');
    exit();
}
else {
    header('Location: ./../index.php');
    exit();
}
?>
