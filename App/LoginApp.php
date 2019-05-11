<?php
    include '../error_log.php';
    set_error_handler('error');
    $json =file_get_contents("php://input");
    $obj = json_decode($json,true);
    $arreglo = array();
    $usuario = $obj["usuario"];
    $clave = $obj["clave"];
    $token = $obj["token"];

    if($usuario !="" ){
   include 'database.php';
        $sql = "SELECT tbl_alumnos.ID_ALUMNO,tbl_alumnos.ID_USUARIO,tbl_alumnos.NOMBRE,tbl_alumnos.A_PATERNO,tbl_alumnos.A_MATERNO,tbl_alumnos.GRADO,tbl_grupos.NOMBRE AS 'Grupo',tbl_grupos.ID_GRUPO FROM tbl_alumnos,tbl_usuarios,tbl_grupos,tbl_asignaciongrupos WHERE tbl_usuarios.LOGIN='{$usuario}' AND tbl_usuarios.CLAVE=AES_ENCRYPT('{$clave}','INDIRAGANDHI2017') AND tbl_usuarios.ID_USUARIO = tbl_alumnos.ID_USUARIO AND tbl_asignaciongrupos.ID_GRUPO=tbl_grupos.ID_GRUPO AND tbl_asignaciongrupos.ID_ALUMNO = tbl_alumnos.ID_ALUMNO AND tbl_alumnos.EXISTE= 1";
        $result = mysqli_query($conexion,$sql);
        
        if($result){
            if($reg = mysqli_fetch_array($result)){
                $arreglo = array('idAlumno' => $reg["ID_ALUMNO"], 'idUsuario' => $reg["ID_USUARIO"],'name' =>$reg["NOMBRE"], 'apat' =>$reg["A_PATERNO"], 'amat' => $reg["A_MATERNO"], 'grado' => $reg["GRADO"], 'grupo' =>$reg["Grupo"], 'idGrupo' =>$reg["ID_GRUPO"] );
                $id=$reg["ID_USUARIO"];
                $sql1 = "UPDATE tbl_usuarios SET TOKEN='{$token}' WHERE ID_USUARIO = '{$id}'";
                mysqli_query($conexion,$sql1);
            }
            echo json_encode($arreglo);
        }else{
            echo json_encode("");
        }
        
    }else{
        echo json_encode("empty");
    }
?>