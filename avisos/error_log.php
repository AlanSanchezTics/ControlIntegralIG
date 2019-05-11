<?php
    function error($numero,$texto){ 
        $ddf = fopen('error.log','a'); 
        fwrite($ddf,"[".date("Y-m-d H:i:s")."] Error $numero:$texto\r\n"); 
        fclose($ddf); 
    } 
    set_error_handler('error');
?>