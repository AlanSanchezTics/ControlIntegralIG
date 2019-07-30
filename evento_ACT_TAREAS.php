<?php
    include 'database.php';

    $sql = "CREATE EVENT `ACT_TAREAS` ON SCHEDULE AT NOW() DO UPDATE tbl_tareas SET PROGRAMADO = 0 WHERE FECHA_CREACION <= CURRENT_TIMESTAMP";
    mysqli_query($sql);
?>