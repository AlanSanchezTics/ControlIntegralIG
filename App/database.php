<?php
    include_once '../error_log.php';
    set_error_handler('error');
    date_default_timezone_set("America/Mexico_city");
    include '../database.php';
    $conexion = $conn;
    $tildes = $conexion->query("SET NAMES 'utf8'");
?>