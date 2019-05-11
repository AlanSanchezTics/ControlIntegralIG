<?php
    include_once '../error_log.php';
    set_error_handler('error');
    include '../database.php';
    $sql="SELECT ID_ADMIN, NOMBRE, A_PATERNO, A_MATERNO, tbl_usuarios.LOGIN, tbl_usuarios.ID_USUARIO FROM tbl_usuarios, tbl_administradores WHERE tbl_administradores.ID_USUARIO = tbl_usuarios.ID_USUARIO AND tbl_administradores.EXISTE= 0";
    $result = mysqli_query($conn,$sql);

    if(!$result){
        die("Query Failed ". mysqli_error($conn));
    }
    
    $json = array();
        while($row = mysqli_fetch_array($result)){
            $json["data"][] = array(
                'id' => $row[0],
                'nombre' => $row[1],
                'apaterno' => $row[2],
                'amaterno' => $row[3],
                'usuario' => $row[4],
                'usu_ID' => $row[5]
            );
        }
        echo json_encode($json);
?>