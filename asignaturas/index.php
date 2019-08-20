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
    <title>Control Integral Indira Gandhi | Asignaturas</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendors/fontawesome-5.7.2-web/css/all.min.css">
    <!--Sweetalert-->
    <link rel="stylesheet" href="../vendors/sweetalert/sweetalert.css">

    <!--DataTables-->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendors/nprogress/nprogress.css">
    <!-- Custom Theme Style -->
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

        .max {
            min-width: 47px;
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
                                <li><a href="../inicio/"><i class="fa fa-home"></i>Inicio</a>
                                </li>
                                <li><a><i class="fas fa-user-friends"></i>Administradores</a>
                                </li>
                                <li><a href="../doc/"><i class="fas fa-chalkboard-teacher"></i>Docentes</a>
                                </li>
                                <li><a><i class="fas fa-user-graduate"></i>Alumnos <span
                                            class="fa fa-chevron-down"></span></a>
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
                                <li class="active"><a><i class="fas fa-chalkboard"></i>Asignaturas</a></li>
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
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="../images/user3.jpg" alt=""><span
                                        style="color:#D9DEE4; font-weight: bold;"><?php echo $_SESSION['NOMBRE']; ?></span>
                                    <span class=" fa fa-angle-down" style="color:#D9DEE4; font-weight: bold;"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a class="logout"><i class="fa fa-sign-out-alt pull-right"></i>Cerrar sesión</a>
                                    </li>
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
                        <h3>Asignaturas de Secundaria</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- Activos -->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Lista de Asignaturas</h2>
                                <ul class="nav navbar-right panel_toolbox" style="min-width: 0px;">
                                    <li><a id="addAsig" data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="Agregar Asignatura">
                                            <span class="fas fa-chalkboard" aria-hidden="true"
                                                style="color:green;"></span>
                                        </a></li>
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table id="asigtable" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="head">#</th>
                                                <th scope="col" class="head">Asignatura</th>
                                                <th scope="col" class="head">Docente</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
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
    <!-- Modal -->
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form id="admin-form" class="form-horizontal form-label-left input_mask">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal-title">Datos de la Asignatura</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idasignatura" name="idasignatura">
                        <input type="hidden" id="opcion" name="opcion" value="REGISTRAR">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <label for="asignatura">Asignatura</label>
                                <input type="text" class="form-control" id="asignatura" name="asignatura"
                                    placeholder="Asignatura" required>
                                <span class="fas fa-chalkboard form-control-feedback right" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <label for="docente">Docente</label>
                                <select name="docente" id="docente" class="form-control docs" required></select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="margin-top: 2%;">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--/Modal-->
    <!--ModalConfirm-->
    <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form id="form-delete">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal-title">Mensaje de Confirmación</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idasigTodelete" name="idasignatura">
                        <input type="hidden" id="opcion2" name="opcion" value="ELIMINAR">
                        <div id="message-confirm">

                        </div>
                    </div>
                    <div class="modal-footer" style="margin-top: 2%;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--/ModalConfirm---->
    <!-- jQuery-->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap-->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--Sweetalert-->
    <script src="../vendors/sweetalert/sweetalert.min.js"></script>
    <!--DataTables-->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <script src="../build/js/custom.js"></script>
    <script src="index.js"></script>
</body>

</html>