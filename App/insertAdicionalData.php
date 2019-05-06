<?php 
    if(isset($_GET["sql"])){
        include "conexion.php";
        $sql = $_GET["sql"];

        if($sql){
            mysqli_query($conexion,$sql);
        }
    }
?>