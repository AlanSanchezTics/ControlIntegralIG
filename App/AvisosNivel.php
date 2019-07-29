<?php
	include_once '../error_log.php';
	set_error_handler('error');
	$json =file_get_contents("php://input");
	$obj = json_decode($json,true);
	$idAlumno = $obj["idAlumno"];
	
	include "database.php";
	$sql = "SELECT ID_AVISO, TITULO_AVISO, DESCRIPCION_AVISO, IMAGEN_AVISO, FECHA_INICIAL, FECHA_FINAL FROM tbl_avisos_nivel WHERE  NIVEL= (SELECT NIVEL FROM tbl_alumnos WHERE ID_ALUMNO = {$idAlumno}) AND EXISTE = 1 AND FECHA_INICIAL <= CURRENT_TIMESTAMP AND FECHA_FINAL >= CURRENT_TIMESTAMP ORDER BY ID_AVISO DESC";
	$result = mysqli_query($conexion,$sql);
	
	if($sql){
		while($reg = mysqli_fetch_array($result)){
			$arreglo[] = array(
				'idAviso' => $reg["ID_AVISO"],
				'titulo' => $reg["TITULO_AVISO"],
				'descripcion' => $reg["DESCRIPCION_AVISO"],
				'imagen' => $reg["IMAGEN_AVISO"],
				'fechaEm' => $reg["FECHA_INICIAL"],
				'fechaAC' => $reg["FECHA_FINAL"]
			);
		}
		$datos = json_encode($arreglo);
	}
	echo($datos);
?>