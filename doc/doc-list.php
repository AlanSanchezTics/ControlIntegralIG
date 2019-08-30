<?php
include_once '../error_log.php';
set_error_handler('error');
session_name("webSession");
session_start();
if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='S'){
    include '../database.php';

    $sql="SELECT ID_DOCENTE, NOMBRE, A_PATERNO, A_MATERNO, TEL, EMAIL, tbl_usuarios.LOGIN,tbl_usuarios.ID_USUARIO FROM tbl_usuarios, tbl_docentes WHERE tbl_docentes.ID_USUARIO = tbl_usuarios.ID_USUARIO AND tbl_docentes.EXISTE=1 ORDER BY ID_DOCENTE";
    $result = mysqli_query($conn,$sql);

    if(!$result){
        die("Query Failed ". mysqli_error($conn));
    }
    
    $json = ["data"=>[]];
        while($row = mysqli_fetch_array($result)){
            $json["data"][] = array(
                'id' => $row[0],
                'nombre' => $row[1],
                'apaterno' => $row[2],
                'amaterno' => $row[3],
                'telefono' => $row[4],
                'email' => $row[5],
                'usuario' => $row[6],
                'usu_ID' => $row[7]
            );
        }
        echo json_encode($json);
}else{
    header("HTTP/1.0 404 Not Found");
}
?>