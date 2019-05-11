<?php
include 'error_log.php';
set_error_handler('error');
echo "Espere un momento, por favor...";
session_name("webSession");
session_start();
session_destroy();
header("Location: ./");
?>