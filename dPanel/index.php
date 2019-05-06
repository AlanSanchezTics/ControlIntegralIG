<?php
    session_name("webSession");
    session_start();
    if( !(isset($_SESSION['TIPO'])) || $_SESSION['TIPO']!='D'){
        session_destroy();
        die(header('Location: ../page_404.html'));
    }else{
        header('Location:./inicio/');
    }
?>