<?php
    include 'database.php';

    $sql = "UPDATE tbl_tareas SET PROGRAMADO = 0 WHERE FECHA_CREACION <= CURRENT_TIMESTAMP";
    mysqli_query($conn,$sql);

    echo "Tareas actualizadas";
?>