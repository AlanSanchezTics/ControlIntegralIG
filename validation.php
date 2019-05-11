<?php
    include 'database.php';
    
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $user = $_POST['username'];
        $clave = $_POST['password'];

        $sql="SELECT tbl_administradores.ID_ADMIN, tbl_usuarios.ID_USUARIO, tbl_administradores.NOMBRE, tbl_usuarios.USUTIPO FROM tbl_administradores,tbl_usuarios WHERE tbl_usuarios.LOGIN = '{$user}' AND tbl_usuarios.CLAVE = AES_ENCRYPT('{$clave}','INDIRAGANDHI2017') AND tbl_administradores.ID_USUARIO = tbl_usuarios.ID_USUARIO";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            die("SQL ERROR: ". mysqli_error($conn));
        }

        if(mysqli_num_rows($result) > 0){
            if ($row = mysqli_fetch_array($result)) {
                session_name("webSession");
                session_start();
                $_SESSION['ID_ADMIN'] = $row[0];
                $_SESSION['id_USUARIO'] = $row[1];
                $_SESSION['NOMBRE'] = $row[2];
                $_SESSION['TIPO'] = $row[3];
            }
            $json = array(
                'response' =>'DONE',
                'dashboard' =>$_SESSION['TIPO']
            );
            die(json_encode($json));
        }else{
            $sql = "SELECT tbl_docentes.ID_DOCENTE, tbl_usuarios.ID_USUARIO, tbl_docentes.NOMBRE, tbl_usuarios.USUTIPO FROM tbl_docentes,tbl_usuarios WHERE tbl_usuarios.LOGIN = '{$user}' AND tbl_usuarios.CLAVE = AES_ENCRYPT('{$clave}','INDIRAGANDHI2017') AND tbl_docentes.ID_USUARIO = tbl_usuarios.ID_USUARIO";
            $result = mysqli_query($conn,$sql);
            if(!$result){
                die("SQL ERROR: ". mysqli_error($conn));
            }
            if(mysqli_num_rows($result) > 0){
                if ($row = mysqli_fetch_array($result)) {
                    session_name("webSession");
                    session_start();
                    $_SESSION['ID_DOCENTE'] = $row[0];
                    $_SESSION['id_USUARIO'] = $row[1];
                    $_SESSION['NOMBRE'] = $row[2];
                    $_SESSION['TIPO'] = $row[3];
                }
                $json = array(
                    'response' =>'DONE',
                    'dashboard' =>$_SESSION['TIPO']
                );
                die(json_encode($json));
            }
        }
        $json = array('response' => 'DENIED');
        die(json_encode($json));
    }
?>