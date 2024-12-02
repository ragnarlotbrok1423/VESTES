<?php
session_start();

//Seccion para hacer activa una direccion
if (!isset($_SESSION['user']['id'])) {
    // Redirigir a login.php si no ha iniciado sesión
    header("Location: login.php");
    exit;
}

