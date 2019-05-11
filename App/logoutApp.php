<?php
include '../error_log.php';
set_error_handler('error');
$json =file_get_contents("php://input");
$obj = json_decode($json,true);
$idAlumno = "2018"."".$obj["idAlumno"];

include "database.php";
$sql ="UPDATE tbl_usuarios SET TOKEN = NULL WHERE LOGIN = '{$idAlumno}'";
if(mysqli_query($conexion,$sql)===TRUE){
    echo json_encode(true);
}else{
    echo json_encode(false);
}
?>