<?php
    function error($numero,$texto,$archivo,$linea){ 
        $ddf = fopen('error.log','a'); 
        fwrite($ddf,"[".date("Y-m-d H:i:s")."] Error en archivo $archivo(linea $linea): $numero:$texto\r\n"); 
        fclose($ddf); 
    } 
?>