<?php
include_once '../error_log.php';
set_error_handler('error');
session_name("webSession");
session_start();
if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='S' && isset($_POST["tipo"])){
    include '../database.php';
        $sql ="";
        $json = array();

        switch ($_POST['tipo']) {
            case 'Generales':
                $sql = "SELECT ID_AVISO, TITULO_AVISO, DESCRIPCION_AVISO, FECHA_INICIAL, FECHA_FINAL, tbl_administradores.NOMBRE, IMAGEN_AVISO, PROGRAMADO FROM tbl_avisosgenerales,tbl_administradores WHERE tbl_avisosgenerales.ID_ADMIN = tbl_administradores.ID_ADMIN AND tbl_avisosgenerales.EXISTE=1 ORDER BY ID_AVISO DESC";
                $result = mysqli_query($conn,$sql);
                if(!$result){
                    die("Query Failed ". mysqli_error($conn));
                }
                    while($row = mysqli_fetch_array($result)){
                        $fi = date_create($row[3]);
                        $fe = date_create($row[4]);
                        $json["data"][] = array(
                            'id' => $row[0],
                            'titulo' => $row[1],
                            'contenido' => nl2br($row[2]),
                            'fi' => date_format($fi, 'd/m/y'),
                            'fe' => date_format($fe, 'd/m/y'),
                            'fechaI' => $row[3],
                            'fechaF' => date_format($fe, 'Y-m-d'),
                            'admin' => $row[5],
                            'tipo' => 'general',
                            'imagen' => ($row[6]!="" ? './images/'.$row[6] : ""),
                            'estado' => ($row[7]!=0 ? 'Programado': 'Lanzado')
                        );
                    }
                break;
            case 'Nivel':
                $sql = "SELECT ID_AVISO, TITULO_AVISO, DESCRIPCION_AVISO, FECHA_INICIAL, FECHA_FINAL,tbl_administradores.NOMBRE, NIVEL, IMAGEN_AVISO, PROGRAMADO FROM tbl_avisos_nivel, tbl_administradores WHERE tbl_avisos_nivel.ID_ADMIN = tbl_administradores.ID_ADMIN AND tbl_avisos_nivel.EXISTE=1 ORDER BY ID_AVISO DESC";    
                $result = mysqli_query($conn,$sql);
                if(!$result){
                    die("Query Failed ". mysqli_error($conn));
                }
                    while($row = mysqli_fetch_array($result)){
                        $fi = date_create($row[3]);
                        $fe = date_create($row[4]);
                        $json["data"][] = array(
                            'id' => $row[0],
                            'titulo' => $row[1],
                            'contenido' => nl2br($row[2]),
                            'fi' => date_format($fi, 'd/m/y'),
                            'fe' => date_format($fe, 'd/m/y'),
                            'fechaI' => date_format($fi, 'Y-m-d'),
                            'fechaF' => date_format($fe, 'Y-m-d'),
                            'admin' => $row[5],
                            'nivel' => setNivel($row[6]),
                            'destinatario' => $row[6],
                            'tipo' => 'nivel',
                            'imagen' => ($row[7]!="" ? './images/'.$row[7] : ""),
                            'estado' => ($row[8]!=0 ? 'Programado': 'Lanzado')
                        );
                    }
                break;
            case 'Grupo':
                $sql = "SELECT ID_AVISO, TITULO_AVISO, DESCRIPCION_AVISO, FECHA_INICIAL, FECHA_FINAL,tbl_administradores.NOMBRE, tbl_grupos.GRADO, tbl_grupos.NOMBRE, tbl_grupos.NIVEL, tbl_grupos.ID_GRUPO, IMAGEN_AVISO, PROGRAMADO FROM tbl_avisos_grupo, tbl_administradores,tbl_grupos WHERE tbl_avisos_grupo.ID_ADMIN = tbl_administradores.ID_ADMIN AND tbl_avisos_grupo.ID_GRUPO = tbl_grupos.ID_GRUPO AND tbl_avisos_grupo.EXISTE=1 ORDER BY ID_AVISO DESC";
                $result = mysqli_query($conn,$sql);
                if(!$result){
                    die("Query Failed ". mysqli_error($conn));
                }
                    while($row = mysqli_fetch_array($result)){
                        $fi = date_create($row[3]);
                        $fe = date_create($row[4]);
                        $json["data"][] = array(
                            'id' => $row[0],
                            'titulo' => $row[1],
                            'contenido' => nl2br($row[2]),
                            'fi' => date_format($fi, 'd/m/y'),
                            'fe' => date_format($fe, 'd/m/y'),
                            'fechaI' => date_format($fi, 'Y-m-d'),
                            'fechaF' => date_format($fe, 'Y-m-d'),
                            'admin' => $row[5],
                            'gpo' => $row[6]."°".$row[7]." - ".setNivel($row[8]),
                            'destinatario' =>$row[9],
                            'tipo' => 'grupo',
                            'imagen' => ($row[10]!="" ? './images/'.$row[10] : ""),
                            'estado' => ($row[11]!=0 ? 'Programado': 'Lanzado')
                        );
                    }
                break;
            case 'Personal':
                $sql = "SELECT ID_AVISO, TITULO_AVISO, DESCRIPCION_AVISO, FECHA_INICIAL, FECHA_FINAL,tbl_administradores.NOMBRE, tbl_alumnos.NOMBRE,tbl_alumnos.A_PATERNO, tbl_alumnos.ID_ALUMNO, IMAGEN_AVISO, PROGRAMADO FROM tbl_avisos_alumno, tbl_administradores,tbl_alumnos WHERE tbl_avisos_alumno.ID_ADMIN = tbl_administradores.ID_ADMIN AND tbl_avisos_alumno.ID_ALUMNO= tbl_alumnos.ID_ALUMNO AND tbl_avisos_alumno.EXISTE=1  ORDER BY ID_AVISO DESC";
                $result = mysqli_query($conn,$sql);
                if(!$result){
                    die("Query Failed ". mysqli_error($conn));
                }
                    while($row = mysqli_fetch_array($result)){
                        $fi = date_create($row[3]);
                        $fe = date_create($row[4]);
                        $json["data"][] = array(
                            'id' => $row[0],
                            'titulo' => $row[1],
                            'contenido' => nl2br($row[2]),
                            'fi' => date_format($fi, 'd/m/y'),
                            'fe' => date_format($fe, 'd/m/y'),
                            'fechaI' => date_format($fi, 'Y-m-d'),
                            'fechaF' => date_format($fe, 'Y-m-d'),
                            'admin' => $row[5],
                            'alumno' => $row[6]." ".$row[7],
                            'destinatario' => $row[8],
                            'tipo' => 'alumno',
                            'imagen' => ($row[9]!="" ? './images/'.$row[9] : ""),
                            'estado' => ($row[10]!=0 ? 'Programado': 'Lanzado')
                        );
                    }
                break;
        }
        echo json_encode($json);
}else{
    header("HTTP/1.0 404 Not Found");
}

    function setNivel($e){
        $nivel = "";
        switch ($e) {
            case '0':
                $nivel = "Pre Kinder";
                break;
            case '1':
                $nivel = "Preescolar";
                break;
            case '2':
                $nivel = "Primaria";
                break;
            case '3':
                $nivel = "Secundaria";
                break;
        }
        return $nivel;
    }
?>