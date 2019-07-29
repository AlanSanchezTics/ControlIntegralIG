<?php
    include_once '../error_log.php';
    set_error_handler('error');
    date_default_timezone_set("America/Mexico_city");
    include '../database.php';
    //$conexion = new mysqli('localhost', 'u720362080_sa', 'COOC9N7N', 'u720362080_ciig');
    //$conexion = new mysqli('localhost', 'root', '', 'u720362080_ciaigserver');
    $conexion = $conn;
    $tildes = $conexion->query("SET NAMES 'utf8'");
?>