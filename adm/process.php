<?php
include_once '../error_log.php';
set_error_handler('error');
function ActualizarData($id_admin,$nombre, $a_paterno, $a_materno, $email,$telefono,$usuario, $clave, $nclave,$iduser){
    include '../database.php';
    $sql="SELECT ID_ADMIN FROM tbl_administradores WHERE ID_ADMIN <> ".$id_admin." and nombre='".$nombre."' and a_paterno = '".$a_paterno."' and a_materno='".$a_materno."'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("SQL ERROR 7: ". mysqli_error($conn));
    }
    $admin = mysqli_num_rows($result);
    $sql = "SELECT ID_USUARIO FROM tbl_usuarios WHERE ID_USUARIO <> {$iduser} AND tbl_usuarios.LOGIN = '{$usuario}'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("SQL ERROR 13: ". mysqli_error($conn));
    }
    $users = mysqli_num_rows($result);
    if($admin > 0){
        die("EXISTADMIN");
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
    

    $sql = "UPDATE tbl_administradores SET nombre= '".$nombre."', a_paterno='".$a_paterno."',a_materno= '".$a_materno."',tel= '".$telefono."',email= '".$email."' WHERE id_admin=".$id_admin." ";
    if ($conn->query($sql) === FALSE){
        die("SQL ERROR 36: " . mysqli_error($conn));
    }
    $sql = "UPDATE tbl_usuarios SET LOGIN = '{$usuario}' WHERE ID_USUARIO= {$iduser}";
    if($conn->query($sql) === FALSE){
        die("SQL ERROR 40: ". mysqli_error($conn));
    }
    if($clave != "" && $nclave != ""){
        $sql = "UPDATE tbl_usuarios SET CLAVE = AES_ENCRYPT('{$nclave}','INDIRAGANDHI2017') WHERE ID_USUARIO= {$iduser}";
        if($conn->query($sql) === FALSE){
            die("SQL ERROR 45: ". mysqli_error($conn));
        }
    }
    echo "UPDATED";
}
function EliminarData($id_admin,$iduser){
    include '../database.php';
    $sql = "UPDATE tbl_administradores SET existe = 0 WHERE ID_ADMIN = {$id_admin}";
    if (mysqli_query($conn,$sql)===TRUE) {
        $sql = "UPDATE tbl_usuarios SET EXISTE = 0 WHERE ID_USUARIO = {$iduser}";
        if(mysqli_query($conn,$sql)===TRUE){
            echo "DELETED";
        }else{
            die("SQL ERROR 58: ".mysqli_error($conn));
        }
    }else{
        die("SQL ERROR 61: ".mysqli_error($conn));
    }
}
function RegistrarData($nombre, $a_paterno, $a_materno, $email,$telefono,$usuario, $clave, $nclave){
    if(valPass($clave, $nclave)===FALSE){
        die("INCOMPATIBLE");
    }
    include '../database.php';
    $sql="SELECT ID_ADMIN FROM tbl_administradores WHERE nombre='".$nombre."' and a_paterno = '".$a_paterno."' and a_materno='".$a_materno."'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("SQL ERROR 72: ". mysqli_error($conn));
    }
    $admin = mysqli_num_rows($result);
    $sql = "SELECT ID_USUARIO FROM tbl_usuarios WHERE tbl_usuarios.LOGIN = '{$usuario}'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        die("SQL ERROR 78: ". mysqli_error($conn));
    }
    $users = mysqli_num_rows($result);
    if($admin > 0){
        die("EXISTADMIN");
    }
    if($users > 0){
        die("EXISTUSER");
    }
    $sql="INSERT INTO tbl_usuarios(login,clave,usutipo,existe) VALUES ('".$usuario."',AES_ENCRYPT('".$clave."','INDIRAGANDHI2017'),'S',1)";
    if ($conn->query($sql) === TRUE) {
        $sql="SELECT ID_USUARIO FROM tbl_usuarios WHERE login='".$usuario."'";
        $resultado = $conn -> query($sql);
        $filas = $resultado -> fetch_array();
        $sql="INSERT INTO tbl_administradores(nombre,a_paterno,a_materno,tel,email,id_usuario,existe) VALUES ('".$nombre."','".$a_paterno."','".$a_materno."','".$telefono."','".$email."',".$filas[0].",1)";
        if ($conn->query($sql) === TRUE) {
            die("ADDED");
        }else{
            $sentencia="DELETE from tbl_usuarios where login='{$usuario}'";
            mysqli_query($conexion,$sentencia);
            die("SQL ERROR 98:". mysqli_error($conn));
        }
    }
}
function ActivarData($id_admin,$iduser){
    include '../database.php';
    $sql="UPDATE tbl_administradores SET EXISTE=1 WHERE ID_ADMIN={$id_admin}";
    if(mysqli_query($conn,$sql)===TRUE){
        $sql="UPDATE tbl_usuarios SET EXIST=1 WHERE ID_USUARIO={$iduser}";
        if(mysqli_query($conn,$sql)===TRUE){
            die("ACTIVED");
        }else{
            die("SQL ERROR 110: ". mysqli_error($conn));
        }
    }else{
        die("SQL ERROR 113: ". mysqli_error($conn));
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
    $id_admin=$_POST["idadmin"];
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
            ActualizarData($id_admin, $nombre, $a_paterno, $a_materno, $email,$telefono,$usuario, $clave, $nclave,$iduser);
            break;
        case 'ELIMINAR':
            EliminarData($id_admin, $iduser);
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
            ActivarData($id_admin,$iduser);
        break;
    }
}else{
    header("HTTP/1.0 404 Not Found");
}
?>