<?php
    include_once '../../error_log.php';
    set_error_handler('error');
    function getAlumnos($grupo,$iddoc){
        include '../../database.php';

        $sql = "SELECT tbl_alumnos.ID_ALUMNO,tbl_alumnos.NOMBRE, tbl_alumnos.A_PATERNO, tbl_alumnos.A_MATERNO, tbl_alumnos.TEL, tbl_alumnos.EMAIL FROM `tbl_asignaciongrupos`,tbl_alumnos,tbl_grupos WHERE tbl_asignaciongrupos.ID_GRUPO = tbl_grupos.ID_GRUPO AND tbl_asignaciongrupos.ID_ALUMNO = tbl_alumnos.ID_ALUMNO AND tbl_alumnos.EXISTE =1 AND tbl_asignaciongrupos.ID_GRUPO= {$grupo} ORDER BY tbl_alumnos.A_PATERNO";
        $result = mysqli_query($conn, $sql);
        if(!$result)
            die("SQL ERROR: ".mysqli_error($conn));

        $json = array();
        while($row = mysqli_fetch_array($result)){
            $json["data"][] = array(
                'noControl' => $row[0],
                'nombre' => $row[1],
                'apaterno' => $row[2],
                'amaterno' => $row[3],
                'telefono' => $row[4],
                'email' => $row[5]
            );
        }
        echo json_encode($json);
    }
    function getGrupos($idDoc){
        include '../../database.php';
        $sql = "SELECT ID_GRUPO, GRADO,NOMBRE, NIVEL FROM tbl_grupos WHERE ID_DOCENTE_E = {$idDoc}  OR ID_DOCENTE_I = {$idDoc} AND EXISTE = 1";
        
        $result = mysqli_query($conn,$sql);
        if(!$result)
        die("SQL ERROR: ".mysqli_error($conn));

        while ($row = mysqli_fetch_array($result)){
            $grupos[] = array(
                'id' => $row[0],
                'gpo' => $row[1]."°".$row[2]."-".setNivel($row[3])
            );
        }

        $sql = "SELECT ID_DOCENTE FROM tbl_materias WHERE ID_DOCENTE = {$idDoc}";
        $result = mysqli_query($conn,$sql);
        if(!$result)
        die("SQL ERROR: ".mysqli_error($conn));

        if(mysqli_num_rows($result) > 0 ){
            $sql = "SELECT ID_GRUPO, GRADO, NOMBRE, NIVEL FROM tbl_grupos WHERE ID_GRUPO = 17";
            $result = mysqli_query($conn,$sql);
            if(!$result)
            die("SQL ERROR: ".mysqli_error($conn));

            while ($row = mysqli_fetch_array($result)){
                $grupos[] = array(
                    'id' => $row[0],
                    'gpo' => $row[1]."°".$row[2]."-".setNivel($row[3])
                );
            }
        }
        echo json_encode($grupos);
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
    
    session_name("webSession");
    session_start();
    if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='D' && isset($_POST["opcion"])){
        $opcion = $_POST['opcion'];
        $idDoc = $_SESSION["ID_DOCENTE"];
        
        switch ($opcion) {
            case 'GETGPOS':
                getGrupos($idDoc);
                break;
            case 'GETALUMNOS':
                $grupo = $_POST['grupo'];
                getAlumnos($grupo,$idDoc);
                break;
        }
    }else{
        header("HTTP/1.0 404 Not Found");
    }
?>