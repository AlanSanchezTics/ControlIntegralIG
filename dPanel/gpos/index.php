<?php
    include_once '../../error_log.php';
    set_error_handler('error');
    session_name("webSession");
    session_start();
    if( !(isset($_SESSION['TIPO'])) || $_SESSION['TIPO']!='D'){
        session_destroy();
        die(header('Location: ../../page_404.html'));
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
    <link rel="shortcut icon" type="image/x-icon" href="../../icon.ico">
    <title>Control Integral Indira Gandhi | Mis Grupos</title>

    <!-- Bootstrap -->
    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../vendors/fontawesome-5.7.2-web/css/all.min.css" />
    <!--DataTables-->
    <link href="../../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="../../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link href="../../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css">
    <!-- Custom Theme Style -->
    <link rel="stylesheet" href="../../vendors/nprogress/nprogress.css">
    <link href="../../build/css/custom.min.css" rel="stylesheet" />

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

        .max {
            min-width: 100px;
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
                            <img src="../../images/user3.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Hola,</span>
                            <h2>
                                <?php echo $_SESSION["NOMBRE"]; ?>
                            </h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="../inicio/"><i class="fa fa-home"></i>Inicio</a>
                                </li>
                                <li class="active"><a><i class="fas fa-users"></i>Grupos</a>
                                </li>
                                <li><a href="../Tareas/"><i class="fas fa-book-open"></i>Tareas</a>
                                </li>
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
                                    <img src="../../images/user3.jpg" alt=""><span style="color:#D9DEE4; font-weight: bold;">
                                    <?php echo $_SESSION["NOMBRE"]; ?></span>
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
                <div class="page-title">
                    <div class="title_left">
                        <h3>Panel de Grupos</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- Activos -->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Lista de Alumnos</h2>
                                <ul class="nav navbar-right panel_toolbox" style="min-width: 0px;">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        
                                    </ul>
                                    <div id="myTabContent" class="tab-content">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Activos -->
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>
    <!-- jQuery-->
    <script src="../../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap-->
    <script src="../../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--DataTables-->
    <script src="../../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../../vendors/nprogress/nprogress.js"></script>
    <script src="../../build/js/custom.js"></script>
    <script src="data.js"></script>
</body>

</html>