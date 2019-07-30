<?php
    include 'database.php';

    $sql = "UPDATE tbl_avisosgenerales SET PROGRAMADO = 0 WHERE FECHA_INICIAL <= CURRENT_TIMESTAMP";
    mysqli_query($conn,$sql);
    $sql = "UPDATE tbl_avisos_nivel SET PROGRAMADO = 0 WHERE FECHA_INICIAL <= CURRENT_TIMESTAMP";
    mysqli_query($conn,$sql);
    $sql = "UPDATE tbl_avisos_grupo SET PROGRAMADO = 0 WHERE FECHA_INICIAL <= CURRENT_TIMESTAMP";
    mysqli_query($conn,$sql);
    $sql = "UPDATE tbl_avisos_alumno SET PROGRAMADO = 0 WHERE FECHA_INICIAL <= CURRENT_TIMESTAMP";
    mysqli_query($conn,$sql);

    echo "Avisos Actualizados";
?>