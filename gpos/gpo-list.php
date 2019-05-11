<?php
include 'error_log.php';
    session_name("webSession");
    session_start();
    if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='S' && isset($_POST['nivel'])){
        include '../database.php';

        $sql ="SELECT tbl_grupos.id_grupo,tbl_grupos.nombre,tbl_grupos.grado,dce.id_docente,dce.a_paterno,dce.nombre,dci.id_docente,dci.a_paterno,dci.nombre, tbl_grupos.NIVEL FROM tbl_grupos
        INNER JOIN tbl_docentes dce on tbl_grupos.id_docente_E=dce.id_docente
        INNER JOIN tbl_docentes dci on tbl_grupos.id_docente_i=dci.id_docente AND tbl_grupos.existe=1 AND tbl_grupos.nivel={$_POST['nivel']} order by tbl_grupos.grado ";

        $result = mysqli_query($conn,$sql);

            if(!$result){
                die("Query Failed ". mysqli_error($conn));
            }
            
            $json = array();
                while($row = mysqli_fetch_array($result)){
                    $json["data"][] = array(
                        'id' => $row[0],
                        'grupo' => $row[1],
                        'grado' => $row[2],
                        'gpo' => $row[2]."°".$row[1],
                        'id_doc_esp'=>$row[3],
                        'doc-esp' => $row[5]." ".$row[4],
                        'id_doc_ing'=>$row[6],
                        'doc-ing' => $row[8]." ".$row[7],
                        'nivel' => $row[9]
                    );
                }
                echo json_encode($json);
    }else{
        header("HTTP/1.0 404 Not Found");
    }
?>