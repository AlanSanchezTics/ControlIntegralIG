<?php
include '../../error_log.php';
set_error_handler('error');
session_name("webSession");
session_start();
if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='D' && isset($_POST['nivel'])){
    $idDoc = $_SESSION['ID_DOCENTE'];
    include '../../database.php';
    $sql = "SELECT tbl_tareas.ID_TAREA, tbl_tareas.TITULO_TAREA, tbl_tareas.DESCRIPCION_TAREA, tbl_tareas.FECHA_CREACION , tbl_tareas.FECHA_ENTREGA,tbl_grupos.ID_GRUPO, tbl_grupos.GRADO, tbl_grupos.NOMBRE, tbl_grupos.NIVEL,tbl_tareas.TIPO_TAREA FROM tbl_tareas, tbl_grupos WHERE tbl_tareas.ID_GRUPO = tbl_grupos.ID_GRUPO AND  tbl_tareas.existe = 1 AND  tbl_tareas.ID_DOCENTE = {$idDoc} ORDER BY tbl_tareas.ID_TAREA DESC";
    $result = mysqli_query($conn,$sql);
    if(!$result)
        die("SQL ERROR: ".mysqli_error($conn));

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $fi = date_create($row[3]);
        $fe = date_create($row[4]);
        $json["data"][]=array(
            'id' => $row[0],
            'titulo' => $row[1],
            'contenido' => $row[2],
            'fi' => date_format($fi, 'd/m/y'),
            'fe' => date_format($fe, 'd/m/y'),
            'fechaI'=> date_format($fi, 'Y-m-d'),
            'fechaF'=> date_format($fe, 'Y-m-d'),
            'IDgrupo' =>$row[5],
            'grado' => $row[6]."°".$row[7]." ".$row[8],
            'tipo' => $row[9]
        );
    }
    echo json_encode($json);
}else{
    header("HTTP/1.0 404 Not Found");
}
?>