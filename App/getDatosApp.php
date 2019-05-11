<?php
$json =file_get_contents("php://input");
$obj = json_decode($json,true);
$arreglo = array();
$alumno = $obj['idAlumno'];

	include "database.php";
	
	$sql = "SELECT NOMBRE, A_PATERNO, A_MATERNO, GRADO, TEL, EMAIL, NIVEL, FECHA_INGRESO, FECHA_EGRESO, IMAGEN FROM tbl_alumnos WHERE ID_ALUMNO='{$alumno}' AND tbl_alumnos.EXISTE= 1";
	$result = mysqli_query($conexion,$sql);
	
	if($sql){
		if($reg = mysqli_fetch_array($result)){
			$arreglo = array('name' => $reg['NOMBRE'], 'A_paterno' => $reg['A_PATERNO'],'A_materno' => $reg['A_MATERNO'],'grado' => $reg['GRADO'],'telefono' => $reg['TEL'],'correo' => $reg['EMAIL'],'nivel' => $reg['NIVEL'],'fechaI' => $reg['FECHA_INGRESO'],'fechaF' => $reg['FECHA_EGRESO'],'foto' => $reg['IMAGEN'] );
		}
		echo json_encode($arreglo);
	}

?>