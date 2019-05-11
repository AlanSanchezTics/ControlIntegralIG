<?php
    include '../error_log.php';
    set_error_handler('error');
    session_name("webSession");
    session_start();
    if( !(isset($_SESSION['TIPO'])) || $_SESSION['TIPO']!='S'){
        session_destroy();
        die(header('Location: ../page_404.html'));
    }else{
        header('Location:indexPK.php');
    }
?>