<?php
    include_once '../error_log.php';
    set_error_handler('error');
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
    function getAlumno($no_control){
        include '../database.php';
        $sql = "SELECT tbl_alumnos.ID_ALUMNO,tbl_alumnos.NOMBRE, tbl_alumnos.A_PATERNO, tbl_alumnos.A_MATERNO, tbl_alumnos.TEL, tbl_alumnos.EMAIL, tbl_usuarios.LOGIN, tbl_usuarios.ID_USUARIO, tbl_alumnos.FECHA_INGRESO, tbl_alumnos.FECHA_EGRESO,tbl_alumnos.imagen, tbl_grupos.GRADO, tbl_grupos.NOMBRE, tbl_grupos.NIVEL, tbl_alumnos.EXISTE FROM `tbl_asignaciongrupos`,tbl_alumnos,tbl_grupos, tbl_usuarios WHERE tbl_alumnos.ID_USUARIO=tbl_usuarios.ID_USUARIO AND tbl_asignaciongrupos.ID_GRUPO = tbl_grupos.ID_GRUPO AND tbl_asignaciongrupos.ID_ALUMNO = tbl_alumnos.ID_ALUMNO AND tbl_alumnos.ID_ALUMNO = {$no_control}";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0 ){
            if($row = mysqli_fetch_array($result)){
                $json[] = array(
                    'id' => $row[0],
                    'nombre' => $row[1]." ".$row[2]." ".$row[3],
                    'telefono' => $row[4],
                    'email' => $row[5],
                    'usuario' => $row[6],
                    'fi'=> $row[8],
                    'fe' => $row[9],
                    'imagen'=> $row[10],
                    'grado' => $row[11],
                    'grupo' =>$row[12],
                    'nivel' => setNivel($row[13]),
                    'estado' => ($row[14]==0 ? "Desactivado":"Activo")
                ); 
            }
            echo json_encode($json);
        }else{
            echo json_encode("empty");
        }
    }
    function getDocs($gpo, $gdo, $nivel){
        include '../database.php';
        $sqldoce = "SELECT tbl_docentes.NOMBRE, tbl_docentes.A_PATERNO, tbl_docentes.A_MATERNO FROM `tbl_grupos`,tbl_docentes WHERE tbl_grupos.ID_DOCENTE_E = tbl_docentes.ID_DOCENTE AND NIVEL={$nivel} AND GRADO= {$gdo} AND tbl_grupos.NOMBRE='{$gpo}'";
        $sqldoci = "SELECT tbl_docentes.NOMBRE, tbl_docentes.A_PATERNO, tbl_docentes.A_MATERNO FROM `tbl_grupos`,tbl_docentes WHERE tbl_grupos.ID_DOCENTE_I = tbl_docentes.ID_DOCENTE AND NIVEL={$nivel} AND GRADO= {$gdo} AND tbl_grupos.NOMBRE='{$gpo}'";
        $resultdoce=mysqli_query($conn,$sqldoce);
        $resultdoci=mysqli_query($conn,$sqldoci);
        $reg1=mysqli_fetch_array($resultdoce);
        $reg2=mysqli_fetch_array($resultdoci);
        $json['data']['esp']=array(
            'nombre'=>$reg1[0],
            'apaterno'=>$reg1[1],
            'amaterno'=>$reg1[2]
        );
        $json['data']['ing']=array(
            'nombre'=>$reg2[0],
            'apaterno'=>$reg2[1],
            'amaterno'=>$reg2[2]
        );
        echo json_encode($json);
    }
    function nuevoAlumno($no_control,$nombre, $a_paterno, $a_materno,$telefono, $email, $nivel, $gdo, $gpo, $fechaI, $fechaf, $foto){
        include '../database.php';
        mysqli_autocommit($conn, FALSE);
        $sql = "SELECT ID_ALUMNO FROM tbl_alumnos WHERE ID_ALUMNO = {$no_control}";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            die("SQL ERROR 29: ". mysqli_error($conn));
        }
        $alumns = mysqli_num_rows($result);
        if($alumns > 0){
            die('EXISTALUMN');
        }

        $sql = "SELECT ID_GRUPO FROM tbl_grupos WHERE NIVEL = {$nivel} AND GRADO = {$gdo} AND NOMBRE = '{$gpo}'";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            die("SQL ERROR 39: ". mysqli_error($conn));
        }else if(mysqli_num_rows($result) == 0){
            die('WRONGGROUP');
        }

        $idgrupo = mysqli_fetch_array($result);
        $usuario = date("Y").$no_control;
        $contraseña=$usuario;
        
        if($foto["name"]==""){
            $nombreimagen = "https://www.ciaigandhi.com/almns/images/Untitled.png";
        }else{
            $imagen=$foto['name'];
            $tipoarchivo=$foto['type'];
            $rest = substr($tipoarchivo,6);                            
            $ruta="images/".$no_control.".".$rest;
            $nombreimagen="https://www.ciaigandhi.com/almns/".$ruta;
        }
        
        $sql = "INSERT INTO tbl_usuarios(login,clave,usutipo,existe) VALUES ('".$usuario."',AES_ENCRYPT('".$contraseña."','INDIRAGANDHI2017'),'A',1)";
        if($conn -> query($sql) === TRUE){
            $sql = "SELECT ID_USUARIO FROM tbl_usuarios WHERE LOGIN = '{$usuario}'";
            $result = $conn -> query($sql);
            $idusu = $result -> fetch_array();
            
            $sql = "INSERT INTO tbl_alumnos(id_alumno,nombre,a_paterno,a_materno,grado,tel,email,nivel,fecha_ingreso,fecha_egreso,id_usuario,imagen,existe) VALUES('{$no_control}', '{$nombre}', '{$a_paterno}', '{$a_materno}', {$gdo}, '{$telefono}', '{$email}',{$nivel}, '{$fechaI}', '{$fechaf}', {$idusu[0]}, '{$nombreimagen}',1)";
            if($conn -> query($sql) === TRUE){
                $sql = "INSERT INTO tbl_asignaciongrupos(id_grupo,id_alumno,existe) VALUES (".$idgrupo[0].",".$no_control.",1)";
                if($conn -> query($sql) === TRUE){
                    if($foto["name"]!=""){
                        move_uploaded_file($foto['tmp_name'],$ruta);
                    }
                    mysqli_commit($conn);
                    die("ADDED");
                }else{
                    $error = mysqli_error($conn);
                    mysqli_rollback($conn);
                    die("QUERY ERROR: ". $error);
                }
            }else{
                $error = mysqli_error($conn);
                mysqli_rollback($conn);
                die("QUERY ERROR: ". $error);
            }
        }else{
            $error = mysqli_error($conn);
            mysqli_rollback($conn);
            die("QUERY ERROR: ". $error);
        }
    }
    function modAlumno($no_control,$nombre, $a_paterno, $a_materno, $telefono, $email, $nivel, $gdo, $gpo, $fechaI, $fechaF, $foto, $iduser){
        include '../database.php';
        mysqli_autocommit($conn, FALSE);

        $sql = "SELECT ID_ALUMNO FROM tbl_alumnos WHERE ID_ALUMNO = {$no_control} AND ID_USUARIO <> {$iduser}";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            die("SQL ERROR: ".mysqli_error($conn));
        }
        $alumns = mysqli_num_rows($result);
        if($alumns >0){
            die("EXISTALUMN");
        }
        $sql = "SELECT ID_GRUPO FROM tbl_grupos WHERE NIVEL = {$nivel} AND GRADO = {$gdo} AND NOMBRE = '{$gpo}'";
        $result = mysqli_query($conn,$sql);
        if(!$result){
            die("SQL ERROR: ". mysqli_error($conn));
        }else if(mysqli_num_rows($result) == 0){
            die('WRONGGROUP');
        }
        $idgrupo = mysqli_fetch_array($result);
        $sql = "SELECT LOGIN FROM tbl_usuarios WHERE ID_USUARIO = {$iduser}";
        $result = mysqli_query($conn,$sql);
        $usuario = mysqli_fetch_array($result);
        $clave=$usuario;

        if($foto["name"]==""){
            $sql = "SELECT IMAGEN FROM tbl_alumnos WHERE ID_USUARIO = {$iduser}";
            $reg = mysqli_fetch_array(mysqli_query($conn, $sql));
            $nombreimagen = $reg[0];
        }else{
            $imagen=$foto['name'];
            $tipoarchivo=$foto['type'];
            $rest = substr($tipoarchivo,6);                           
            $ruta="images/".$no_control.".".$rest;
            $nombreimagen="https://www.ciaigandhi.com/almns/".$ruta;                            
            #move_uploaded_file($foto['tmp_name'],$ruta);
        }

        // $sql = "UPDATE tbl_usuarios SET LOGIN = '{$usuario}', CLAVE = AES_ENCRYPT('{$clave}','INDIRAGANDHI2017') WHERE ID_USUARIO = {$iduser}";
        // if($conn -> query($sql)==FALSE){
        //     $error = mysqli_error($conn);
        //     mysqli_rollback($conn);
        //     die("QUERY ERROR: ". $error);
        // }
        $sql = " UPDATE tbl_alumnos SET ID_ALUMNO = {$no_control}, NOMBRE = '{$nombre}', A_PATERNO = '{$a_paterno}', A_MATERNO = '{$a_materno}', GRADO = {$gdo}, TEL = '{$telefono}', EMAIL = '{$email}', NIVEL = {$nivel}, FECHA_INGRESO = '{$fechaI}', FECHA_EGRESO = '{$fechaF}', IMAGEN = '{$nombreimagen}' WHERE ID_USUARIO ={$iduser}";
			if($conn -> query($sql) == TRUE){
				$sql="UPDATE tbl_asignaciongrupos SET id_grupo={$idgrupo[0]} where id_alumno={$no_control}";
				if($conn -> query($sql) == TRUE){
                    if($foto["name"]!=""){
                        move_uploaded_file($foto['tmp_name'],$ruta);
                    }
                    mysqli_commit($conn);
                    die("UPDATED");
				}else{
                    $error = mysqli_error($conn);
                    mysqli_rollback($conn);
                    die("QUERY ERROR: ". $error);
                }
			}else{
                $error = mysqli_error($conn);
                mysqli_rollback($conn);
                die("QUERY ERROR: ". $error);
            }
    }
    function borrarAlumno($no_control, $iduser){
        include '../database.php';
        mysqli_autocommit($conn, FALSE);

        $sql = "UPDATE tbl_alumnos SET EXISTE = 0 WHERE ID_ALUMNO = {$no_control}";
		if($conn -> query($sql) == TRUE){
			$sql = "UPDATE tbl_usuarios SET EXISTE = 0 WHERE ID_USUARIO = {$iduser}";
			if($conn -> query($sql) == TRUE){
                mysqli_commit($conn);
				die("DELETED");
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

    session_name("webSession");
    session_start();
    if(isset($_SESSION['TIPO']) && $_SESSION['TIPO']=='S' && isset($_POST["opcion"])){
        $opcion=$_POST["opcion"];

        switch ($opcion) {
            case 'GETDOCS':
                $gpo=$_POST["gpo"];
                $gdo=$_POST["gdo"];
                $nivel = $_POST['nivel']; 
                getDocs($gpo, $gdo, $nivel);
                break;
            case 'REGISTRAR':
                $no_control = $_POST['ncontrol'];
                $nombre = $_POST['nombre'];
                $a_paterno = $_POST['a-paterno']; 
                $a_materno = $_POST['a-materno'];
                $telefono = $_POST['telefono']; 
                $email = $_POST['email']; 
                $nivel = $_POST['nivel']; 
                $fechaI = $_POST['fechaI']; 
                $fechaf = $_POST['fechaF']; 
                $foto = $_FILES['foto'];
                $gpo=$_POST["gpo"];
                $gdo=$_POST["gdo"];
                nuevoAlumno($no_control,$nombre, $a_paterno, $a_materno,$telefono, $email, $nivel, $gdo, $gpo, $fechaI, $fechaf, $foto);
            break;
            case 'EDITAR':
                $iduser = $_POST["iduser"];
                $no_control = $_POST['ncontrol'];
                $nombre = $_POST['nombre'];
                $a_paterno = $_POST['a-paterno']; 
                $a_materno = $_POST['a-materno'];
                $telefono = $_POST['telefono']; 
                $email = $_POST['email']; 
                $nivel = $_POST['nivel']; 
                $fechaI = $_POST['fechaI']; 
                $fechaF = $_POST['fechaF']; 
                $foto = $_FILES['foto'];
                $gpo=$_POST["gpo"];
                $gdo=$_POST["gdo"];
                modAlumno($no_control,$nombre, $a_paterno, $a_materno, $telefono, $email, $nivel, $gdo, $gpo, $fechaI, $fechaF, $foto, $iduser);
            break;
            case 'ELIMINAR':
                $iduser = $_POST["iduser"];
                $no_control = $_POST['ncontrol'];
                borrarAlumno($no_control, $iduser);
                break;
            case 'BUSCAR':
                $no_control = $_POST["ncontrol"];
                getAlumno($no_control);
                break;
        }
    }else{
        header("HTTP/1.0 404 Not Found");
    }
?>