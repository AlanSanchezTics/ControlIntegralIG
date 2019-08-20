<?php
    include_once '../error_log.php';
    set_error_handler('error');
    session_name("webSession");
    session_start();
    if( !(isset($_SESSION['TIPO'])) || $_SESSION['TIPO']!='S'){
        session_destroy();
        die(header('Location: ../page_404.html'));
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../icon.ico">
    <title>Control Integral Indira Gandhi | Inicio</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendors/fontawesome-5.7.2-web/css/all.min.css">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link rel="stylesheet" href="../vendors/animate.css/animate.min.css">
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <style>
        .right_col {
            color: black !important;
        }

        .d-none {
            display: none !important
        }

        .d-block {
            display: block !important
        }
        @media(min-width:576px) {
            .d-sm-block {
                display: block !important
            }
            .d-sm-none {
                display: none !important
            }
        }
        .italic{
            font-family: Monotype Corsiva;
        }
        .paragraph{
            text-align: justify;
        }
    </style>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title">
                        <a class="site_title"><i class="fa fa-cog"></i> <span>Panel de control</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="../images/user3.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Hola,</span>
                            <h2><?php echo $_SESSION['NOMBRE']; ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li class="active"><a><i class="fa fa-home"></i>Inicio</a>
                                </li>
                                <li><a href="../adm/"><i class="fas fa-user-friends"></i>Administradores</a>
                                </li>
                                <li><a href="../doc/"><i class="fas fa-chalkboard-teacher"></i>Docentes</a>
                                </li>
                                <li><a><i class="fas fa-user-graduate"></i>Alumnos <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="../almns/indexPK">Pre kinder</a></li>
                                        <li><a href="../almns/indexK">Preescolar</a></li>
                                        <li><a href="../almns/indexP">Primaria</a></li>
                                        <li><a href="../almns/indexS">Secundaria</a></li>
                                    </ul>
                                </li>
                                <li><a href="../avisos/"><i class="fas fa-bell"></i>Avisos</a>
                                </li>
                                <li><a href="../gpos/"><i class="fas fa-users"></i>Grupos</a>
                                </li>
                                <li><a href="../asignaturas/"><i class="fas fa-chalkboard"></i>Asignaturas</a></li>
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars" style="color:#D9DEE4;"></i></a>
                        </div>
                        <div class="navbar-brand">
                            <span class="d-none d-sm-block">Control Integral del alumno</span>
                            <span class="d-block d-sm-none">CIAIG</span>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="../images/user3.jpg" alt=""><span style="color:#D9DEE4; font-weight: bold;"><?php echo $_SESSION['NOMBRE']; ?></span>
                                    <span class=" fa fa-angle-down" style="color:#D9DEE4; font-weight: bold;"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a class="logout"><i class="fa fa-sign-out-alt pull-right"></i>Cerrar sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col hero" role="main">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="row">
                                <div class="text-center">
                                    <img class="fadeIn animated" src="../images/user3.png" width="110px" height="110px" style="margin-bottom: 10px;"/><br>
                                    <span class="h2">Colegio Indira Gandhi</span>
                                    <p class="h4 italic fadeInDown animated" >Un buen principio para un futuro brillante</p>
                                </div>
                            </div>
                            <div class="row fadeInLeft animated">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <P class="h3 text-center">Misión</P>
                                    <p class="paragraph" style="font-size: 18px;">Brindamos una educación de calidad, desarrollando las competencias en los estudiantes que integren su aprendizaje en la vidad cotidiana fortalecido con los valores, el dominio del idioma ingles y el manejo de la tecnologia.</p>
                                </div>
                                <div class="col-md-6  col-sm-6 col-xs-12">
                                    <P class="h3 text-center">Visión</P>
                                    <p class="paragraph" style="font-size: 18px;">Ser una institución educativa bilingüe que ofrezca servicios de excelencia que permita a sus alumnos desarrollarse en forma autónoma, seguros de si mismos, creativos y participativos, capaces de interactuar exitosamente en el medio en que se desenvuelven.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap-->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <script src="./index.js"></script>
    <script src="../build/js/custom.js"></script>
</body>

</html>