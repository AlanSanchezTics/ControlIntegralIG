<?php
include_once '../error_log.php';
set_error_handler('error');
$json =file_get_contents("php://input");
$obj = json_decode($json,true);
$arreglo = array();
$alumno = $obj['idAlumno'];

	include "database.php";
	
	$sql = "SELECT NOMBRE, A_PATERNO, A_MATERNO, GRADO, TEL, EMAIL, NIVEL, FECHA_INGRESO, FECHA_EGRESO, IMAGEN FROM tbl_alumnos WHERE ID_ALUMNO='{$alumno}' AND tbl_alumnos.EXISTE= 1";
	$result = mysqli_query($conexion,$sql);
	
	if($sql){
		if($reg = mysqli_fetch_array($result)){
			$arreglo = array(
				'name' => $reg['NOMBRE'], 
				'A_paterno' => $reg['A_PATERNO'],
				'A_materno' => $reg['A_MATERNO'],
				'grado' => $reg['GRADO'],
				'telefono' => $reg['TEL'],
				'correo' => $reg['EMAIL'],
				'nivel' => setNivel($reg['NIVEL']),
				'fechaI' => $reg['FECHA_INGRESO'],
				'fechaF' => $reg['FECHA_EGRESO'],
				'foto' => $reg['IMAGEN'] 
			);
		}
		echo json_encode($arreglo);
	}
	function setNivel($e){
        $nivel = "";
        switch ($e) {
            case '0':
                $nivel = "Pre-kinder";
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