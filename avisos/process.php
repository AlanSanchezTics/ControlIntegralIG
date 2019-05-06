<?php
function getGrupos(){
    include 'database.php';
    $sql = "SELECT ID_GRUPO, GRADO, NOMBRE, NIVEL FROM tbl_grupos WHERE EXISTE=1 ORDER BY ID_GRUPO";
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
function getAlumnos(){
    include 'database.php';
    $sql = "SELECT ID_ALUMNO, NOMBRE, A_PATERNO, A_MATERNO FROM tbl_alumnos WHERE EXISTE = 1";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("Query Failed ". mysqli_error($conn));
    }
    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json["data"][] = array(
            'id' => $row[0],
            'alumno' => $row[1]." ".$row[2]." ".$row[3]
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
function postAviso($tipo,$destinatario,$titulo,$contenido,$fechai,$fechaf,$idadmin,$foto){
    include "database.php";
    $imagen = NULL;
    if($foto['name']!=""){
        $nombre = mt_rand();
        $tipoarchivo=$foto['type'];
        $rest = substr($tipoarchivo,6);                            
        $ruta="images/".$nombre.".".$rest;
        $imagen = $nombre.".".$rest;
        //$nombreimagen="https://www.ciaigandhi.com/AlumnosPanel/".$ruta;
    }
    switch ($tipo) {
        case 'general':
            $sql = "INSERT INTO tbl_avisosgenerales(titulo_aviso,descripcion_aviso,imagen_aviso,fecha_inicial,fecha_final,id_admin,existe) VALUES('{$titulo}','{$contenido}','{$imagen}','{$fechai}','{$fechaf} 13:00:00',$idadmin,1)";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios WHERE USUTIPO = 'A' AND EXISTE = 1 AND TOKEN <> '' AND LENGTH(TOKEN) < 50 ";
            break;
        case 'nivel':
            $sql = "INSERT INTO tbl_avisos_nivel(titulo_aviso,descripcion_aviso,imagen_aviso,fecha_inicial,fecha_final,id_admin,nivel,existe) VALUES('{$titulo}','{$contenido}','{$imagen}','{$fechai}','{$fechaf} 13:00:00',$idadmin,$destinatario,1)";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.NIVEL=$destinatario AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND LENGTH(TOKEN) < 50";
            break;
        case 'grupo':
            $sql = "INSERT INTO tbl_avisos_grupo(titulo_aviso,descripcion_aviso,imagen_aviso,fecha_inicial,fecha_final,id_admin,id_grupo,existe) VALUES('{$titulo}','{$contenido}','{$imagen}','{$fechai}','{$fechaf} 13:00:00',$idadmin,$destinatario,1)";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos, tbl_asignaciongrupos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND tbl_asignaciongrupos.ID_GRUPO = $destinatario AND tbl_asignaciongrupos.ID_ALUMNO = tbl_alumnos.ID_ALUMNO AND LENGTH(TOKEN) < 50";
            break;
        case 'alumno':
            $sql = "INSERT INTO tbl_avisos_alumno(titulo_aviso,descripcion_aviso,imagen_aviso,fecha_inicial,fecha_final,id_admin,id_alumno,existe) VALUES('{$titulo}','{$contenido}','{$imagen}','{$fechai}','{$fechaf} 13:00:00',$idadmin,$destinatario,1)";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.ID_ALUMNO=$destinatario AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND LENGTH(TOKEN) < 50";
            break;
    }

    if(mysqli_query($conn,$sql)===FALSE)
        die("SQL ERROR: ".mysqli_error($conn));
    
    if($foto["name"]!="")    
        move_uploaded_file($foto['tmp_name'],$ruta);

    $result = mysqli_query($conn,$sqlTokens);
    if(!$result)
        die("SQL ERROR: ".mysqli_error($conn));

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $tokens[] = $row["TOKEN"];
        }
        $message = array('Message' => " La institucion acaba de publicar un aviso. Enterate ahora!!", 'Title' => $titulo, 'body' => $contenido, 'FechaI' => $fechai, 'FechaF' => $fechaf);
        $tipo = "Aviso ".$tipo;
        sendMessage($tokens, $message, $tipo);
    }
    die("ADDED");

}
function repostAviso($tipo,$destinatario,$idAviso,$notificar,$titulo,$contenido,$fechai,$fechaf,$idadmin,$foto,$imgName){
    include 'database.php';
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
    switch ($tipo) {
        case 'general':
            $sql = "UPDATE tbl_avisosgenerales SET TITULO_AVISO='{$titulo}', DESCRIPCION_AVISO='{$contenido}', IMAGEN_AVISO='{$imagen}', FECHA_INICIAL='{$fechai}', FECHA_FINAL='{$fechaf}', ID_ADMIN=$idadmin WHERE ID_AVISO = $idAviso";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios WHERE USUTIPO = 'A' AND EXISTE = 1 AND TOKEN <> '' AND LENGTH(TOKEN) < 50 ";
            break;
        case 'nivel':
            $sql = "UPDATE tbl_avisos_nivel SET TITULO_AVISO='{$titulo}', DESCRIPCION_AVISO='{$contenido}', IMAGEN_AVISO='{$imagen}', FECHA_INICIAL='{$fechai}',	FECHA_FINAL='{$fechaf}', ID_ADMIN=$idadmin, NIVEL=$destinatario WHERE ID_AVISO = $idAviso";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.NIVEL=$destinatario AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND LENGTH(TOKEN) < 50";
            break;
        case 'grupo':
            $sql = "UPDATE tbl_avisos_grupo SET TITULO_AVISO='{$titulo}', DESCRIPCION_AVISO='{$contenido}', IMAGEN_AVISO='{$imagen}', FECHA_INICIAL='{$fechai}', FECHA_FINAL='{$fechaf}', ID_ADMIN=$idadmin, ID_GRUPO=$destinatario WHERE ID_AVISO = $idAviso";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos, tbl_asignaciongrupos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND tbl_asignaciongrupos.ID_GRUPO = $destinatario AND tbl_asignaciongrupos.ID_ALUMNO = tbl_alumnos.ID_ALUMNO AND LENGTH(TOKEN) < 50";
            break;
        case 'alumno':
            $sql = "UPDATE tbl_avisos_alumno SET TITULO_AVISO='{$titulo}', DESCRIPCION_AVISO='{$contenido}', IMAGEN_AVISO='{$imagen}', FECHA_INICIAL='{$fechai}', FECHA_FINAL='{$fechaf}', ID_ADMIN=$idadmin, ID_ALUMNO=$destinatario WHERE ID_AVISO = $idAviso";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.ID_ALUMNO=$destinatario AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND LENGTH(TOKEN) < 50";
            break;
    }
    if(mysqli_query($conn,$sql)===FALSE)
        die("SQL ERROR: ".mysqli_error($conn));
    
    if($foto["name"]!="")
        move_uploaded_file($foto['tmp_name'],$ruta);

    if($notificar=="on"){
        $result = mysqli_query($conn,$sqlTokens);
        if(!$result)
            die("SQL ERROR: ".mysqli_error($conn));

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $tokens[] = $row["TOKEN"];
            }
            $message = array('Message' => " La institucion acaba de publicar un aviso. Enterate ahora!!", 'Title' => $titulo, 'body' => $contenido, 'FechaI' => $fechai, 'FechaF' => $fechaf);
            $tipo = "Aviso ".$tipo;
            sendMessage($tokens, $message, $tipo);
        }
    }
    die("UPDATED");
}
function sendMessage($tokens, $message, $tipo){
    $content = array(
        "en" => $tipo . ': Tienes un nuevo aviso del colegio. Checalo ya! '
    );
    $headings = array(
        "en" => $message["Title"]
    );
    $fields = array(
        'app_id' => "775aebac-196e-43bd-9a15-19903cf07d9d",
        'include_player_ids' => $tokens,
        'data' => $message,
        'contents' => $content,
        'headings' => $headings,
    );

    $fields = json_encode($fields);
    //print("\nJSON sent:\n");
    //print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ZTJiMTIwNDgtZjZmOS00ODBhLTkzOWMtZjBiNTM1ODJlNmRm'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
function resendAviso($idaviso,$tipo,$destinatario){
    include 'database.php';
    switch ($tipo) {
        case 'general':
            $sql = "SELECT * FROM tbl_avisosgenerales WHERE ID_AVISO = $idaviso";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios WHERE USUTIPO = 'A' AND EXISTE = 1 AND TOKEN <> '' AND LENGTH(TOKEN) < 50 ";
            break;
        case 'nivel':
            $sql = "SELECT * FROM tbl_avisos_nivel WHERE ID_AVISO = $idaviso";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.NIVEL=$destinatario AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND LENGTH(TOKEN) < 50";
            break;
        case 'grupo':
            $sql = "SELECT * FROM tbl_avisos_grupo WHERE ID_AVISO = $idaviso";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos, tbl_asignaciongrupos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND tbl_asignaciongrupos.ID_GRUPO = $destinatario AND tbl_asignaciongrupos.ID_ALUMNO = tbl_alumnos.ID_ALUMNO AND LENGTH(TOKEN) < 50";
            break;
        case 'alumno':
            $sql = "SELECT * FROM tbl_avisos_alumno WHERE ID_AVISO = $idaviso";
            $sqlTokens = "SELECT TOKEN FROM tbl_usuarios, tbl_alumnos WHERE USUTIPO = 'A' AND tbl_usuarios.EXISTE = 1 AND TOKEN <> '' AND tbl_alumnos.ID_ALUMNO=$destinatario AND tbl_alumnos.ID_USUARIO = tbl_usuarios.ID_USUARIO AND LENGTH(TOKEN) < 50";
            break;
    }
    $result = mysqli_query($conn,$sql);
    if(!$result)
        die("SQL ERROR: ".mysqli_error($conn));

    $aviso = mysqli_fetch_array($result);

    $result = mysqli_query($conn,$sqlTokens);
    if(!$result)
        die("SQL ERROR: ".mysqli_error($conn));

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $tokens[] = $row["TOKEN"];
        }
        $message = array('Message' => " La institucion acaba de publicar un aviso, Veelo ahora!!", 'Title' => $aviso[1], 'body' => $aviso[2], 'FechaI' => $aviso[3], 'FechaF' => $aviso[4]);
        $tipo = "Aviso ".$tipo;
        sendMessage($tokens, $message, $tipo);
    }

    die("SEND");
}
function eliminarAviso($idaviso, $tipo){
    include 'database.php';

    switch ($tipo) {
        case 'general':
            $sql = "UPDATE tbl_avisosgenerales SET EXISTE = 0 WHERE ID_AVISO = {$idaviso}";
            break;
        case 'nivel':
            $sql = "UPDATE tbl_avisos_nivel SET EXISTE = 0 WHERE ID_AVISO = {$idaviso}";
            break;
        case 'grupo':
            $sql = "UPDATE tbl_avisos_grupo SET EXISTE = 0 WHERE ID_AVISO = {$idaviso}";
            break;
        case 'alumno':
            $sql = "UPDATE tbl_avisos_alumno SET EXISTE = 0 WHERE ID_AVISO = {$idaviso}";
            break;
    }
    $result = mysqli_query($conn, $sql);
    if(!$result){die("SQL ERROR: ".mysqli_error($conn));}
    die("DELETED");
}


