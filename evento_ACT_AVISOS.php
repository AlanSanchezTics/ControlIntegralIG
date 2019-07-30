<?php
    include 'database.php';

    $sql = "CREATE EVENT `ACT_AG` ON SCHEDULE AT NOW() DO UPDATE tbl_avisosgenerales SET PROGRAMADO = 0 WHERE FECHA_INICIAL <= CURRENT_TIMESTAMP";
    mysqli_query($sql);
    $sql = "CREATE EVENT `ACT_AN` ON SCHEDULE AT NOW() DO UPDATE tbl_avisos_nivel SET PROGRAMADO = 0 WHERE FECHA_INICIAL <= CURRENT_TIMESTAMP";
    mysqli_query($sql);
    $sql = "CREATE EVENT `ACT_AGP` ON SCHEDULE AT NOW() DO UPDATE tbl_avisos_grupo SET PROGRAMADO = 0 WHERE FECHA_INICIAL <= CURRENT_TIMESTAMP";
    mysqli_query($sql);
    $sql = "CREATE EVENT `ACT_AP` ON SCHEDULE AT NOW() DO UPDATE tbl_avisos_alumno SET PROGRAMADO = 0 WHERE FECHA_INICIAL <= CURRENT_TIMESTAMP";
    mysqli_query($sql);
?>