<?php
    include_once 'error_log.php';
    set_error_handler('error');
    date_default_timezone_set("America/Mexico_city");
    $conn = new mysqli('localhost', 'root', '', 'u720362080_ciaig');
    $tildes = $conn->query("SET NAMES 'utf8'");
?>