session_name("webSession");
session_start();
if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='S' && isset($_POST["opcion"])){
    $opcion = $_POST['opcion'];

    switch ($opcion) {
        case 'GETGPOS':
            getGrupos();
            break;
        case 'GETALUMNOS':
            getAlumnos();
            break;
        case 'EDITAR':
            $idAviso = $_POST["idAviso"];
            $notificar = (isset($_POST["notificar"]) ? $_POST["notificar"] : "");
            $tipo = $_POST["tipo"];
            $destinatario = (isset($_POST["destinatario"]) ? $_POST["destinatario"] : "");
            $titulo = $_POST["titulo"];
            $contenido = $_POST["contenido"];
            $fechai = $_POST["fechaI"];
            $fechaf = $_POST["fechaF"];
            $idadmin = $_SESSION["ID_ADMIN"];
            $foto = $_FILES['imagen'];
            $imgName = $_POST['imgName'];
            repostAviso($tipo,$destinatario,$idAviso,$notificar,$titulo,$contenido,$fechai,$fechaf,$idadmin,$foto,$imgName);
            break;
        case 'REGISTRAR':
            $tipo = $_POST["tipo"];
            $destinatario = (isset($_POST["destinatario"]) ? $_POST["destinatario"] : "");
            $titulo = $_POST["titulo"];
            $contenido = $_POST["contenido"];
            $fechai = $_POST["fechaI"];
            $fechaf = $_POST["fechaF"];
            $idadmin = $_SESSION["ID_ADMIN"];
            $foto = $_FILES['imagen'];
            postAviso($tipo,$destinatario,$titulo,$contenido,$fechai,$fechaf,$idadmin,$foto);
            break;
        case 'ELIMINAR':
            $idAviso = $_POST["idAviso"];
            $tipo = $_POST["tipo"];
            eliminarAviso($idAviso,$tipo);
            break;
        case 'RESEND':
            $idAviso = $_POST["idAviso"];
            $tipo = $_POST["tipo"];
            $destinatario = (isset($_POST["destinatario"]) ? $_POST["destinatario"] : "");
            resendAviso($idAviso,$tipo,$destinatario);
            break;
    }
}else{
    
}
?>