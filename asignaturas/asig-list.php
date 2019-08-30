<?php
include_once '../error_log.php';
set_error_handler('error');
session_name("webSession");
session_start();
if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='S'){
    include '../database.php';

    $sql = "SELECT tbl_materias.ID_MATERIA, tbl_materias.NOMBRE_MATERIA, tbl_docentes.NOMBRE, tbl_docentes.A_PATERNO, tbl_docentes.A_MATERNO, tbl_materias.ID_DOCENTE FROM tbl_materias, tbl_docentes WHERE tbl_materias.ID_DOCENTE = tbl_docentes.ID_DOCENTE AND tbl_docentes.EXISTE = 1 AND tbl_materias.EXISTE = 1";
    $result = mysqli_query($conn,$sql);

    if(!$result){
        die("Query Failed ". mysqli_error($conn));
    }
    
    $json = ["data"=>[]];
    while($row = mysqli_fetch_array($result)){
        $json["data"][] = array(
            'id' => $row[0],
            'materia' => $row[1],
            'docente' => $row[2]." ".$row[3]." ".$row[4],
            'iddoc' => $row[5]
        );
    }
    echo json_encode($json);
}else{
header("HTTP/1.0 404 Not Found");
}
?>