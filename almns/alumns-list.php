<?php
session_name("webSession");
session_start();
if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='S' && isset($_POST["gdo"]) && isset($_POST["gpo"])){
    include 'database.php';
        $sql="SELECT tbl_alumnos.ID_ALUMNO,tbl_alumnos.NOMBRE, tbl_alumnos.A_PATERNO, tbl_alumnos.A_MATERNO, tbl_alumnos.TEL, tbl_alumnos.EMAIL, tbl_usuarios.LOGIN, tbl_usuarios.ID_USUARIO, tbl_alumnos.FECHA_INGRESO, tbl_alumnos.FECHA_EGRESO,tbl_alumnos.imagen FROM `tbl_asignaciongrupos`,tbl_alumnos,tbl_grupos, tbl_usuarios WHERE tbl_alumnos.ID_USUARIO=tbl_usuarios.ID_USUARIO AND tbl_asignaciongrupos.ID_GRUPO = tbl_grupos.ID_GRUPO AND tbl_asignaciongrupos.ID_ALUMNO = tbl_alumnos.ID_ALUMNO AND tbl_grupos.NIVEL={$_POST['lvl']} AND tbl_grupos.GRADO = {$_POST["gdo"]} AND tbl_grupos.NOMBRE='{$_POST["gpo"]}' AND tbl_alumnos.EXISTE =1 ORDER BY tbl_alumnos.A_PATERNO";
        $result = mysqli_query($conn,$sql);

        if(!$result){
            die("Query Failed ". mysqli_error($conn));
        }

        $json = array();
        while($row = mysqli_fetch_array($result)){
            $json["data"][] = array(
                'noControl' => $row[0],
                'nombre' => $row[1],
                'apaterno' => $row[2],
                'amaterno' => $row[3],
                'telefono' => $row[4],
                'email' => $row[5],
                'usuario' => $row[6],
                'usu_ID' => $row[7],
                'fi' => $row[8],
                'fe' => $row[9],
                'foto' =>$row[10]
            );
        }
        echo json_encode($json);
    }else{
        header("HTTP/1.0 404 Not Found");
    }
?>