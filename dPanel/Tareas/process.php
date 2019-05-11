<?php
function getGpos($idDoc){
    include '../../database.php';

    $sql = "SELECT ID_GRUPO, GRADO,NOMBRE, NIVEL FROM tbl_grupos WHERE ID_DOCENTE_E =" . $idDoc . "  OR ID_DOCENTE_I = " . $idDoc . " AND EXISTE = 1";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("Query Failed ". mysqli_error($conn));
    }
    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json["data"][] = array(
            'id' => $row[0],
            'gpo' => $row[1]."°".$row[2]." - ".setNivel($row[3])
        );
    }
    echo json_encode($json);
}
function getTareas($idDoc){
    include '../../database.php';
    $sql = "SELECT tbl_tareas.ID_TAREA, tbl_tareas.TITULO_TAREA, tbl_tareas.DESCRIPCION_TAREA, tbl_tareas.FECHA_CREACION , tbl_tareas.FECHA_ENTREGA,tbl_grupos.ID_GRUPO, tbl_grupos.GRADO, tbl_grupos.NOMBRE, tbl_grupos.NIVEL,tbl_tareas.TIPO_TAREA, tbl_tareas.IMAGEN_TAREA FROM tbl_tareas, tbl_grupos WHERE tbl_tareas.ID_GRUPO = tbl_grupos.ID_GRUPO AND  tbl_tareas.existe = 1 AND  tbl_tareas.ID_DOCENTE = {$idDoc} ORDER BY tbl_tareas.ID_TAREA DESC";
    $result = mysqli_query($conn,$sql);
    if(!$result)
        die("SQL ERROR: ".mysqli_error($conn));

    $json = array();
    while ($row = mysqli_fetch_array($result)) {
        $fi = date_create($row[3]);
        $fe = date_create($row[4]);
        switch ($row[9]) {
            case 'es':
                $asignatura="Español";
                break;
            case 'en':
                $asignatura="Ingles";
                break;
            case 'ms':
                $asignatura="Musica";
                break;
            case 'co':
                $asignatura="Computación";
                break;
            case 'ef':
                $asignatura="Deportes";
                break;
        }
        $json["data"][]=array(
            'id' => $row[0],
            'titulo' => $row[1],
            'contenido' => nl2br($row[2]),
            'fi' => date_format($fi, 'd/m/y'),
            'fe' => date_format($fe, 'd/m/y'),
            'fechaI'=> date_format($fi, 'Y-m-d'),
            'fechaF'=> date_format($fe, 'Y-m-d'),
            'IDgrupo' =>$row[5],
            'grupo' => $row[6]."°".$row[7]." ".setNivel($row[8]),
            'tipo' => $row[9],
            'asignatura' => $asignatura,
            'imagen' => ($row[10]!="" ? './images/'.$row[10] : "")
        );
    }
    echo json_encode($json);
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
function reenviarTarea($idTarea, $idGrupo){
    include '../../database.php';

    $sql = "SELECT * FROM tbl_tareas WHERE ID_TAREA = $idTarea";
    $result = $conn -> query($sql);
    if(!$result)
        die("SQL ERROR: ". mysqli_error($conn));

    $reg = mysqli_fetch_array($result);
    $sql = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos, tbl_asignaciongrupos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND tbl_asignaciongrupos.ID_GRUPO = $idGrupo AND tbl_asignaciongrupos.ID_ALUMNO = tbl_alumnos.ID_ALUMNO AND LENGTH(TOKEN) < 50";
    $result = mysqli_query($conn,$sql);
    if(!$result)
        die("SQL ERROR: ". mysqli_error($conn));

    $tokens = array();
    if(mysqli_num_rows($result) > 0 ){
        while($row = mysqli_fetch_array($result)) {
            $tokens[] = $row["TOKEN"];
        }
        $message = array('Message' => "Tu docente acaba de subir una tarea, rivisala ahora!!", 'Title' =>$reg[1], 'body' =>$reg[2], 'imagen' => 'dPanel/Tareas/images/'.$reg[3],'FechaI' => $reg[4], 'FechaF' => $reg[5]);
        sendMessage($tokens, $message);
    }
    die("SEND");
    //echo json_encode($tokens);
}
function postTarea($titulo,$contenido,$fechaI,$fechaF,$grupo,$materia,$idDoc,$foto){
    include '../../database.php';
    $imagen = NULL;
    if($foto['name']!=""){
        $nombre = mt_rand();
        $tipoarchivo=$foto['type'];
        $rest = substr($tipoarchivo,6);                            
        $ruta="images/".$nombre.".".$rest;
        $imagen = $nombre.".".$rest;
        //$nombreimagen="https://www.ciaigandhi.com/AlumnosPanel/".$ruta;
    }
    $sql ="INSERT INTO tbl_tareas(titulo_tarea,descripcion_tarea,imagen_tarea,fecha_creacion,fecha_entrega,id_grupo,tipo_tarea,id_docente,existe) VALUES('{$titulo}','{$contenido}','{$imagen}','{$fechaI}','{$fechaF} 13:00:00',$grupo,'{$materia}',{$idDoc},1)";
    if(mysqli_query($conn,$sql)===FALSE)
        die("SQL ERROR: ".mysqli_error($conn));
    
    if($foto["name"]!="")    
        move_uploaded_file($foto['tmp_name'],$ruta);

    $sql = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos, tbl_asignaciongrupos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND tbl_asignaciongrupos.ID_GRUPO = $grupo AND tbl_asignaciongrupos.ID_ALUMNO = tbl_alumnos.ID_ALUMNO AND LENGTH(TOKEN) < 50";
    $result = mysqli_query($conn,$sql);
    if(!$result)
        die("SQL ERROR: ".mysqli_error($conn));
    
    $tokens = array();
    if(mysqli_num_rows($result) > 0 ){
        while ($row = mysqli_fetch_array($result)) {
            $tokens[] = $row["TOKEN"];
        }
        $message = array('Message' => "Tu docente acaba de subir una tarea, rivisala ahora!!", 'Title' =>$titulo, 'body' =>$contenido, 'imagen' => 'dPanel/Tareas/images/'.$imagen,'FechaI' => $fechaI, 'FechaF' => $fechaF);
        sendMessage($tokens, $message);
    }
    die("ADDED"); 
}
function repostTarea($idTarea,$titulo,$contenido,$fechaI,$fechaF,$grupo,$materia,$idDoc,$foto,$imgName,$notificar){
    include '../../database.php';

    $imagen = NULL;
    if($imgName==""){
        if($foto['name']!=""){
            $nombre = mt_rand();
            $tipoarchivo=$foto['type'];
            $rest = substr($tipoarchivo,6);                            
            $ruta="images/".$nombre.".".$rest;
            $imagen = $nombre.".".$rest;
        }
    }else{
        $imagen = substr($imgName,9);
    }

    $sql = "UPDATE tbl_tareas SET TITULO_TAREA = '{$titulo}', DESCRIPCION_TAREA='{$contenido}',IMAGEN_TAREA='{$imagen}',FECHA_CREACION='{$fechaI}',FECHA_ENTREGA='{$fechaF}',ID_GRUPO={$grupo},TIPO_TAREA='{$materia}',ID_DOCENTE={$idDoc} WHERE ID_TAREA = {$idTarea}";
    if(mysqli_query($conn,$sql)===FALSE)
        die("SQL ERROR: ".mysqli_error($conn));
    
    if($foto["name"]!="")
        move_uploaded_file($foto['tmp_name'],$ruta);

    if($notificar=="on"){
        $sql = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos, tbl_asignaciongrupos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND tbl_asignaciongrupos.ID_GRUPO = $grupo AND tbl_asignaciongrupos.ID_ALUMNO = tbl_alumnos.ID_ALUMNO AND LENGTH(TOKEN) < 50";
        $result = mysqli_query($conn,$sql);
        if(!$result)
            die("SQL ERROR: ".mysqli_error($conn));
        
        $tokens = array();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $tokens[] = $row["TOKEN"];
            }
            $message = array('Message' => "Tu docente acaba de subir una tarea, rivisala ahora!!", 'Title' =>$titulo, 'body' =>$contenido, 'imagen' => 'dPanel/Tareas/images/'.$imagen,'FechaI' => $fechaI, 'FechaF' => $fechaF);
            sendMessage($tokens, $message);
        }
    }
    die("UPDATED");
}
function eliminarTarea($idTarea){
    include '../../database.php';

    $sql = "UPDATE tbl_tareas SET EXISTE = 0 WHERE ID_TAREA = $idTarea";
    $result = mysqli_query($conn, $sql);
    if(!$result){die("SQL ERROR: ".mysqli_error($conn));}
    die("DELETED");
}
function sendMessage($tokens, $message){
    $content = array(
        "en" => 'Tu docente acaba de subir una tarea, rivisala ahora!!'
        );
    $headings = array(
        "en" =>$message["Title"]
    );
    $fields = array(
        'app_id' => "775aebac-196e-43bd-9a15-19903cf07d9d",
        'include_player_ids' => $tokens,
        'data' => $message,
        'contents' => $content,
        'headings' => $headings
    );
    
    $fields = json_encode($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic ZTJiMTIwNDgtZjZmOS00ODBhLTkzOWMtZjBiNTM1ODJlNmRm'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}
session_name("webSession");
session_start();
if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='D' && isset($_POST["opcion"])){
    $opcion = $_POST['opcion'];
    $idDoc = $_SESSION["ID_DOCENTE"];

    switch ($opcion) {
        case 'GETGPOS':
            getGpos($idDoc);
            break;
        case 'GETTAREAS':
            getTareas($idDoc);
            break;
        case 'REGISTRAR':
            $titulo = $_POST["titulo"];
            $contenido = $_POST["contenido"];
            $fechaI = $_POST["fechaI"];
            $fechaF = $_POST["fechaF"];
            $grupo = $_POST["destinatario"];
            $materia = $_POST["tipo"];
            $foto = $_FILES["imagen"];
            postTarea($titulo,$contenido,$fechaI,$fechaF,$grupo,$materia,$idDoc,$foto);
            break;
        case 'EDITAR':
            $idTarea = $_POST["idTarea"];
            $titulo = $_POST["titulo"];
            $contenido = $_POST["contenido"];
            $fechaI = $_POST["fechaI"];
            $fechaF = $_POST["fechaF"];
            $grupo = $_POST["destinatario"];
            $materia = $_POST["tipo"];
            $foto = $_FILES["imagen"];
            $imgName = $_POST['imgName'];
            $notificar = (isset($_POST["notificar"]) ? $_POST["notificar"] : "");
            repostTarea($idTarea,$titulo,$contenido,$fechaI,$fechaF,$grupo,$materia,$idDoc,$foto,$imgName,$notificar);
            break;
        case 'RESEND':
            $idTarea = $_POST["idTarea"];
            $idGrupo = $_POST["destinatario"];
            reenviarTarea($idTarea, $idGrupo);
            break;
        case 'ELIMINAR':
            $idTarea = $_POST["idTarea"];
            eliminarTarea($idTarea);
            break;
    }
}else{
    header("HTTP/1.0 404 Not Found");
}
?>