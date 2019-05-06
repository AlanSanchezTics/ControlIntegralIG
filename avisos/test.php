<?php

    if(isset($_POST)){
        $tipo = $_POST["tipo"];
        $destinatario = $_POST["destinatario"];
        $titulo = $_POST["titulo"];
        $contenido = $_POST["contenido"];
        $fechai = $_POST["fechaI"];
        $fechaf = $_POST["fechaF"];
        $foto = $_FILES['imagen'];
        $imagen=$foto['name'];
        $tipoarchivo=$foto['type'];
        $rest = substr($tipoarchivo,6);                            
        $ruta="images/".$no_control.".".$rest;
        $nombreimagen="https://www.ciaigandhi.com/AlumnosPanel/".$ruta;
        $json = array(
            'tipo' => $tipo,
            'destinatario' => $destinatario,
            'titulo' => $titulo,
            'contenido' => $contenido,
            'fechai' => $fechai,
            'fechaf' => $fechaf,
            'foto' =>$foto['tmp_name']
        );
        echo json_encode($json);
    }

?>