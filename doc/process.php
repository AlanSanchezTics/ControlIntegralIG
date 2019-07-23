<?php
include_once '../error_log.php';
set_error_handler('error');
function ModificarData($id_doc, $nombre, $a_paterno, $a_materno, $telefono,$email,$iduser,$usuario,$clave,$nclave){
    include '../database.php';
    mysqli_autocommit($conn, FALSE);

    $sql="SELECT ID_DOCENTE FROM tbl_docentes WHERE ID_DOCENTE <> ".$id_doc." and nombre='".$nombre."' and a_paterno = '".$a_paterno."' and a_materno='".$a_materno."'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("SQL ERROR: ". mysqli_error($conn));
    }
    $docs = mysqli_num_rows($result);
    $sql = "SELECT ID_USUARIO FROM tbl_usuarios WHERE ID_USUARIO <> {$iduser} AND tbl_usuarios.LOGIN = '{$usuario}'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("SQL ERROR: ". mysqli_error($conn));
    }
    $users = mysqli_num_rows($result);
    if($docs > 0){
        die("EXISTDOC");
    }
    if($users > 0){
        die("EXISTUSER");
    }

    if($clave!="" && $nclave!=""){
        $sql = "SELECT AES_DECRYPT(tbl_usuarios.CLAVE,'INDIRAGANDHI2017') FROM tbl_usuarios WHERE ID_USUARIO = {$iduser}";
        $passwords = mysqli_fetch_array(mysqli_query($conn,$sql));
        if($passwords[0] != $clave){
            die("WRONGPASS");
        }
    }else if($clave !="" && $nclave=="" || $nclave !="" && $clave==""){
        die("EMPTYPASS");
    }

    $sql = "UPDATE tbl_docentes SET nombre= '".$nombre."', a_paterno='".$a_paterno."',a_materno= '".$a_materno."',tel= '".$telefono."',email= '".$email."' WHERE ID_DOCENTE=".$id_doc." ";
    if ($conn->query($sql) === FALSE){
        $error = mysqli_error($conn);
        mysqli_rollback($conn);
        die('QUERY ERROR: '. $error);
    }
    $sql = "UPDATE tbl_usuarios SET LOGIN = '{$usuario}' WHERE ID_USUARIO= {$iduser}";
    if($conn->query($sql) === FALSE){
        $error = mysqli_error($conn);
        mysqli_rollback($conn);
        die('QUERY ERROR: '. $error);
    }
    if($clave != "" && $nclave != ""){
        $sql = "UPDATE tbl_usuarios SET CLAVE = AES_ENCRYPT('{$nclave}','INDIRAGANDHI2017') WHERE ID_USUARIO= {$iduser}";
        if($conn->query($sql) === FALSE){
            $error = mysqli_error($conn);
            mysqli_rollback($conn);
            die('QUERY ERROR: '. $error);
        }
    }
    mysqli_commit($conn);
    echo "UPDATED";
}
function EliminarData($id_doc,$iduser){
    include '../database.php';
    mysqli_autocommit($conn, FALSE);
    $sql = "UPDATE tbl_docentes SET existe = 0 WHERE ID_DOCENTE = {$id_doc}";
    if (mysqli_query($conn,$sql)===TRUE) {
        $sql = "UPDATE tbl_usuarios SET EXISTE = 0 WHERE ID_USUARIO = {$iduser}";
        if(mysqli_query($conn,$sql)===TRUE){
            mysqli_commit($conn);
            echo "DELETED";
        }else{
            $error = mysqli_error($conn);
            mysqli_rollback($conn);
            die('QUERY ERROR: '. $error);
        }
    }else{
        $error = mysqli_error($conn);
        mysqli_rollback($conn);
        die('QUERY ERROR: '. $error);
    }
}
function RegistrarData($nombre, $a_paterno, $a_materno, $email,$telefono,$usuario, $clave, $nclave){
    if(valPass($clave, $nclave)===FALSE){
        die("INCOMPATIBLE");
    }
    include '../database.php';
    mysqli_autocommit($conn, FALSE);
    $sql="SELECT ID_DOCENTE FROM tbl_docentes WHERE nombre='".$nombre."' and a_paterno = '".$a_paterno."' and a_materno='".$a_materno."'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("SQL ERROR: ". mysqli_error($conn));
    }
    $docs = mysqli_num_rows($result);
    $sql = "SELECT ID_USUARIO FROM tbl_usuarios WHERE tbl_usuarios.LOGIN = '{$usuario}'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("SQL ERROR: ". mysqli_error($conn));
    }
    $users = mysqli_num_rows($result);
    if($docs > 0){
        die("EXISTDOC");
    }
    if($users > 0){
        die("EXISTUSER");
    }

    $sql = "INSERT INTO tbl_usuarios(login,clave,usutipo,existe) VALUES ('".$usuario."',AES_ENCRYPT('".$clave."','INDIRAGANDHI2017'),'D',1)";
    if ($conn->query($sql) === TRUE) {
        $sql="SELECT ID_USUARIO FROM tbl_usuarios WHERE login='".$usuario."'";
        $resultado = $conn -> query($sql);
        $filas = $resultado -> fetch_array();
        $sql="INSERT INTO tbl_docentes(nombre,a_paterno,a_materno,tel,email,id_usuario,existe) VALUES ('".$nombre."','".$a_paterno."','".$a_materno."','".$telefono."','".$email."',".$filas[0].",1)";
        if ($conn->query($sql) === TRUE) {
            mysqli_commit($conn);
            die("ADDED");
        }else{
            $error = mysqli_error($conn);
            mysqli_rollback($conn);
            die('QUERY ERROR: '. $error);
        }
    }else{
        $error = mysqli_error($conn);
        mysqli_rollback($conn);
        die('QUERY ERROR: '. $error);
    }
}
function valPass($pass1, $pass2){
    if($pass1===$pass2 && $pass1 !="" && $pass2 !=""){
        return TRUE;
    }else{
        return FALSE;
    }
}

session_name("webSession");
session_start();
if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='S' && isset($_POST["opcion"])){
    $id_doc=$_POST["iddoc"];
    $iduser=$_POST["iduser"];
    $opcion = $_POST["opcion"];

    switch ($opcion) {
        case 'EDITAR':
        $nombre = $_POST["nombre"];
        $a_paterno = $_POST["a-paterno"];
        $a_materno  = $_POST["a-materno"];
        $email = $_POST["email"];
        $telefono  = $_POST["telefono"];
        $usuario = $_POST["usuario"];
        $clave = $_POST["pass"];
        $nclave =$_POST["pass2"];
        ModificarData($id_doc, $nombre, $a_paterno, $a_materno, $telefono,$email,$iduser,$usuario,$clave,$nclave);
            break;
        case 'ELIMINAR':
        EliminarData($id_doc,$iduser);
            break;
        case 'REGISTRAR':
        $nombre = $_POST["nombre"];
        $a_paterno = $_POST["a-paterno"];
        $a_materno  = $_POST["a-materno"];
        $email = $_POST["email"];
        $telefono  = $_POST["telefono"];
        $usuario = $_POST["usuario"];
        $clave = $_POST["pass"];
        $nclave =$_POST["pass2"];
        RegistrarData($nombre, $a_paterno, $a_materno, $email,$telefono,$usuario, $clave, $nclave);
            break;
        case "ACTIVAR":
            
        break;
    }
}else{
    header("HTTP/1.0 404 Not Found");
}
?>