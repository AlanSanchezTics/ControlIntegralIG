<?php
    include_once '../error_log.php';
    set_error_handler('error');
    if(isset($_GET["sql"])){
        include "conexion.php";
        $sql = $_GET["sql"];

        if($sql){
            mysqli_query($conexion,$sql);
        }
    }
?>