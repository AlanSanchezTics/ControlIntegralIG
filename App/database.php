<?php
    include '../error_log.php';
    set_error_handler('error');
    date_default_timezone_set("America/Mexico_city");
    $conexion = new mysqli('localhost', 'u720362080_sa', 'COOC9N7N', 'u720362080_ciig');
    //$conn = new mysqli('localhost', 'root', '', 'u720362080_ciaig');
    $tildes = $conexion->query("SET NAMES 'utf8'");
?>