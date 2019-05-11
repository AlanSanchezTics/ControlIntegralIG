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
function obtenerTareas($idgrupo){
    include '../database.php';

    $sql ="SELECT ID_TAREA,TITULO_TAREA, DESCRIPCION_TAREA, TIPO_TAREA, tbl_docentes.NOMBRE, tbl_docentes.A_PATERNO, FECHA_ENTREGA, FECHA_CREACION FROM `tbl_tareas`, tbl_docentes, tbl_grupos WHERE tbl_docentes.ID_DOCENTE = tbl_tareas.ID_DOCENTE AND tbl_tareas.ID_GRUPO = tbl_grupos.ID_GRUPO AND tbl_tareas.ID_GRUPO = {$idgrupo}";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("SQL ERROR 27: ".mysqli_error($conn));
    }
    $json = array();
    while($row = mysqli_fetch_array($result)){
        $fe = date_create($row[6]);
        $fi = date_create($row[7]);
        switch ($row[3]) {
            case 'es':
                $row[3]="Español";
                break;
            case 'en':
                $row[3]="Ingles";
                break;
            case 'ms':
                $row[3]="Musica";
                break;
            case 'co':
                $row[3]="Computación";
                break;
            case 'ef':
                $row[3]="Deportes";
                break;
        }
        $json["data"][] = array(
            'id' => $row[0],
            'titulo' => $row[1],
            'contenido'=> nl2br($row[2]),
            'asignatura'=> $row[3],
            'docente'=> $row[4]." ".$row[5],
            'fe'=> date_format($fe, 'd/m/y'),
            'fi'=> date_format($fi, 'd/m/y'),
            'status' => ($row[6] >= date("Y-m-d H:i:s") ? "Activa":"Concluida")
        );
    }
    echo json_encode($json);
}
function nuevoGrupo($nivel,$grado,$grupo,$doce,$doci){
    include '../database.php';

    $sql = "SELECT ID_GRUPO FROM tbl_grupos WHERE NIVEL = {$nivel} AND GRADO = {$grado} AND NOMBRE = '{$grupo}'";
    $result =   mysqli_query($conn, $sql);
    if(!$result){
        die("SQL ERROR 24: ".mysqli_error($conn));
    }    
    $grupos = mysqli_num_rows($result);
    if ($grupos > 0) {
        die("EXISTGPO");
    }

    $sql = "INSERT INTO tbl_grupos(NIVEL,GRADO,ID_DOCENTE_E,ID_DOCENTE_I,NOMBRE,EXISTE) VALUES({$nivel}, {$grado}, {$doce}, {$doci}, '{$grupo}', 1)";
	if($conn -> query($sql) === TRUE){
		die("ADDED");
	}else{
        die("SQL ERROR 34: ".mysqli_error($conn));
    }
}
function modificarGrupo($idgrupo,$nivel,$grado,$grupo,$doce,$doci){
    include '../database.php';

    $sql = "SELECT ID_GRUPO FROM tbl_grupos WHERE NIVEL = {$nivel} AND GRADO = {$grado} AND NOMBRE = '{$grupo}' AND ID_GRUPO <> {$idgrupo}";
    $result =   mysqli_query($conn, $sql);
    if(!$result){
        die("SQL ERROR 44: ".mysqli_error($conn));
    }    
    $grupos = mysqli_num_rows($result);
    if ($grupos > 0) {
        die("EXISTGPO");
    }
    $sql = "UPDATE tbl_grupos SET NIVEL = {$nivel} , GRADO = {$grado} , ID_DOCENTE_E = {$doce} , ID_DOCENTE_I = {$doci} , NOMBRE = '{$grupo}' WHERE ID_GRUPO = {$idgrupo}";
    if($conn -> query($sql) === TRUE){
		die("UPDATED");
	}else{
        die("SQL ERROR 53: ".mysqli_error($conn));
    }
}
function EliminarGrupo($idgrupo){
    include '../database.php';
    $sql = "UPDATE tbl_grupos SET EXISTE = 0 WHERE ID_GRUPO = {$idgrupo}";

        if($conn -> query($sql) === TRUE){
            die("DELETED");
        }else{
            die("SQL ERROR 62: ".mysqli_error($conn));
        }
}
session_name("webSession");
session_start();
if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='S' && isset($_POST["opcion"])){
    $opcion = $_POST["opcion"];

    switch ($opcion) {
        case 'GETDOCS':
            getDocs();
            break;
        case 'EDITAR':
            $idgrupo = $_POST["idgpo"];
            $nivel= $_POST["nivel"];
            $grado= $_POST["gdo"];
            $grupo= $_POST["gpo"];
            $doce= $_POST["doc-esp"];
            $doci= $_POST["doc-ing"];
            modificarGrupo($idgrupo,$nivel,$grado,$grupo,$doce,$doci);
            break;
        case 'ELIMINAR':
            $idgrupo = $_POST["idgpo"];
            EliminarGrupo($idgrupo);
            break;
        case 'REGISTRAR':
            $nivel= $_POST["nivel"];
            $grado= $_POST["gdo"];
            $grupo= $_POST["gpo"];
            $doce= $_POST["doc-esp"];
            $doci= $_POST["doc-ing"];
            nuevoGrupo($nivel,$grado,$grupo,$doce,$doci);
            break;
        case 'GETTAREAS':
            $idgrupo = $_POST["idgpo"];
            obtenerTareas($idgrupo);
            break;
    }
}else{
    header("HTTP/1.0 404 Not Found");
}
?>