<?php
	$json =file_get_contents("php://input");
	$obj = json_decode($json,true);
	$grupo = $obj["grupo"];
	$tipo = $obj["tipo"];
	include "database.php";
    $sql = "SELECT ID_TAREA, TITULO_TAREA, DESCRIPCION_TAREA, FECHA_CREACION, FECHA_ENTREGA, tbl_docentes.NOMBRE, tbl_docentes.A_PATERNO FROM tbl_tareas, tbl_docentes WHERE ID_GRUPO = {$grupo} AND TIPO_TAREA = '{$tipo}' AND tbl_tareas.ID_DOCENTE = tbl_docentes.ID_DOCENTE AND tbl_tareas.FECHA_ENTREGA >= CURRENT_TIMESTAMP AND tbl_tareas.EXISTE = 1 ORDER BY ID_TAREA DESC";
    $result = mysqli_query($conexion,$sql);
	
	if($sql){
		while($reg = mysqli_fetch_array($result)){
			$arreglo[] = array('id' => $reg[0],'titulo' => $reg[1],'descripcion' => $reg[2],'fechaCreacion' => $reg[3],'entrega' => $reg[4], 'docenteName' => $reg[5], 'docenteAp' => $reg[6]);
		}
		$datos = json_encode($arreglo);
	}
	echo($datos);
    ?>

