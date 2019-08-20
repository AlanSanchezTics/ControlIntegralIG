<?php
include_once '../error_log.php';
set_error_handler('error');

function getDocs(){
    include '../database.php';

    $sql = "SELECT ID_DOCENTE,NOMBRE , A_PATERNO, A_MATERNO FROM tbl_docentes WHERE EXISTE= 1";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("SQL ERROR 5: ".mysqli_error($conn));
    }
    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json["data"][] = array(
            'id' => $row[0],
            'nombre' => $row[1],
            'apaterno' => $row[2],
            'amaterno' => $row[3]
        );
    }
    echo json_encode($json);
}
function registrarAsignatura($materia, $docente){
    include '../database.php';
    mysqli_autocommit($conn, FALSE);

    $sql = "INSERT INTO tbl_materias(NOMBRE_MATERIA, ID_DOCENTE) VALUES('{$materia}', {$docente})";
    if(mysqli_query($conn,$sql)===FALSE){
        $error = mysqli_error($conn);
        mysqli_rollback($conn);
        die("SQL ERROR: ".$error);
    }
    mysqli_commit($conn);
    die("ADDED");
}
function editarAsignatura($id,$materia, $docente){
    include '../database.php';
    mysqli_autocommit($conn, FALSE);

    $sql = "UPDATE tbl_materias SET NOMBRE_MATERIA = '{$materia}', ID_DOCENTE= '{$docente}' WHERE ID_MATERIA = {$id}";
    if(mysqli_query($conn,$sql)===FALSE){
        $error = mysqli_error($conn);
        mysqli_rollback($conn);
        die("SQL ERROR: ".$error);
    }
    mysqli_commit($conn);
    die("UPDATED");
}
function eliminarAsignatura($id){
    include '../database.php';
    mysqli_autocommit($conn, FALSE);

    $sql = "UPDATE tbl_materias SET EXISTE = 0 WHERE ID_MATERIA = {$id}";
    if(mysqli_query($conn,$sql)===FALSE){
        $error = mysqli_error($conn);
        mysqli_rollback($conn);
        die("SQL ERROR: ".$error);
    }
    mysqli_commit($conn);
    die("DELETED");
}
session_name("webSession");
session_start();
if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='S' && isset($_POST["opcion"])){
    $opcion = $_POST["opcion"];

    switch ($opcion) {
        case 'GETDOCS':
            getDocs();
            break;
        case 'REGISTRAR':
            $materia = $_POST["asignatura"];
            $docente = $_POST["docente"];
            registrarAsignatura($materia, $docente);
            break;
        case 'EDITAR':
            $id = $_POST["idasignatura"];
            $materia = $_POST["asignatura"];
            $docente = $_POST["docente"];
            editarAsignatura($id, $materia, $docente);
        break;
        case 'ELIMINAR':
            $id = $_POST["idasignatura"];
            eliminarAsignatura($id);
            break;
    }
}else{
    header("HTTP/1.0 404 Not Found");
}
?>